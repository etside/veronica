# Veronica Backend - Laravel API

## Architecture

Laravel 11 API-only backend for the Veronica e-commerce frontend.

### Tech Stack
- **Framework**: Laravel 11
- **Auth**: Sanctum (token-based)
- **Database**: SQLite (local) / MySQL 8.0+ (production)
- **PHP**: 8.2+

### Project Structure

```
backend/
├── app/
│   ├── Exceptions/Handler.php          # API exception handler
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── Storefront/         # Public endpoints
│   │   │   │   │   ├── CartController.php
│   │   │   │   │   ├── CheckoutController.php
│   │   │   │   │   ├── OrderController.php
│   │   │   │   │   └── ProductController.php
│   │   │   │   └── Vendor/             # Authenticated endpoints
│   │   │   │       ├── AuthController.php
│   │   │   │       ├── DashboardController.php
│   │   │   │       ├── OrderController.php
│   │   │   │       └── ProductController.php
│   │   │   └── Controller.php
│   │   └── Requests/                   # Form request validation
│   │       ├── CheckoutRequest.php
│   │       ├── LoginRequest.php
│   │       └── StoreProductRequest.php
│   ├── Models/
│   │   ├── Admin.php
│   │   ├── CartItem.php
│   │   ├── Category.php
│   │   ├── Coupon.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   └── Setting.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cors.php
│   ├── database.php
│   └── sanctum.php
├── database/
│   ├── migrations/                     # 8 migration files
│   └── seeders/                        # Demo data seeder
├── routes/
│   ├── api.php
│   └── web.php
├── .env.example
├── artisan
├── composer.json
└── public/index.php
```

## API Endpoints

### Storefront (Public) - `/api/store`

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/products` | List products (paginated, searchable) |
| GET | `/products/{slug}` | Get product by slug |
| GET | `/categories` | List categories |
| POST | `/cart` | Add item to cart |
| GET | `/cart` | Get cart items |
| PUT | `/cart/{id}` | Update cart item |
| DELETE | `/cart/{id}` | Remove cart item |
| DELETE | `/cart` | Clear cart |
| POST | `/checkout` | Place order |
| GET | `/orders/{id}` | Get order by ID |

### Vendor/Admin - `/api/vendor`

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/login` | No | Admin login |
| POST | `/logout` | Yes | Admin logout |
| GET | `/me` | Yes | Get admin profile |
| GET | `/dashboard/stats` | Yes | Dashboard statistics |
| GET | `/dashboard/recent-orders` | Yes | Recent orders |
| GET/POST/PUT/DELETE | `/products` | Yes | Products CRUD |
| GET | `/orders` | Yes | List orders |
| GET | `/orders/{id}` | Yes | Get order details |
| PUT | `/orders/{id}/status` | Yes | Update order status |
| GET/POST/DELETE | `/categories` | Yes | Categories CRUD |
| GET/POST/PUT/DELETE | `/coupons` | Yes | Coupons CRUD |
| GET/PUT | `/settings` | Yes | Store settings |

## Database Schema

- **admins** - Admin users for authentication
- **products** - Products with pricing, stock, images, sizes
- **categories** - Product categories
- **orders** - Customer orders with JSON items
- **order_items** - Individual order line items
- **cart_items** - Shopping cart (guest carts via X-Cart-Token)
- **settings** - Key-value store for store config
- **coupons** - Discount codes with usage limits
- **personal_access_tokens** - Sanctum API tokens
- **password_reset_tokens** - Password reset

## Setup

```bash
# Copy env
cp .env.example .env

# Install dependencies
composer install

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed demo data
php artisan db:seed

# Start server
php artisan serve --port=8000
```

## Default Credentials

- **Email**: admin@veronica.com
- **Password**: password

## Frontend Integration

The Veronica frontend connects via:
- `X-Cart-Token` header for guest cart sessions
- `Authorization: Bearer {token}` for admin authentication
- API base URL: `http://localhost:8000/api`
