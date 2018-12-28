package com.cyrulik.subscription.service;

import com.cyrulik.subscription.entity.Subscription;
import com.cyrulik.subscription.exception.SubscriptionNotFoundException;

import java.util.List;
import java.util.UUID;

public interface SubscriptionService {

    Subscription save(Subscription plan);

    Subscription createAccountSubscription(String username, Subscription plan);

    Subscription update(UUID id, Subscription plan) throws SubscriptionNotFoundException;

    List<Subscription> findAll();

    Subscription findOne(UUID id) throws SubscriptionNotFoundException;

    void delete(UUID id) throws SubscriptionNotFoundException;
}
