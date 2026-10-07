# Inventory Exam - PHP & MySQLi CRUD

## Requirements
- XAMPP
- Apache
- MySQL
- PHP
- phpMyAdmin

## Folder Structure

inventory_exam/
- config/database.php
- create.php
- index.php
- login.php
- logout.php
- Inventory_exam.sql

## Database Setup

1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin.
3. Open the SQL tab.
4. Run `Inventory_exam.sql`.
5. Make sure the database `inventory_exam` exists.

## Run

Put this folder inside:

`C:/xampp/htdocs/`

Then open:

`http://localhost/inventory_exam/login.php`

## Login

Username: `admin`

Password: `admin123`

## CRUD

- CREATE: Add Item
- READ: Inventory List
- UPDATE: Edit
- DELETE: Delete

## Database Configuration

If your MySQL settings are different, edit:

`config/database.php`

Default XAMPP settings:

Host: localhost
Username: root
Password: empty
Database: inventory_exam
