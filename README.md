# PHP CRUD Application

This is a simple PHP CRUD (Create, Read, Update, Delete) application for managing notes. It uses MySQL for data storage and Bootstrap for styling.

## Features

- Add, edit, and delete notes
- Responsive UI with Bootstrap
- DataTables integration for enhanced table features

## Requirements

- PHP (7.x or newer)
- MySQL server
- Web server (e.g., Apache, XAMPP, WAMP, MAMP)

## Setup Instructions

1. **Clone or copy the project files**  
   Place `index.php` in your web server's root directory (e.g., `htdocs` for XAMPP).

2. **Create the Database and Table**
   - Open phpMyAdmin or use the MySQL command line.
   - Run the following SQL to create the database and table:

     ```sql
     CREATE DATABASE IF NOT EXISTS crud;
     USE crud;
     CREATE TABLE IF NOT EXISTS notes (
       sr_no INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       description TEXT,
       timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

3. **Configure Database Connection**  
   The database connection is set in `index.php`:
   ```php
   $conn = mysqli_connect("localhost", "root", "", "crud");
   ```
   - Change the username or password if your MySQL setup is different.

4. **Start Your Web Server and MySQL**  
   - Make sure Apache and MySQL are running.

5. **Access the Application**  
   - Open your browser and go to [http://localhost/index.php](http://localhost/index.php) (or the correct path if in a subfolder).

## Usage

- **Add Note:** Fill in the form and click "Add Note".
- **Edit Note:** Click the "Edit" button next to a note, modify the details, and save.
- **Delete Note:** Click the "Delete" button and confirm.

## Dependencies

- [Bootstrap 4](https://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [DataTables](https://datatables.net/)

All dependencies are loaded via CDN.

## Security Notice

This project uses raw SQL queries with user input. For production use, always sanitize inputs and use prepared statements to prevent SQL injection.

---

**Author:**  
Your Name
