package com.cyrulik.account.service.impl;

import com.cyrulik.account.entity.Account;
import com.cyrulik.account.exception.UserNotFoundException;
import com.cyrulik.account.mapper.JsonMapperWrapper;
import com.cyrulik.account.repository.AccountRepository;
import com.cyrulik.account.service.AccountService;
import com.cyrulik.account.service.KafkaProducerService;
import org.apache.commons.collections4.IteratorUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;
import org.springframework.util.Assert;

import java.util.List;
import java.util.UUID;

import static com.cyrulik.account.kafka.KeySet.*;

@Service
public class AccountServiceImpl implements AccountService, UserDetailsService {

    private static final Logger LOGGER = LoggerFactory.getLogger(AccountServiceImpl.class);

    private final AccountRepository accountRepository;
    private final KafkaProducerService kafkaProducerService;
    private final JsonMapperWrapper jsonMapper;

    private final String topic;

    @Autowired
    public AccountServiceImpl(AccountRepository accountRepository, KafkaProducerService kafkaProducerService,
                           JsonMapperWrapper jsonMapper,
                           @Value("${spring.kafka.consumer.topic.account}") String topic) {
        this.accountRepository = accountRepository;
        this.kafkaProducerService = kafkaProducerService;
        this.jsonMapper = jsonMapper;
        this.topic = topic;
    }

    @Override
    public Account grantRole(UUID id, String role) {
        Account account = findOne(id);
        Assert.notNull(account, "can't find account with name " + id.toString());

        account.grantAuthority(role);

        return accountRepository.save(account);
    }

    @Override
    public Account save(Account account) {

        Account existing = accountRepository.findByUsername(account.getUsername());
        Assert.isNull(existing, "account already exists: " + account.getUsername());

        LOGGER.info("Save account: {}", account);
        account.grantAuthority("ROLE_CLIENT");
        Account saved = accountRepository.save(account);
        kafkaProducerService.send(topic, SAVE, jsonMapper.writeValue(saved));
        return saved;
    }

    @Override
    public Account update(UUID id, Account update) throws UserNotFoundException {

        Account account = findOne(id);
        Assert.notNull(account, "can't find account with name " + id.toString());

        LOGGER.info("Update account, id: {}, {}", id, update);

        return updateAccount(account, update);
    }

    @Override
    public Account update(String username, Account update) throws UserNotFoundException {

        Account account = accountRepository.findByUsername(username);
        Assert.notNull(account, "can't find account with name " + username);

        LOGGER.info("Update account, id: {}, {}", username, update);

        return updateAccount(account, update);
    }

    private Account updateAccount(Account account, Account update) {
        account.setFirstName(update.getFirstName());
        account.setLastName(update.getLastName());
        account.setEmail(update.getEmail());
        Account saved = accountRepository.save(account);
        kafkaProducerService.send(topic, UPDATE, jsonMapper.writeValue(saved));
        return saved;
    }

    @Override
    public Account findOne(UUID id) throws UserNotFoundException {
        LOGGER.info("Find account, id: {}", id);
        return accountRepository.findById(id.toString()).orElseThrow(() -> new UserNotFoundException());
    }

    @Override
    public List<Account> findAll() {
        LOGGER.info("Find all accounts");
        Iterable<Account> products = accountRepository.findAll();
        return IteratorUtils.toList(products.iterator());
    }

    @Override
    public void delete(UUID id) throws UserNotFoundException {
        LOGGER.info("Delete account, id: {}", id);
        accountRepository.delete(findOne(id));
        kafkaProducerService.send(topic, DELETE, id.toString());
    }

    @Override
    public Account loadUserByUsername(String username) throws UsernameNotFoundException {
        LOGGER.info("Find account, id: {}", username);
        return accountRepository.findByUsername(username);
    }
}
