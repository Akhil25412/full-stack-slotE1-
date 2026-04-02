# Task 15: Service Registry and Discovery with Eureka

This task introduces **Service Discovery** to the Product Management microservices system using **Netflix Eureka Server**.

## New Component: Eureka Server
- **Port**: `8761`
- **Dashboard**: `http://localhost:8761/` (to see registered services).
- **Responsibility**: Acts as a central registry where all microservices register themselves dynamically.

## Dynamic Service Lookup
- Services no longer use hard-coded URLs (e.g., `localhost:8081`).
- Instead, they use service names (e.g., `PRODUCT-SERVICE`).
- A **Load-balanced RestTemplate** is used in the `review-service` to call the `product-service` using only its registry name.

## Registered Services
| Service Name      | Registry Port | Service Port |
|-------------------|---------------|--------------|
| `EUREKA-SERVER`   | 8761          | 8761         |
| `PRODUCT-SERVICE` | 8761          | 8081         |
| `REVIEW-SERVICE`  | 8761          | 8082         |

## Demonstrating Dynamic Lookup
A new endpoint has been added to the **Review Service**:
- **Endpoint**: `GET /api/reviews/product-with-details/{productId}`
- **How it works**:
    1. It fetches product details from `http://PRODUCT-SERVICE/api/products/{id}`.
    2. It fetches local reviews for that product ID.
    3. It combines the data and returns a unified response.

## How to Run
1. Start **Eureka Server** (`EurekaServerApplication.java`).
2. Wait a few seconds, then start **Product Service** (`ProductServiceApplication.java`).
3. Start **Review Service** (`ReviewServiceApplication.java`).
4. Access the Eureka dashboard at `http://localhost:8761/` to confirm all services are UP.
5. Test the dynamic lookup: `GET http://localhost:8082/api/reviews/product-with-details/1`.
