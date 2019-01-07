package com.cyrulik.subscription.controller;

import com.cyrulik.subscription.entity.Plan;
import com.cyrulik.subscription.service.PlanService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
import java.util.UUID;

@Secured({"ROLE_CLIENT"})
@RequestMapping("/plan")
@RestController
public class PlanController {

    private final PlanService planService;

    @Autowired
    public PlanController(PlanService planService) {
        this.planService = planService;
    }

    @GetMapping(value = "/", produces = "application/json")
    public List<Plan> getAll() {
        return planService.findAll();
    }
}
