# User Authentication System (PHP & MySQL)

This project is a simple user authentication system that allows users to register, log in, update their profile, change their username, delete their account, and log out.

---

## 📁 File Descriptions

### 1️⃣ `config.php`
- Establishes **a connection to the MySQL database**.
- Required in all files for database access.

### 2️⃣ `register.php`
- Provides a **registration form** for new users.
- If the database **already has registered users**, a **"Login Here" link is always visible**.
- Upon successful registration, a **success message appears** with a login link.
- Stores **first name, last name, username, and password** in the `client` table.

### 3️⃣ `login.php`
- Provides a **login form** for existing users.
- Verifies **username and password** from the database.
- Upon successful login, **redirects to `dashboard.php`**.
- Stores **username in session** (`$_SESSION["username"]`).

### 4️⃣ `dashboard.php`
- Displays **user details** (first name, last name, username).
- Allows users to **update their profile**:
  - Users can **change their username** without using an ID column.
  - When the username is updated, **the session is updated dynamically**.
- Allows users to **delete their account**:
  - If the account is deleted, the **session is destroyed** and the user is **redirected to `register.php`**.
- Includes a **logout button**.

### 5️⃣ `logout.php`
- Ends the user session and **redirects to `login.php`**.
- Prevents logged-out users from accessing `dashboard.php`.

---

## 🔹 Additional Functionalities

✅ **Login button visibility**  
   - The login link is **always visible** in `register.php` **only if records exist** in the database.  
   - After registration, another login link appears only for that session.  

✅ **Username Change Handling**  
   - If a user changes their username in `dashboard.php`, **the session variable updates immediately**.  
   - This ensures that the new username is used throughout the session.

✅ **Redirection Rules**  
   - **Successful login → Redirects to `dashboard.php`**.  
   - **Logging out → Redirects to `login.php`**.  
   - **Deleting an account → Redirects to `register.php`**.  

✅ **Security Considerations**  
   - Uses **prepared statements** to prevent **SQL injection**.  

---

## 🛠 How to Set Up the Project

1️⃣ **Import the Database**
   - Create a database named `assessment`.
   - Create a `client` table with the following structure:
     ```sql
     CREATE TABLE client (
         first_name VARCHAR(255),
         last_name VARCHAR(255),
         username VARCHAR(255) PRIMARY KEY,
         password VARCHAR(255)
     );
     ```
   - Ensure your `config.php` file has the correct database credentials.

2️⃣ **Run XAMPP & Start Apache & MySQL**  
3️⃣ **Place all files inside `htdocs` in your XAMPP directory**  
4️⃣ **Access the application via `http://localhost/project_folder/`**  
5️⃣ **Register a user and log in**  
6️⃣ **Test updating and deleting the account**  

---

This document serves as a guide for setting up and understanding the authentication system. 🚀
