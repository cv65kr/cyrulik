package com.cyrulik.subscription.client;

import com.cyrulik.subscription.entity.Account;
import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.http.MediaType;
import org.springframework.stereotype.Component;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

@Component
@FeignClient(value = "account-service")
public interface AccountServiceClient {

    @RequestMapping(method = RequestMethod.GET, value = "/account/admin/{username}/username", produces = MediaType.APPLICATION_JSON_UTF8_VALUE)
    Account getAccount(@PathVariable("username") String username);
}
