package com.example.consumer.service;

import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.extension.ExtendWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.jupiter.MockitoExtension;
import org.springframework.web.client.HttpClientErrorException;
import org.springframework.web.client.ResourceAccessException;
import org.springframework.web.client.RestTemplate;
import org.springframework.http.HttpStatus;

import java.util.HashMap;
import java.util.Map;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.mockito.ArgumentMatchers.anyString;
import static org.mockito.ArgumentMatchers.eq;
import static org.mockito.Mockito.when;

@ExtendWith(MockitoExtension.class)
public class ConsumerServiceTest {

    @Mock
    private RestTemplate restTemplate;

    @InjectMocks
    private ConsumerService consumerService;

    @Test
    public void testFetchProductDetails_Success() {
        Map<String, Object> mockProduct = new HashMap<>();
        mockProduct.put("id", "1");
        mockProduct.put("name", "Unit Test Product");

        when(restTemplate.getForObject(anyString(), eq(Map.class))).thenReturn(mockProduct);

        Map<String, Object> result = consumerService.fetchProductDetails("1");

        assertEquals("1", result.get("id"));
        assertEquals("Unit Test Product", result.get("name"));
    }

    @Test
    public void testFetchProductDetails_ServiceUnavailable() {
        when(restTemplate.getForObject(anyString(), eq(Map.class)))
                .thenThrow(new ResourceAccessException("Service is down"));

        Map<String, Object> result = consumerService.fetchProductDetails("1");

        assertEquals("Service Unavailable", result.get("error"));
    }

    @Test
    public void testFetchProductDetails_NotFound() {
        when(restTemplate.getForObject(anyString(), eq(Map.class)))
                .thenThrow(new HttpClientErrorException(HttpStatus.NOT_FOUND));

        Map<String, Object> result = consumerService.fetchProductDetails("999");

        assertEquals("Client Error", result.get("error"));
        assertEquals(404, result.get("status"));
    }
}
