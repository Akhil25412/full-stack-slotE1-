# Task 13: Exception Handling and Validation

This project adds comprehensive **Validation** and **Global Exception Handling** to the Product Management RESTful API.

## New Features
- **Input Validation**: Ensures that product names, descriptions, and prices are correctly formatted and not empty using `@Valid` and standard annotation constraints.
- **Global Exception Handling**: A centralized `@ControllerAdvice` (`GlobalExceptionHandler.java`) handles all application-level and system-level exceptions.
- **Structured Error Responses**: Meaningful, standard JSON error responses using the `ErrorDetails` structure.

## Dependencies Added
- `spring-boot-starter-validation`

## Validation Rules
- **Product Name**: Cannot be empty, minimum 2 characters.
- **Price**: Required, minimum value of 0.
- **Description**: Cannot be empty.

## API Error Responses
When a validation fails or a resource is not found, the API returns a structured JSON:
```json
{
  "timestamp": "2024-04-02T03:43:00.000+00:00",
  "message": "Validation Error",
  "details": "Product name should have at least 2 characters"
}
```

## How to Run
1. Open the project in an IDE as a Maven project.
2. Run `Task13Application.java`.
3. Try sending an invalid JSON payload (e.g., empty name) to `POST /api/products` to see the validation error in action.
