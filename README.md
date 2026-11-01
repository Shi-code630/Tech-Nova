# 🚀 Tech-Nova

### A Modern Web-Based E-Commerce Management System

Tech-Nova is a web-based e-commerce platform developed to provide an organized and user-friendly online shopping experience. It includes product management, customer management, content management, and online payment integration.

The project is built using Laravel and modern web technologies, with a focus on usability, maintainability, and efficient management.

---

## 📌 Project Overview

Tech-Nova aims to simplify online shopping and administrative operations through a centralized web application.

The system provides an administrative dashboard for managing products, customers, blogs, and other essential e-commerce operations.

## ✨ Key Features

- **Product Management** – Manage products and product images.
- **Category Management** – Organize products into categories.
- **Customer Management** – Manage customer information and addresses.
- **Blog Management** – Create, update, and manage blog content.
- **Admin Dashboard** – Manage important application data through an administrative interface.
- **Online Payment Integration** – Khalti payment gateway integration.
- **Shopping Cart** – Manage selected products before checkout.
- **Order Management** – Manage customer orders and related information.
- **Responsive User Interface** – Designed for different screen sizes.

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend Programming |
| Laravel | Backend Framework |
| Filament | Admin Panel |
| MySQL | Database |
| HTML5 | Structure |
| CSS3 | Styling |
| JavaScript | Frontend Interactivity |
| Tailwind CSS | UI Styling |
| Blade | Laravel Templating |
| Git & GitHub | Version Control |
| Khalti | Payment Integration |

## 📂 Project Structure

```text
Tech-Nova/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Filament/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
├── storage/
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## ⚙️ Installation and Setup

Follow these steps to run the project locally.

### 1. Clone the Repository

```bash
git clone https://github.com/Shi-code630/Tech-Nova.git
```

### 2. Navigate to Project Directory

```bash
cd Tech-Nova
```

### 3. Install PHP Dependencies

```bash
composer install
```

### 4. Install Frontend Dependencies

```bash
npm install
```

### 5. Configure Environment

Copy the example environment file:

```bash
copy .env.example .env
```

Configure your database credentials in the `.env` file.

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

Run the frontend development server in another terminal:

```bash
npm run dev
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

## 💳 Payment Integration

Tech-Nova integrates the Khalti payment gateway to support online payment processing.

Payment integration requires valid Khalti credentials and appropriate environment configuration.

Never expose payment secret keys or other sensitive credentials in the repository.

## 🔐 Environment Configuration

Make sure to configure the following in your `.env` file:

- Application environment
- Database connection
- Database name
- Database username and password
- Payment gateway credentials

**Important:** Never commit your `.env` file or sensitive API credentials to GitHub.

## 🌐 Repository

GitHub: https://github.com/Shi-code630/Tech-Nova

## 👨‍💻 Development

This project was developed as a collaborative software development project.

## 📄 License

No license has been specified for this project yet.

---

⭐ If you find this project interesting, feel free to explore the repository and its features.

**Built with ❤️ using Laravel and modern web technologies.**
