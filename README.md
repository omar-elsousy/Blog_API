# Blog API
This is a simple blog API built with Laravel 11. The API includes user authentication using JWT and CRUD operations for managing blog posts.

## Features
- **User Authentication**: Register and login with JWT.
- **Blog Post**: Authenticated users can create, read, update, and delete their own posts.
- **Authorization**: Users can only modify or delete their own posts.
- **RESTful API**: API designed following RESTful conventions.

## Setup Instructions
### 1. Clone the Repository
```bash
git clone https://github.com/omar-elsousy/Blog_API.git
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment Variables
1- Copy .env.example to .env:
```bash
cp .env.example .env
```
2- Configure the .env file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=new_blog
DB_USERNAME=root
DB_PASSWORD=
```
3- Generate a JWT secret key:
```bash
php artisan jwt:secret
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Database Migrations
```bash
php artisan migrate
```

### 6. Start the Development Server
```bash
php artisan serve
```

### The API will be available at http://127.0.0.1:8000.

### API Endpoints
#### Authentication Endpoints
######  Register - POST                    ``` /api/user/register ```
  **Request body :**
  ```
json
  {
      "name": "omar",
      "email": "omar@example.com",
      "password": "yourpassword"
  }
```
######  Login - POST                      ``` /api/user/login ```
**Request body :**
```
json
{
    "email": "omar@example.com",
    "password": "yourpassword"
}
```

#### Blog Post Endpoints (require authentication)
######  Get All Posts - GET            ``` /api/post ```
######  Get Single Post - GET         ``` /api/post/show/{id} ```
######  Create Post - POST           ``` /api/post/store ```
**Request body :**
```
json
{
    "title": "Your Blog Post Title",
    "content": "The content of your blog post."
}
```
######  Update Post - POST          ``` /api/post/update/{id} ```
**Request body :**
```
json
{
    "title": "Updated Title",
    "content": "Updated content of your blog post."
}
```
######  Delete Post - GET          ``` /api/post/delete/{id} ```

### Authorization
##### User is forced to (update-delete) only his own posts.
###### For all ``` api/post ``` routes  , include an Authorization header with your access token:
**Header body :**
```
json
{
    "access_token": "Your access token"
}
```











