# Task 12: Product Management RESTful API

This project is a RESTful API for Product Management developed using Spring Boot 2.7.18 (compatible with Java 8).

## Features
- **GET /api/products**: Retrieve all products.
- **GET /api/products/{id}**: Retrieve a specific product by ID.
- **POST /api/products**: Add a new product.
- **PUT /api/products/{id}**: Update an existing product.
- **DELETE /api/products/{id}**: Delete a product.
- **H2 In-Memory Database**: For testing without external database setup.
- **H2 Console**: Accessible at `http://localhost:8080/h2-console`.

## How to Run
1. Ensure you have **Java 8 or higher** installed.
2. Open the project in an IDE (e.g., IntelliJ IDEA, Eclipse, or VS Code).
3. Import the project as a **Maven** project.
4. Run `Task12Application.java`.
5. The API will be available at `http://localhost:8080/api/products`.

## API Documentation (Endpoints)

### 1. Get All Products
- **Method**: `GET`
- **URL**: `http://localhost:8080/api/products`

### 2. Create a Product
- **Method**: `POST`
- **URL**: `http://localhost:8080/api/products`
- **Body (JSON)**:
```json
{
  "name": "Laptop",
  "price": 999.99,
  "description": "High-performance gaming laptop"
}
```

### 3. Update a Product
- **Method**: `PUT`
- **URL**: `http://localhost:8080/api/products/1`
- **Body (JSON)**:
```json
{
  "name": "Updated Laptop Name",
  "price": 1050.00,
  "description": "Updated Description"
}
```

### 4. Delete a Product
- **Method**: `DELETE`
- **URL**: `http://localhost:8080/api/products/1`

## Testing
You can use **Postman**, **Insomnia**, or any REST client to test these APIs.
