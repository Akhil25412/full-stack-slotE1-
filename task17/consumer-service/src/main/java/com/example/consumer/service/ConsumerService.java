package com.example.consumer.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.HttpServerErrorException;
import org.springframework.web.client.ResourceAccessException;

import java.util.HashMap;
import java.util.Map;

@Service
public class ConsumerService {

    @Autowired
    private RestTemplate restTemplate;

    private final String PRODUCER_URL = "http://localhost:8081/api/products/";

    public Map<String, Object> fetchProductDetails(String productId) {
        try {
            return restTemplate.getForObject(PRODUCER_URL + productId, Map.class);
        } catch (HttpClientErrorException e) {
            // Case: 4xx errors
            Map<String, Object> errorResponse = new HashMap<>();
            errorResponse.put("error", "Client Error");
            errorResponse.put("message", "Product not found or invalid request: " + e.getMessage());
            errorResponse.put("status", e.getStatusCode().value());
            return errorResponse;
        } catch (HttpServerErrorException e) {
            // Case: 5xx errors
            Map<String, Object> errorResponse = new HashMap<>();
            errorResponse.put("error", "Server Error");
            errorResponse.put("message", "Producer service encountered an error: " + e.getMessage());
            errorResponse.put("status", e.getStatusCode().value());
            return errorResponse;
        } catch (ResourceAccessException e) {
            // Case: Producer service is down
            Map<String, Object> errorResponse = new HashMap<>();
            errorResponse.put("error", "Service Unavailable");
            errorResponse.put("message", "Could not connect to Producer Service. Please check if it's running.");
            return errorResponse;
        } catch (Exception e) {
            // Generic fallback
            Map<String, Object> errorResponse = new HashMap<>();
            errorResponse.put("error", "Unknown Error");
            errorResponse.put("message", "An unexpected error occurred: " + e.getMessage());
            return errorResponse;
        }
    }
}
