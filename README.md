# Ghibli Treasures June 2025 Web Technologies Course Project

Ghibli Treasures is a small PHP and MySQL storefront for Studio Ghibli-inspired merchandise. It includes a public home page, searchable shop, session-based cart, simulated checkout, contact form, user authentication, and admin screens for managing products and users.

## Project Overview

The application is built with plain PHP, MySQLi, HTML, CSS, and a little vanilla JavaScript. It does not use a PHP framework or package manager, so it can run in a local Apache/PHP/MySQL stack such as XAMPP, WAMP, Laragon, or MAMP.

Core features:

- Home page with rotating Ghibli quotes and intro imagery.
- Product shop with search and category filters.
- Login and signup modal shared through the site header.
- User sessions for authentication and cart state.
- Cart quantity controls and item removal.
- Checkout flow that creates orders, order items, and decrements stock.
- Admin-only product management with image upload.
- Admin-only user management with promote, demote, and delete actions.
- Contact form using PHP `mail()`.

## Folder Structure

```text
.
|-- css/                  # Page-specific and shared stylesheets
|-- database/             # MySQL database export
|-- images/               # General site imagery
|-- includes/             # Shared header, footer, and database connection
|-- productimages/        # Product catalog and uploaded product images
|-- videos/               # Home page background video
|-- index.php             # Home page
|-- shop.php              # Product listing, search, and filtering
|-- cart.php              # Shopping cart and payment modal
|-- add-to-cart.php       # Adds products to session/database cart
|-- update-cart.php       # Updates cart quantities or removes items
|-- process-payment.php   # Creates orders and updates stock
|-- contact.php           # Contact form page
|-- handle-login.php      # Login handler
|-- handle-signup.php     # Signup handler
|-- logout.php            # Session logout
|-- admin_dashboard.php   # Admin product management UI
|-- admin_product_handle.php
|-- admin_manage_users.php
`-- hash.php              # Small password hashing helper
```

## Requirements

- PHP 8.x or compatible PHP 7.x installation
- MySQL or MariaDB
- A local web server capable of serving PHP files
- PHP extensions for `mysqli` and, if using the contact form, `mail`

The database connection is configured in `includes/db_connect.php`:

```php
$host = 'localhost';
$db = 'ghibli_store';
$user = 'root';
$pass = '';
```

Update those values if your local database username, password, host, or database name differs.

## Database Setup

The database export is included at:

```text
database/ghibli_store.sql
```

It is a phpMyAdmin export for the `ghibli_store` database and includes the tables and sample data used by the project:

- `users`
- `products`
- `cart_items`
- `orders`
- `order_items`
- `remember_tokens`

To import it with phpMyAdmin:

1. Open phpMyAdmin.
2. Create a database named `ghibli_store`.
3. Select the new database.
4. Open the Import tab.
5. Choose `database/ghibli_store.sql`.
6. Run the import.

To import it from the terminal:

```sql
mysql -u root -p ghibli_store < database/ghibli_store.sql
```

If your local MySQL root user has no password, omit `-p`.

## Running Locally

1. Place the project folder inside your local web server document root.
   - XAMPP example: `htdocs/webPj`
   - Laragon example: `www/webPj`
2. Start Apache and MySQL.
3. Create the `ghibli_store` database and import `database/ghibli_store.sql`.
4. Check the credentials in `includes/db_connect.php`.
5. Open the site in your browser, for example:

```text
http://localhost/webPj/index.php
```

## Main Pages

- `index.php` shows the home page, story sections, featured products, and random quote/image content.
- `shop.php` loads products from MySQL and supports `search` and `category` query parameters.
- `cart.php` displays the session cart and opens a payment modal.
- `contact.php` displays a contact form and submits with PHP `mail()`.
- `admin_dashboard.php` is available only to users with `role = 'admin'`.
- `admin_manage_users.php` is available only to admins and can promote, demote, or delete users.

## Authentication and Cart Flow

Users sign up through `handle-signup.php`, which validates required fields, hashes the password, stores the user, and starts a session. Users log in through `handle-login.php`, which verifies the password and stores `user_id`, `username`, and `role` in `$_SESSION`.

Adding a product to the cart requires a logged-in user. Cart items are stored in both `$_SESSION['cart']` and the `cart_items` table. The checkout handler reads the session cart, creates an order, creates order item rows, decrements product stock, and clears the session cart.

## Styling and Assets

Shared styles are in `css/style.css`, `css/navbar.css`, `css/footer.css`, and `css/login.css`. Page-specific styles are loaded conditionally from `includes/header.php`, depending on the current PHP file.

Product images live in `productimages/`. New product images uploaded from the admin dashboard are saved into that folder with a timestamp prefix.


