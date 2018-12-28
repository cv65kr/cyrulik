package com.cyrulik.subscription.service.impl;

import com.cyrulik.subscription.client.AccountServiceClient;
import com.cyrulik.subscription.entity.Account;
import com.cyrulik.subscription.entity.Plan;
import com.cyrulik.subscription.entity.Subscription;
import com.cyrulik.subscription.exception.SubscriptionNotFoundException;
import com.cyrulik.subscription.repository.SubscriptionRepository;
import com.cyrulik.subscription.service.PlanService;
import com.cyrulik.subscription.service.SubscriptionService;
import org.apache.commons.collections4.IteratorUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.util.Assert;

import java.util.List;
import java.util.UUID;

@Service
public class SubscriptionServiceImpl implements SubscriptionService {

    private static final Logger LOGGER = LoggerFactory.getLogger(SubscriptionServiceImpl.class);

    private final SubscriptionRepository subscriptionRepository;

    private final AccountServiceClient accountServiceClient;

    private final PlanService planService;

    @Autowired
    public SubscriptionServiceImpl(SubscriptionRepository subscriptionRepository, AccountServiceClient accountServiceClient, PlanService planService) {
        this.subscriptionRepository = subscriptionRepository;
        this.accountServiceClient = accountServiceClient;
        this.planService = planService;
    }

    @Override
    public Subscription save(Subscription subscription) {
        LOGGER.info("Save subscription: {}", subscription);

        Subscription model = subscriptionRepository.save(subscription);

        return model;
    }

    @Override
    public Subscription createAccountSubscription(String username, Subscription subscription) {

        LOGGER.info("Username: {}", username);

        Account account = accountServiceClient.getAccount(username);
        Assert.notNull(account, "can't find account with name " + username);

        LOGGER.info("Account: {}", account.getId());

        Plan plan = planService.findOne(UUID.fromString(subscription.getPlan()));
        Assert.notNull(plan, "can't plan account with uuid " + subscription.getPlan());

        Subscription model = new Subscription();
        model.setClient(account.getId());
        model.setPlan(plan.getId());
        model.setStartedAt(subscription.getStartedAt());
        model.setEndAt(subscription.getEndAt());
        model.setPaymentStatus(subscription.getPaymentStatus());

        validateSubscriptionDate(subscription);
        subscriptionRepository.save(model);

        return model;
    }

    private void validateSubscriptionDate(Subscription subscription) {

        if (null == subscription.getStartedAt()) {
            return;
        }

        if (null == subscription.getEndAt()) {
            return;
        }

        if (subscription.getStartedAt().isAfter(subscription.getEndAt())) {
            throw new IllegalArgumentException("End date can be lower than start date");
        }
    }

    @Override
    public Subscription update(UUID id, Subscription subscription) throws SubscriptionNotFoundException {
        LOGGER.info("Update subscription, id: {}, {}", id, subscription);
        Subscription model = findOne(id);

        model.setStartedAt(subscription.getStartedAt());
        model.setEndAt(subscription.getEndAt());
        model.setPlan(subscription.getPlan());
        model.setStartedAt(subscription.getStartedAt());
        model.setEndAt(subscription.getEndAt());
        model.setPaymentStatus(subscription.getPaymentStatus());

        validateSubscriptionDate(subscription);
        subscriptionRepository.save(model);

        return model;
    }

    @Override
    public List<Subscription> findAll() {
        LOGGER.info("Find all subscriptions");

        Iterable<Subscription> subscriptions = subscriptionRepository.findAll();
        return IteratorUtils.toList(subscriptions.iterator());
    }

    @Override
    public Subscription findOne(UUID id) throws SubscriptionNotFoundException {
        LOGGER.info("Find subscription, id: {}", id);
        return subscriptionRepository.findById(id.toString()).orElseThrow(()-> new SubscriptionNotFoundException());
    }

    @Override
    public void delete(UUID id) throws SubscriptionNotFoundException {
        LOGGER.info("Delete subscription, id: {}", id);

        Subscription model = findOne(id);

        subscriptionRepository.delete(model);
    }
}
