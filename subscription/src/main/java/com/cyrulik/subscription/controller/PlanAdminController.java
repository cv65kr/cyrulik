package com.cyrulik.subscription.controller;

import com.cyrulik.subscription.entity.Plan;
import com.cyrulik.subscription.service.PlanService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
import java.util.UUID;

@Secured({"ROLE_ADMIN", "ROLE_SERVICE"})
@RequestMapping("/plan/admin")
@RestController
public class PlanAdminController {

    private final PlanService planService;

    @Autowired
    public PlanAdminController(PlanService planService) {
        this.planService = planService;
    }

    @GetMapping(value = "/", produces = "application/json")
    public List<Plan> getAll() {
        return planService.findAll();
    }

    @GetMapping(value = "/{id}", produces = "application/json")
    public Plan getOne(@PathVariable UUID id) {
        return planService.findOne(id);
    }

    @PostMapping(value = "/", produces = "application/json")
    public Plan create(@Valid @RequestBody Plan plan) {
        return planService.save(plan);
    }

    @PutMapping(value = "/{id}", produces = "application/json")
    public Plan update(@PathVariable UUID id, @Valid @RequestBody Plan plan) {
        return planService.update(id, plan);
    }

    @DeleteMapping(value = "/{id}", produces = "application/json")
    public void delete(@PathVariable UUID id) {
        planService.delete(id);
    }
}
