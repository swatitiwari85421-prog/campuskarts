# CampusKart — ITT Assignment

A responsive second-hand books and gadgets marketplace for college students, built with **HTML, CSS, Bootstrap 5, PHP and MySQLi**.

## Assignment coverage
The project contains the 8 requested pages:
1. Home — hero banner, featured items, category cards
2. Products — product grid, search, category filter and budget filter
3. Product Details — image, price, condition, seller and Add to Cart
4. Register — server-side validation and password hashing
5. Login — session-based authentication
6. Cart — quantity update, total and remove
7. Checkout / Order Confirmation — address form, order summary and saved order
8. Contact / About — contact form and team information

Advanced PHP included:
- Server-side validation for required fields, email and password length
- `password_hash()` and `password_verify()`
- MySQLi prepared statements for user input
- `htmlspecialchars()` output escaping through helper `e()`
- Cart and checkout restricted to logged-in users
- PHP sessions and session ID regeneration after login

Innovative touches included:
- New / Good / Fair condition badges
- Sell Your Item listing form (available on Products page)
- Budget filter (under ₹200 / ₹500 / ₹1,000 / ₹2,000)

## Requirements
- XAMPP (Apache + MySQL)
- PHP 8.0+ recommended
- MySQL / MariaDB
- Internet connection for Bootstrap CDN, Bootstrap Icons and Google Fonts

## Run locally
1. Copy the `CampusKart` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** from XAMPP Control Panel.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Import `database.sql` (this creates the `campuskart` database and tables).
5. If your MySQL username/password differs, edit `config/db.php`.
6. Open `http://localhost/CampusKart/` in your browser.
7. Register a student account.
8. Use **Products → Sell your item** to add products. Add an image URL from a publicly accessible image.

## Important notes
- This is an academic demonstration project. The checkout creates an order record; it does not process real payments or arrange delivery.
- The contact form validates and displays a demo success message; it does not send email or store messages.
- Product images are supplied as image URLs. For a production deployment, add secure file uploads, image validation and moderation.
- Do not use real passwords or personal information in a public classroom demo.

## Suggested demonstration
Register → Login → Products → Sell an item → open product details → Add to Cart → update quantity → Checkout → Order Confirmation.
