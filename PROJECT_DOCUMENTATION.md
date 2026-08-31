# Libas-e-Khas - E-Commerce Platform Documentation

## 1. Project Overview
**Libas-e-Khas** is a bespoke e-commerce platform built for a boutique clothing brand. It is developed using a native technology stack designed for performance, customizability, and straightforward hosting.

**Tech Stack:**
*   **Backend:** PHP (Vanilla/Native)
*   **Database:** MySQL (interfaced via `mysqli`)
*   **Frontend HTML/CSS:** Bootstrap 5, Custom CSS
*   **Frontend Javascript:** Vanilla JS, jQuery (for specific plugins like DataTables)
*   **Plugins & Libraries:** SweetAlert2 (for modals/alerts), FontAwesome (icons), DataTables (admin table sorting/pagination).

---

## 2. Directory Structure

### Root Directory (`/`)
This is the main public-facing frontend of the website.
*   `index.php`: The homepage showcasing featured collections, banners, and top products.
*   `shop.php`: The main product listing page where customers browse categories and products.
*   `product-details.php`: Individual product pages displaying gallery images, descriptions, sizes, colors, and the "Add to Cart" function.
*   `checkout.php`: The final step in the customer journey where shipping details and payment methods (e.g., COD, Bank Transfer with proof upload) are collected.
*   `about.php`, `contact.php`, `faqs.php`, `return-exchange.php`: Static informational pages for customer support and brand identity.

### Support Directories
*   `assets/`: Contains subdirectories for images, fonts, and global styling assets.
    *   `assets/images/products/`: Uploaded product images.
    *   `assets/images/categories/`: Uploaded category banners/icons.
*   `css/` & `js/`: Core stylesheets and javascript files for the frontend UI.
*   `inc/`: Shared backend includes. Contains the critical `db.php` which establishes the MySQL connection for the entire application.
*   `ajax/`: Frontend AJAX endpoints (e.g., handling "add to cart" operations dynamically without page reloads).

---

## 3. The Admin Panel (`/admin`)
The backend management system, protected by session-based authentication (`login.php`). It provides full CRUD (Create, Read, Update, Delete) capabilities for the store.

### Core Admin Pages
*   **`dashboard.php`**: The central hub. It actively queries the database to display real-time analytics.
    *   *Catalog Overview*: Displays live counts of Total Categories, Total Products, In-Stock Products, and Out-of-Stock Products.
    *   *Order Overview*: Displays colored status cards tracking Total, Pending, In Progress, Delivered, and Cancelled orders.
    *   *Recent Orders*: A dynamic table automatically fetching orders placed in the last 3 days.
*   **`orders.php`**: The command center for order fulfillment.
    *   Displays all orders with a rigorous 4-stage workflow: **Pending &rarr; In Progress &rarr; Delivered / Cancelled**.
    *   Features a custom 100vh Fullscreen Lightbox Modal to securely verify uploaded payment proofs without leaving the page.
    *   "Delivered" and "Cancelled" are locked, terminal states that protect against accidental status overrides.
*   **`categories.php`**: Manage parent collections. Features a dynamic column that calculates and displays exactly how many products belong to each category using SQL subqueries.
*   **`sub-categories.php`**: Manage nested collections. Also features live product counts linked via `sub_category_id`.
*   **`products.php`**: Main inventory list.
*   **`add-product.php` & `edit-product.php`**: Complex forms handling multi-image uploads (main, hover, and gallery), pricing (including automated sale price toggles), stock management, and attribute linking (fabric, collection, sizes).
*   **`contacts.php`**: Viewing messages submitted via the frontend `contact.php` form.
*   **`reviews.php`**: Managing customer product reviews, including approval workflows (`approve-review.php`).
*   **`settings.php`**: Global site configuration.

### Admin Support Files
*   **`inc/`**: Contains structural UI files like `admin-topbar.php`, `admin-sidebar.php` (which dynamically badges the number of pending orders), and `admin-top.php`/`admin-bottom.php` for shared `<head>` and script tags.
*   **`ajax/`**: Backend-specific endpoints handling asynchronous operations (e.g., `process-product.php` for complex multipart form uploads, `toggle-status` for instantly disabling categories, and `delete-product.php`).

---

## 4. Database Architecture
The database is structured relationally. Core tables include:

1.  **`users`**: Stores administrator credentials (hashed passwords) for accessing the backend.
2.  **`categories`**: Stores top-level collections (`id`, `name`, `image`, `status`).
3.  **`sub_categories`**: Stores nested collections (`id`, `category_id` linking to the parent, `name`, `status`).
4.  **`products`**: The central inventory table.
    *   Foreign Keys: `category_id`, `sub_category_id`.
    *   Data: `name`, `price`, `salePrice`, `description`, `fabric`, `stock`, `availability` ('In Stock', 'Out of Stock').
5.  **`product_images`**: A one-to-many relationship table linked to `products.id` to store multiple gallery images per product.
6.  **`orders`**: Tracks the top-level customer purchase.
    *   Customer details: Name, email, shipping address, phone.
    *   Financials: `total_amount`, `payment_method`, `payment_proof` (file path).
    *   Tracking: `status` ('Pending', 'In Progress', 'Delivered', 'Cancelled').
7.  **`order_details`**: A one-to-many relationship table linked to `orders.id`. Stores the exact snapshot of what was purchased (the `product_id`, the specific `product_size`, `quantity`, and historical `price` at the time of purchase).
8.  **`contacts` & `reviews`**: Stores user-generated feedback and inquiries.

---

## 5. Notable Technical Implementations & Security
*   **Output Buffering (`ob_start`)**: Used strategically in pages like `orders.php` to prevent Bootstrap Modals injected inside HTML tables from corrupting the browser's DOM structure.
*   **Prepared Statements**: Extensively used across the application (e.g., in AJAX processors and DB migrations) to strictly prevent SQL Injection attacks.
*   **Dynamic UI States**: The application relies heavily on visual cues. Order badges dynamically change color based on database states (Warning for pending, Info for progress, Success for delivered, Danger for cancelled). Buttons intelligently disappear when an order reaches a terminal state to prevent logic errors.
