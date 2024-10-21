# PHP Chat Application Backend

A simple chat application backend built with PHP and the Slim framework. This application provides a RESTful JSON API for creating users, managing chat groups, sending messages, and retrieving messages within groups.

## Features

- Create and manage users
- Create and join chat groups
- Send messages within groups
- Retrieve messages from groups

## Technologies Used

- PHP
- Slim Framework
- Eloquent ORM (Illuminate Database)
- SQLite (for development)
- Composer
- PHPUnit (Testing Framework)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/rohithsateesha/php-slim-chat-backed.git
   cd php-slim-chat-backed
2. **Install dependencies:**

   ```bash
   composer install
3. **Set up the database:**

   ```bash
    mkdir -p database
    touch database/database.sqlite
    php database/create_tables.php

4. **Start the application:**

   ```bash
   php -S localhost:8080 -t public

## API Endpoints
 - POST /users - Create a new user
 - GET /users/{id} - Get user details
 - POST /groups - Create a new group
 - POST /groups/{groupId}/join - Join a group
 - POST /groups/{groupId}/messages - Send a message in a group
 - GET /groups/{groupId}/messages - List messages in a group

## Contact

 - Author:  Rohith Sateesha
 - Email: rohithsatheesh@outlook.com