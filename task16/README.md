# Task 16: API Gateway and Load Balancing

In this task, I have implemented an **API Gateway** using **Spring Cloud Gateway**. The gateway acts as a single entry point for clients, routing requests to the appropriate microservices based on the URL path.

## Key Features
- **Centralized Entry Point**: The Gateway runs on port `8080`.
- **Dynamic Routing**: Requests are routed to `PRODUCT-SERVICE` and `REVIEW-SERVICE` by looking them up in the Eureka Service Registry.
- **Load Balancing**: By using the `lb://` prefix in the routing configuration, the Gateway automatically balances requests across all available instances of a service.

## Gateway Routes
| Destination Service | Gateway Path         | Internal Service URL   |
|---------------------|----------------------|------------------------|
| `PRODUCT-SERVICE`    | `http://localhost:8080/api/products/**` | `lb://PRODUCT-SERVICE` |
| `REVIEW-SERVICE`     | `http://localhost:8080/api/reviews/**`  | `lb://REVIEW-SERVICE`  |

## How to Test
1. Start **Eureka Server** (`EurekaServerApplication.java`).
2. Start **Product Service** (`ProductServiceApplication.java`).
3. Start **Review Service** (`ReviewServiceApplication.java`).
4. Start **API Gateway** (`ApiGatewayApplication.java`).
5. **Direct API Call**: Instead of calling port `8081` (Product) or `8082` (Review), call port `8080` (Gateway).
    *   `GET http://localhost:8080/api/products` (Gateway routes this to Product Service)
    *   `GET http://localhost:8080/api/reviews/product/1` (Gateway routes this to Review Service)

## Demonstration of Load Balancing
To see load balancing in action, you can start a second instance of the `PRODUCT-SERVICE` on a different port (e.g., `-Dserver.port=8083`). The API Gateway will automatically distribute requests between the instance on `8081` and the one on `8083`.
