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
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.UUID;

import static com.cyrulik.account.kafka.KeySet.*;

@Service
public class AccountServiceImpl implements AccountService {

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
    public Account save(Account account) {
        LOGGER.info("Save account: {}", account);
        Account saved = accountRepository.save(account);
        kafkaProducerService.send(topic, SAVE, jsonMapper.writeValue(saved));
        return saved;
    }

    @Override
    public Account update(UUID id, Account updated) throws UserNotFoundException {
        LOGGER.info("Update account, id: {}, {}", id, updated);
        Account product = findOne(id);
        product.setFirstName(updated.getFirstName());
        product.setLastName(updated.getLastName());
        product.setEmail(updated.getEmail());
        Account saved = accountRepository.save(product);
        kafkaProducerService.send(topic, UPDATE, jsonMapper.writeValue(saved));
        return saved;
    }

    @Override
    public Account findOne(UUID id) throws UserNotFoundException {
        LOGGER.info("Find account, id: {}", id);
        return accountRepository.findById(id).orElseThrow(() -> new UserNotFoundException());
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

}
