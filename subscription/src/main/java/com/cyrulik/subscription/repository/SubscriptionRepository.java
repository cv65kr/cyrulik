package com.cyrulik.subscription.repository;

import com.cyrulik.subscription.entity.Subscription;
import org.springframework.data.cassandra.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.Optional;
import java.util.UUID;

@Repository
public interface SubscriptionRepository extends CrudRepository<Subscription, UUID> {

    @Query("SELECT * FROM subscription WHERE id =:uuid LIMIT 1 ALLOW FILTERING")
    Optional<Subscription> findById(@Param("uuid") String uuid);
}
