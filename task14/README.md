# Task 14: Microservices-based Product Management System

This task marks the transition from a monolithic application into a microservices architecture. The system is split into two independent services:

## 1. Product Service
- **Port**: `8081`
- **Responsibility**: Manages product details (CRUD).
- **Technology**: Spring Boot, Spring Data JPA, H2.

## 2. Review Service
- **Port**: `8082`
- **Responsibility**: Manages reviews for products.
- **Technology**: Spring Boot, Spring Data JPA, H2.
- **Key Method**: `GET /api/reviews/product/{productId}` to fetch reviews for a specific product.

## Design Principles Applied
- **Loose Coupling**: Each service has its own database (`productdb` vs `reviewdb`) and runs on a different port. They can be deployed independently.
- **Single Responsibility**: The Product Service only handles product metadata, while the Review Service focuses entirely on customer feedback.
- **Independent Deployment**: Changes to the Review Service do not require a restart or re-deployment of the Product Service.

## How to Test
1. Run `ProductServiceApplication.java` from the `product-service` folder.
2. Run `ReviewServiceApplication.java` from the `review-service` folder.
3. Add a product in the Product Service: `POST http://localhost:8081/api/products`
4. Add a review for that product: `POST http://localhost:8082/api/reviews` (use the `productId` from the first call).
5. Fetch reviews: `GET http://localhost:8082/api/reviews/product/{productId}`.
