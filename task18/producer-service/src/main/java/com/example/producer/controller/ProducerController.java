package com.example.producer.controller;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/api/products")
public class ProducerController {

    @GetMapping("/{id}")
    public Map<String, Object> getProduct(@PathVariable String id) {
        if ("error".equals(id)) {
            throw new RuntimeException("Simulated internal error");
        }
        
        Map<String, Object> product = new HashMap<>();
        product.put("id", id);
        product.put("name", "Sample Product " + id);
        product.put("price", 99.99);
        product.put("status", "Available");
        
        return product;
    }
}
