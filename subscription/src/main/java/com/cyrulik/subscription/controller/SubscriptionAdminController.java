package com.cyrulik.subscription.controller;

import com.cyrulik.subscription.entity.Subscription;
import com.cyrulik.subscription.service.SubscriptionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
import java.util.UUID;

@Secured({"ROLE_ADMIN", "ROLE_SERVICE"})
@RequestMapping("/admin")
@RestController
public class SubscriptionAdminController {

    private final SubscriptionService subscriptionService;

    @Autowired
    public SubscriptionAdminController(SubscriptionService subscriptionService) {
        this.subscriptionService = subscriptionService;
    }

    @GetMapping(value = "/", produces = "application/json")
    public List<Subscription> getAll() {
        return subscriptionService.findAll();
    }

    @GetMapping(value = "/{id}", produces = "application/json")
    public Subscription getOne(@PathVariable UUID id) {
        return subscriptionService.findOne(id);
    }

    @PostMapping(value = "/", produces = "application/json")
    public Subscription create(@Valid @RequestBody Subscription subscription) {
        return subscriptionService.save(subscription);
    }

    @PutMapping(value = "/{id}", produces = "application/json")
    public Subscription update(@PathVariable UUID id, @Valid @RequestBody Subscription subscription) {
        return subscriptionService.update(id, subscription);
    }

    @DeleteMapping(value = "/{id}", produces = "application/json")
    public void delete(@PathVariable UUID id) {
        subscriptionService.delete(id);
    }
}
