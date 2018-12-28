package com.cyrulik.subscription.repository;

import com.cyrulik.subscription.entity.Plan;
import org.springframework.data.cassandra.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.Optional;
import java.util.UUID;

@Repository
public interface PlanRepository extends CrudRepository<Plan, UUID> {

    @Query("SELECT * FROM plan WHERE id =:uuid LIMIT 1 ALLOW FILTERING")
    Optional<Plan> findById(@Param("uuid") String uuid);

}
