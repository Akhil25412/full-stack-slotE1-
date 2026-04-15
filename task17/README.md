# Task 17: Inter-service Communication using REST

This task demonstrates REST-based communication between two microservices with graceful failure handling.

## Components

1.  **Producer Service**:
    *   Runs on port **8081**.
    *   Exposes endpoint `GET /api/products/{id}`.
    *   Returns product details or simulates an error if `{id}` is "error".

2.  **Consumer Service**:
    *   Runs on port **8082**.
    *   Uses `RestTemplate` to call the Producer Service.
    *   Exposes endpoint `GET /api/consumer/product/{id}`.
    *   **Graceful Failure Handling**:
        *   Handles `HttpClientErrorException` (4xx).
        *   Handles `HttpServerErrorException` (5xx).
        *   Handles `ResourceAccessException` (Service down).
        *   Handles generic exceptions.

## How to Run

1.  Navigate to `producer-service` and run `mvn spring-boot:run`.
2.  Navigate to `consumer-service` and run `mvn spring-boot:run`.
3.  Access the Consumer API: `http://localhost:8082/api/consumer/product/123`.

## Edge Cases Handled

*   **Producer Down**: If the producer service is not running, the consumer returns a user-friendly "Service Unavailable" message instead of a raw stack trace.
*   **Internal Error**: Calling `http://localhost:8082/api/consumer/product/error` triggers a simulated 500 error in the producer, which the consumer catches and reports gracefully.
