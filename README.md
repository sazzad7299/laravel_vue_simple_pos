
# Project Setup Guide

This guide provides instructions for setting up the Laravel + Vue.js project.

## Prerequisites

- Git installed on your machine
- PHP installed on your machine
- Composer installed on your machine
- Node.js and npm installed on your machine
- MySQL or another compatible database management system installed on your machine

## Setup Instructions

### 1. Clone the Repository
Clone the GitHub repository for the project to your local machine:
    `git clone git@github.com:sazzad7299/laravel_vue_simple_pos.git`
### 2. Create Database
Create a new database  `<db_name>`.
### 3. Configure Environment
cd <project_directory>
    `cp .env.example .env`
    modify `.env` file
    `
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<db_name>
    DB_USERNAME=<your_database_username>
    DB_PASSWORD=<your_database_password>
    ` 
### 4. Install Composer
    `composer install`
Generate App Key
    `php artisan key:generate`
###5. Upload Database
Import the provided database dump (db/db.sql) into the database you created in Step 2.
### 6. Install Dependencies
    `npm install && npm run dev`
### 7. Run Project
Once the setup is complete, you can start the Laravel development server to run the project:
    `php artisan serve`
*** NOTE ***
By Default, here create a admin, role, and permission for login and access controll.
### LOGIN Credentials
`email`:`admin@gmail.com`
`password`:`password`
