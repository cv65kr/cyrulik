package com.cyrulik.account.config;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Primary;
import org.springframework.core.env.Environment;
import org.springframework.data.redis.connection.RedisConnectionFactory;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.oauth2.config.annotation.configurers.ClientDetailsServiceConfigurer;
import org.springframework.security.oauth2.config.annotation.web.configuration.AuthorizationServerConfigurerAdapter;
import org.springframework.security.oauth2.config.annotation.web.configuration.EnableAuthorizationServer;
import org.springframework.security.oauth2.config.annotation.web.configurers.AuthorizationServerEndpointsConfigurer;
import org.springframework.security.oauth2.config.annotation.web.configurers.AuthorizationServerSecurityConfigurer;
import org.springframework.security.oauth2.provider.token.DefaultTokenServices;
import org.springframework.security.oauth2.provider.token.TokenStore;
import org.springframework.security.oauth2.provider.token.store.redis.RedisTokenStore;

@Configuration
@EnableAuthorizationServer
public class AuthorizationServerConfig extends AuthorizationServerConfigurerAdapter {

    private final String resourceId;

    private final AuthenticationManager authenticationManager;

    private final Environment environment;

    private final RedisConnectionFactory redisConnectionFactory;

    @Autowired
    public AuthorizationServerConfig(
            AuthenticationManager authenticationManager,
            Environment environment,
            RedisConnectionFactory redisConnectionFactory,
            @Value("${security.oauth2.client.client-id}") String resourceId
    ) {
        this.authenticationManager = authenticationManager;
        this.environment = environment;
        this.redisConnectionFactory = redisConnectionFactory;
        this.resourceId = resourceId;
    }

    @Override
    public void configure(AuthorizationServerEndpointsConfigurer endpoints) throws Exception {
        endpoints.authenticationManager(this.authenticationManager)
                .tokenServices(tokenServices())
                .tokenStore(tokenStore());
    }

    @Override
    public void configure(AuthorizationServerSecurityConfigurer oauthServer) throws Exception {
        oauthServer
                .tokenKeyAccess("permitAll()")
                .checkTokenAccess("isAuthenticated()");
    }

    @Override
    public void configure(ClientDetailsServiceConfigurer client) throws Exception {

        client.inMemory()

                .withClient("web")
                .scopes("ui")
                .secret(getSecret("AUTH_WEB"))
                .authorizedGrantTypes("refresh_token", "password", "client_credentials")
                .authorities("ROLE_CLIENT")
                .and()

                .withClient("register-service")
                .scopes("ui")
                .secret(getSecret("AUTH_REGISTER_SERVICE_PASSWORD"))
                .authorizedGrantTypes("client_credentials")
                .authorities("ROLE_REGISTER")
                .resourceIds(resourceId)

                .and()
                .withClient("account-service")
                .scopes("server")
                .secret(getSecret("AUTH_ACCOUNT_SERVICE_PASSWORD"))
                .authorizedGrantTypes("client_credentials", "refresh_token")
                .authorities("ROLE_SERVICE")

                .and()
                .withClient("subscription-service")
                .scopes("server")
                .secret(getSecret("AUTH_SUBSCRIPTION_SERVICE_PASSWORD"))
                .authorizedGrantTypes("client_credentials", "refresh_token", "password")
                .authorities("ROLE_SERVICE")

        ;
    }

    @Bean
    public TokenStore tokenStore() {
        RedisTokenStore redisTokenStore = new RedisTokenStore(redisConnectionFactory);
        redisTokenStore.setPrefix("account-token:");
        return redisTokenStore;
    }

    @Bean
    @Primary
    public DefaultTokenServices tokenServices() {
        DefaultTokenServices defaultTokenServices = new DefaultTokenServices();
        defaultTokenServices.setTokenStore(tokenStore());
        defaultTokenServices.setSupportRefreshToken(true);
        return defaultTokenServices;
    }

    private String getSecret(String key) {
        return (new BCryptPasswordEncoder()).encode(environment.getProperty(key));
    }
}