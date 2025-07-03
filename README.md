# Ticketing System – CodeIgniter 4

This is a lightweight ticketing system built using [CodeIgniter 4](https://codeigniter.com/), a PHP MVC framework. It includes user authentication, role-based access, and automatic ticket status updates based on responses.

## Prerequisites

Ensure the following are installed and properly configured on your system:

- **PHP 8.0+**  
  Make sure PHP is available globally in your terminal.

- **Composer**  
  PHP dependency manager. Also available globally in terminal.

- **SQLite**  
  This project uses SQLite by default. Enable the following extensions in your `php.ini` file:
  - `curl`
  - `fileinfo`
  - `intl`
  - `mbstring`
  - `openssl`
  - `pdo_mysql`
  - `sqlite3`
  - `zip`

- **Web Server**  
  You can use the built-in development server via `php spark serve`.

- **GitHub for Windows** (or Git CLI)  
  Use this to clone the project repository.

## Libraries Used

### [CodeIgniter4/Shield](https://github.com/codeigniter4/shield)

This is CodeIgniter's official authentication and authorization library. It provides:

- User registration & login
- Role-based permissions
- Group management
- Session & token handling

## Setup Instructions

### 1. Clone the Repository

Use **GitHub for Windows** to clone this repository, or run the following in a terminal:

```bash
git clone https://github.com/alexyspol/ingeeky.git
cd ingeeky
```

### 2. Install Dependencies

Run this from the root of the project directory:

```bash
composer install
```

This will install all PHP packages defined in `composer.json`.

### 3. Configure the Environment

Create a `.env` file in the root of the project and add the following:

```dotenv
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080'
```

This enables development mode and sets the base URL used by CodeIgniter.

### 4. Run Migrations

Run all database migrations:

```bash
php spark migrate --all
```

**What this does:** Migrations create the required database tables such as `users`, `tickets`, and `ticket_messages`, as defined in the project’s `App/Database/Migrations` folder.

### 5. Run Seeders

Seeders populate your database with sample data:

```bash
php spark db:seed UsersSeeder
```

**What this does:** This will create three default users (admin, support, and a test user) with preset roles and passwords. You can log in with these credentials for testing.

### 7. Start the Development Server

Use CodeIgniter’s built-in development server by running the following command:

```bash
php spark serve
```

Sometimes when running the development server, you may encounter an error:

```bash
php spark serve
"" # (nothing happens)
```

If this happens, manually create a cache folder inside the writable directory.

### 8. Access the Application

Open your browser and visit:

```
http://localhost:8080
```

You can now register a new user or log in with one of the seeded accounts.

### Default Seeded Users

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@ingeeky.com | password |
| Support | support@ingeeky.com | password |
| User | user@ingeeky.com | password |

### Notes

- When a new ticket is created, its status is set to `open` by default.
- Ticket statuses are updated automatically:
   - If a user replies → status changes to `customer replied`.
   - If an admin or support replies → status changes to `awaiting customer`.
