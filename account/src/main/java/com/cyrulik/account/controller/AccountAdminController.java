package com.cyrulik.account.controller;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.service.AccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
import java.util.UUID;

@RequestMapping("/admin")
@RestController()
@Secured({"ROLE_ADMIN"})
public class AccountAdminController {

    private final AccountService accountService;

    @Autowired
    public AccountAdminController(AccountService accountService) {
        this.accountService = accountService;
    }
    
    @GetMapping(value = "/", produces = "application/json")
    public List<Account> getAll() {
        return accountService.findAll();
    }
    
    @GetMapping(value = "/{id}", produces = "application/json")
    public Account getOne(@PathVariable UUID id) {
        return accountService.findOne(id);
    }
    
    @PostMapping(value = "/", produces = "application/json")
    public Account create(@Valid @RequestBody Account user) {
        return accountService.save(user);
    }

    @PutMapping(value = "/{id}", produces = "application/json")
    public Account update(@PathVariable UUID id, @Valid @RequestBody Account user) {
        return accountService.update(id, user);
    }
    
    @DeleteMapping(value = "/{id}", produces = "application/json")
    public void delete(@PathVariable UUID id) {
        accountService.delete(id);
    }
}