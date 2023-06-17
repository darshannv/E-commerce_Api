E-commerce System REST API
This project is an e-commerce system implemented as a REST API using Laravel. It provides endpoints to perform various operations such as creating, reading, updating, and deleting products, as well as searching for products based on name, description, or variant name.

The API will now be accessible at http://localhost:8000.

Interacting with the API
You can interact with the API using any HTTP client, such as Postman or cURL. Here are the available endpoints:

GET /api/products: Retrieve all products.
GET /api/products/{product}: Retrieve a specific product by ID.
POST /api/products: Create a new product.
PUT /api/products/{product}: Update an existing product.
DELETE /api/products/{product}: Delete a product.
GET /api/products/search/{query}={search_query}: Search for products based on name, description, or variant name.
For the POST and PUT requests, provide the necessary data in the request body following the specified format.

Architecture
The e-commerce system follows a standard Laravel architecture, utilizing models, controllers, and routes. Here's an overview of the architectural decisions:

Models: The project includes Product and Variant models that represent the database tables and define the relationships between them.
Controllers: The ProductController handles the logic for handling product-related operations and search functionality.
Routes: The routes are defined in the routes/api.php file, mapping each endpoint to the corresponding controller method.

Assumptions
It is assumed that a database connection has been properly configured in the .env file.
The project assumes the existence of a database and runs the necessary migrations and seeders to populate initial data.
Additional Instructions
To run tests, use the following command:

php artisan test

You can customize the project by adding additional features or extending existing functionality as per your requirements.

Feel free to reach out if you have any questions or need further assistance.

Enjoy using the e-commerce system API!
