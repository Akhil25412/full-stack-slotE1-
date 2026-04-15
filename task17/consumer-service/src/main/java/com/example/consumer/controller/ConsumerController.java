package com.example.consumer.controller;

import com.example.consumer.service.ConsumerService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.Map;

@RestController
@RequestMapping("/api/consumer")
public class ConsumerController {

    @Autowired
    private ConsumerService consumerService;

    @GetMapping("/product/{id}")
    public Map<String, Object> getProductThroughConsumer(@PathVariable String id) {
        return consumerService.fetchProductDetails(id);
    }
}
