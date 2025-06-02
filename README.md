# Advanced PHP Blog (Roles, Auth, CRUD, Search, Pagination)

This task implements a feature-rich blog system using PHP and MySQL, with user roles and advanced CRUD functionality.

## Features

- User registration and login with password hashing
- Session-based authentication
- Role-based access control:
  - **Admin**: Can edit and delete any post
  - **Editor**: Can only edit posts
- Create, read, update, and delete blog posts
- Search posts by title or content
- Pagination (5 posts per page)
- Bootstrap 5 UI

## Setup

1. Import `blog.sql` into your MySQL database.
2. Update database credentials in `db.php` if needed.
3. Run the app using your local web server (e.g., XAMPP).

## Usage

- Register a new user (choose role: admin/editor).
- Login to access the blog dashboard.
- Create, edit, or delete posts (as per your role).
- Use the search bar to find posts.
- Navigate pages using pagination controls.

---
