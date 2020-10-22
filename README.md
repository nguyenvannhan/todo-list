# Todo List Assessment With Laravel and VueJs

## Setup

```bash
# Use SSH
git clone git@github.com:nguyenvannhan/todo-list-bocasay.git
# Use Http
git clone https://github.com/nguyenvannhan/todo-list-bocasay.git

cd todo-list-bocasay

composer install

npm install

npm run production
```

Copy .env.example to .env and fill necessary info about database and APP_URL

Run migration and seeder command to create database structure and testing data.

```bash
php artisan migrate --seed
```

**Note**:
Please make sure the port of APP_URL and virtual server are same.

```bash
php artisan serve
#This command run server default on port: 8000
```

## Project Description

We have 2 roles: Admin and User
Default accounts are

```bash
#For Admin
Email: admin@gmail.com
Pass: admin

#For User
Email: user@gmail.com
Pass: user
```

-   User just can see assigned tasks and **mark complete** tasks.
-   Admin can:
    -   Create, edit or delete tasks.
    -   Assign tasks to user
    -   Mark completed task.

That's it.
Thank you very much for giving me a chance to make assessment for position at BocaSay Company.
