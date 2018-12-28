package com.cyrulik.subscription.service.impl;

import com.cyrulik.subscription.entity.Plan;
import com.cyrulik.subscription.exception.PlanNotFoundException;
import com.cyrulik.subscription.repository.PlanRepository;
import com.cyrulik.subscription.service.PlanService;

import java.util.List;
import java.util.UUID;

import org.apache.commons.collections4.IteratorUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class PlanServiceImpl implements PlanService {

    private static final Logger LOGGER = LoggerFactory.getLogger(PlanServiceImpl.class);

    private final PlanRepository planRepository;

    @Autowired
    public PlanServiceImpl(PlanRepository planRepository) {
        this.planRepository = planRepository;
    }

    @Override
    public Plan save(Plan plan) {
        LOGGER.info("Save plan: {}", plan);

        Plan model = planRepository.save(plan);

        return model;
    }

    @Override
    public Plan update(UUID id, Plan plan) throws PlanNotFoundException {
        LOGGER.info("Update plan, id: {}, {}", id, plan);
        Plan model = findOne(id);

        model.setName(plan.getName());
        model.setPricePerMonth(plan.getPricePerMonth());
        model.setPricePerYear(plan.getPricePerYear());

        Plan saved = planRepository.save(model);

        return saved;
    }

    @Override
    public List<Plan> findAll() {
        LOGGER.info("Find all plans");

        Iterable<Plan> plans = planRepository.findAll();
        return IteratorUtils.toList(plans.iterator());
    }

    @Override
    public Plan findOne(UUID id) throws PlanNotFoundException {
        LOGGER.info("Find plan, id: {}", id);
        return planRepository.findById(id.toString()).orElseThrow(()-> new PlanNotFoundException());
    }

    @Override
    public void delete(UUID id) throws PlanNotFoundException {
        LOGGER.info("Delete plan, id: {}", id);

        Plan model = findOne(id);

        planRepository.delete(model);
    }
}
