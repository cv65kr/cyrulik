package com.cyrulik.subscription.service;

import java.util.HashMap;
import java.util.Map;

public enum PaymentStatus {
    NEW(0),
    IN_PROGRESS(1),
    PAYED(2);


    private int value;
    private static Map map = new HashMap<>();

    private PaymentStatus(int value) {
        this.value = value;
    }

    static {
        for (PaymentStatus pageType : PaymentStatus.values()) {
            map.put(pageType.value, pageType);
        }
    }

    public static PaymentStatus valueOf(int pageType) {
        return (PaymentStatus) map.get(pageType);
    }

    public int getValue() {
        return value;
    }
}
