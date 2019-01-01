package com.cyrulik.subscription.config;

import com.datastax.driver.core.exceptions.NoHostAvailableException;
import com.datastax.driver.core.exceptions.TransportException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.data.cassandra.config.CassandraClusterFactoryBean;

/**
 * https://lankydanblog.com/2018/09/08/containerising-a-spring-data-cassandra-application/
 */
public class RetryingCassandraClusterFactoryBean extends CassandraClusterFactoryBean {

    private static final Logger LOGGER = LoggerFactory.getLogger(RetryingCassandraClusterFactoryBean.class);

    @Override
    public void afterPropertiesSet() throws Exception {
        connect();
    }

    private void connect() throws Exception {
        try {
            super.afterPropertiesSet();
        } catch (TransportException | IllegalArgumentException | NoHostAvailableException e) {
            LOGGER.warn("Retrying connection in 10 seconds {}", e.getMessage());
            sleep();
            connect();
        }
    }

    private void sleep() {
        try {
            Thread.sleep(10000);
        } catch (InterruptedException ignored) {
        }
    }
}
