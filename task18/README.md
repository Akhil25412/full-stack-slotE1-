# Task 18: Unit Testing Microservices

This task demonstrates independent unit testing of microservice components, including:
- **Service Logic**: Tested with Mockito to ensure correct error handling and data mapping.
- **REST Controllers**: Tested with `MockMvc` to verify endpoint routing and responses.
- **Independent Testing**: Services are tested in isolation using mocks for external dependencies (like `RestTemplate`).

## Test Coverage

### 1. Producer Service
- `ProducerControllerTest`: Verifies that the internal product API returns the correct data and handles simulated errors with the appropriate status codes.

### 2. Consumer Service
- `ConsumerServiceTest`: Mocks `RestTemplate` to test successful data fetching, handling of 404 (Not Found) errors, and handling of connection failures (ResourceAccessException).
- `ConsumerControllerTest`: Mocks the `ConsumerService` to verify that the consumer API correctly relays information without needing a live producer service.

## Running Tests
Navigate to either the `producer-service` or `consumer-service` directory and run:
```bash
mvn test
```
