package com.cyrulik.account.service;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.exception.UserNotFoundException;

import java.util.List;
import java.util.UUID;

public interface AccountService {

    Account save(Account user);

    Account update(UUID id, Account user) throws UserNotFoundException;

    Account findOne(UUID id) throws UserNotFoundException;

    List<Account> findAll();

    void delete(UUID id) throws UserNotFoundException;
    
}
