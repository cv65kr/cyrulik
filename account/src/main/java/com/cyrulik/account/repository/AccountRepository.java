package com.cyrulik.account.repository;

import com.cyrulik.account.entity.Account;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import java.util.UUID;

@Repository
public interface AccountRepository  extends CrudRepository<Account, UUID> {

}
