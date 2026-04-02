package com.example.reviewservice.controller;

import com.example.reviewservice.model.Review;
import com.example.reviewservice.repository.ReviewRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.client.RestTemplate;

import javax.validation.Valid;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/reviews")
public class ReviewController {

    @Autowired
    private ReviewRepository reviewRepository;

    @Autowired
    private RestTemplate restTemplate;

    @GetMapping("/product/{productId}")
    public List<Review> getReviewsByProductId(@PathVariable Long productId) {
        return reviewRepository.findByProductId(productId);
    }

    /**
     * Demonstrates dynamic service lookup using the service name "PRODUCT-SERVICE"
     * instead of a hardcoded URL (localhost:8081).
     */
    @GetMapping("/product-with-details/{productId}")
    public ResponseEntity<Map<String, Object>> getProductWithReviews(@PathVariable Long productId) {
        // Dynamic service lookup via Eureka name
        String productServiceUrl = "http://PRODUCT-SERVICE/api/products/" + productId;
        Object product = restTemplate.getForObject(productServiceUrl, Object.class);

        List<Review> reviews = reviewRepository.findByProductId(productId);

        Map<String, Object> result = new HashMap<>();
        result.put("product", product);
        result.put("reviews", reviews);

        return ResponseEntity.ok(result);
    }

    @PostMapping
    public Review addReview(@Valid @RequestBody Review review) {
        return reviewRepository.save(review);
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteReview(@PathVariable Long id) {
        reviewRepository.deleteById(id);
        return ResponseEntity.ok().build();
    }
}
