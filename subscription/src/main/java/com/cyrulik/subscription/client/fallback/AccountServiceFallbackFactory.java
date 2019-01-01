package com.cyrulik.subscription.client.fallback;

import feign.hystrix.FallbackFactory;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

@Component
public class AccountServiceFallbackFactory implements FallbackFactory<AccountServiceClientFallback> {

    private static final Logger LOGGER = LoggerFactory.getLogger(AccountServiceFallbackFactory.class);

    private AccountServiceClientFallback accountServiceClientFallback;

    @Autowired
    public AccountServiceFallbackFactory(AccountServiceClientFallback accountServiceClientFallback) {
        this.accountServiceClientFallback = accountServiceClientFallback;
    }

    @Override
    public AccountServiceClientFallback create(Throwable throwable) {
        if(!(throwable instanceof RuntimeException && throwable.getMessage() == null)) {
            LOGGER.error("AccountServiceClient failed, switching to AccountServiceFallback", throwable);
        }
        return accountServiceClientFallback;
    }

    @Override
    public String toString() {
        return accountServiceClientFallback.toString();
    }
}
