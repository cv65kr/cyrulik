package com.cyrulik.account.service;

import com.cyrulik.account.kafka.KeySet;

public interface KafkaProducerService {

    void send(String topic, KeySet key, String payload);

}