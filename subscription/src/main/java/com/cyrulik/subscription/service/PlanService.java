package com.cyrulik.subscription.service;

import com.cyrulik.subscription.entity.Plan;
import com.cyrulik.subscription.exception.PlanNotFoundException;

import java.util.List;
import java.util.UUID;

public interface PlanService {

    Plan save(Plan plan);

    Plan update(UUID id, Plan plan) throws PlanNotFoundException;

    List<Plan> findAll();

    Plan findOne(UUID id) throws PlanNotFoundException;

    void delete(UUID id) throws PlanNotFoundException;
}
