package com.cyrulik.account.controller;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.service.AccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.annotation.Secured;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.security.Principal;

@RestController
public class AccountController {

    private final AccountService accountService;

    @Autowired
    public AccountController(AccountService accountService) {
        this.accountService = accountService;
    }

    @PostMapping(value = "/", produces = "application/json")
    public Account create(@Valid @RequestBody Account user) {
        return accountService.save(user);
    }

    @Secured({"ROLE_CLIENT"})
    @RequestMapping(path = "/current", method = RequestMethod.PUT)
    public void saveCurrentAccount(Principal principal, @Valid @RequestBody Account account) {
        accountService.update(principal.getName(), account);
    }

    @GetMapping(path = "/current", produces = "application/json" )
    public Principal userDetails(Principal principal) {
        return principal;
    }
}