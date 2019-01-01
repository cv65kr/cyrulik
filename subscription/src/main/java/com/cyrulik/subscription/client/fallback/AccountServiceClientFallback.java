package com.cyrulik.subscription.client.fallback;

import com.cyrulik.subscription.client.AccountServiceClient;
import com.cyrulik.subscription.entity.Account;
import org.springframework.stereotype.Component;

@Component
public class AccountServiceClientFallback implements AccountServiceClient {
    @Override
    public Account getAccount(String username) {
        return null;
    }
}
