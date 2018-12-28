package com.cyrulik.subscription.controller;

import com.cyrulik.subscription.entity.Subscription;
import com.cyrulik.subscription.service.SubscriptionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.security.Principal;
import java.util.List;
import java.util.UUID;

@Secured({"ROLE_CLIENT"})
@RestController
public class SubscriptionController {

    private final SubscriptionService subscriptionService;

    @Autowired
    public SubscriptionController(SubscriptionService subscriptionService) {
        this.subscriptionService = subscriptionService;
    }

    @RequestMapping(path = "/current", method = RequestMethod.GET)
    public void getSubscription(Principal principal) {

    }

    @PostMapping(value = "/", produces = "application/json")
    public Subscription saveSubscription(Principal principal, @Valid @RequestBody Subscription subscription) {
        return subscriptionService.createAccountSubscription(principal.getName(), subscription);
    }
}
