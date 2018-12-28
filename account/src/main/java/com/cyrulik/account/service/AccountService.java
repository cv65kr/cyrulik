package com.cyrulik.account.service;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.exception.UserNotFoundException;
import org.springframework.security.core.userdetails.UsernameNotFoundException;

import java.util.List;
import java.util.UUID;

public interface AccountService {

    Account save(Account user);

    Account grantRole(UUID id, String role);

    Account update(String username, Account user) throws UserNotFoundException;

    Account update(UUID id, Account user) throws UserNotFoundException;

    Account findOne(UUID id) throws UserNotFoundException;

    List<Account> findAll();

    void delete(UUID id) throws UserNotFoundException;

    Account loadUserByUsername(String username) throws UsernameNotFoundException;
}
