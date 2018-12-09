package com.cyrulik.account.controller;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.service.AccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.UUID;

@RestController
@RequestMapping("/account")
public class AccountController {

    private final AccountService accountService;

    @Autowired
    public AccountController(AccountService accountService) {
        this.accountService = accountService;
    }

    @GetMapping(value = "/")
    public List<Account> getAll() {
        return accountService.findAll();
    }

    @GetMapping(value = "/{id}")
    public Account getOne(@PathVariable UUID id) {
        return accountService.findOne(id);
    }

    @PostMapping(value = "/")
    public Account create(@RequestBody Account user) {
        return accountService.save(user);
    }

    @PutMapping(value = "/{id}")
    public Account update(@PathVariable UUID id, @RequestBody Account user) {
        return accountService.update(id, user);
    }

    @DeleteMapping(value = "/{id}")
    public void delete(@PathVariable UUID id) {
        accountService.delete(id);
    }

}