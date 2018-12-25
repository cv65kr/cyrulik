package com.cyrulik.account.repository;

import com.cyrulik.account.entity.Account;
import org.springframework.data.cassandra.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.Optional;
import java.util.UUID;

@Repository
public interface AccountRepository extends CrudRepository<Account, UUID> {

    @Query("SELECT * FROM account WHERE username =:username LIMIT 1 ALLOW FILTERING")
    Account findByUsername(@Param("username") String username);

    @Query("SELECT * FROM account WHERE id =:uuid LIMIT 1 ALLOW FILTERING")
    Optional<Account> findById(@Param("uuid") String uuid);
}
