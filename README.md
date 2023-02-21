# Student Management System

Front-end : Vue

Backe-end : Laravel 10

Database  : MySQL

Theme     : Hyper Template Bootstrap 5     

Clone the project

```bash
  git clone https://github.com/robintplavila/student-course.git
```
Go to the project directory

```bash
  cd student-course
```
Install dependencies

```bash
    composer install
    npm install
```
Environment Variables

```bash
    Rename .env.sample to .env    
```

To run this project, you will need to add the following environment variables to your .env file

`MIX_BASE_URL`

`MIX_API_URL`

`JWT_SECRET`

Run database migration scripts

```bash
    php artisan migrate
    php artisan db:seed
```

Start the server

```bash
    php artisan serve
    npm run dev or npm run build
```

Start the server

```bash
    php artisan serve
    npm run dev or npm run build
```

Login (http://127.0.0.1:8000/login)


```bash
    username: admin@admin.com
    password: password
```

Dashboard (http://127.0.0.1:8000/dashboard)

Student (http://127.0.0.1:8000/students)
