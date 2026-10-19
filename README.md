# Donne TOPUP — Roblox Store

Laravel 12 starter project for a Roblox Robux store. Includes a responsive Blade/Tailwind/Alpine storefront, package selection, server-side coupon validation, order creation/status lookup, and a simple admin dashboard for packages, coupons, and order status.

## Important before launch

This project **does not include a real payment gateway or automated Robux fulfillment**. New orders stay pending. The payment row is marked `manual_setup_required` intentionally. Do not accept customer money until you integrate an authorized provider, verify webhooks, and test the full flow in sandbox. Robux prices are sample values and must be verified against your actual lawful supply costs and Roblox's current rules.

## Requirements

- PHP 8.2+
- Composer 2
- MySQL 8+ (or a compatible MySQL version)
- Node.js and npm are optional for the CDN-based UI; for production, compile Tailwind assets locally.

## Install on Windows 11

1. Install PHP, Composer, and MySQL. Laravel Herd or Laragon can simplify local setup.
2. Create a MySQL database named `donne_topup`.
3. Extract this project and open a terminal in the project directory.
4. Run:

```bash
composer install
copy .env.example .env
php artisan key:generate
```

5. Edit `.env`: set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, and change `SEED_ADMIN_PASSWORD` to a long unique password.
6. Run migrations and seed sample packages:

```bash
php artisan migrate --seed
```

7. Start the app:

```bash
php artisan serve
```

8. Open `http://127.0.0.1:8000`.

Admin: open `/admin/login`, and use `SEED_ADMIN_EMAIL` and `SEED_ADMIN_PASSWORD` from `.env`. The admin account is seeded only if both variables are present when seeding. Change or remove the seed credentials immediately in any shared environment.

## Routes

- `GET /` — storefront
- `GET /api/packages` — active package list
- `POST /coupons/validate` and `POST /api/coupons/validate` — validate coupon
- `POST /orders` and `POST /api/orders` — create pending order
- `GET /orders/{order_number}` — order page
- `GET /api/orders/{order_number}` — status JSON
- `/admin/login` — admin login
- `/admin` — dashboard (admin only)
- `/admin/packages` — package management
- `/admin/coupons` — coupon management

## Payment integration checklist

1. Choose a supported payment provider and obtain merchant approval and sandbox credentials.
2. Add secrets only to environment variables, never source control.
3. Implement a provider service that creates checkout sessions or KHQR/payment requests.
4. Verify webhook signatures and provider transaction status server-side.
5. Enforce idempotency and confirm order amount/currency match the trusted provider record.
6. Update `payments.status`, `payments.paid_at`, and `orders.payment_status` only after verified payment.
7. Add automated tests for duplicate webhooks, invalid signatures, cancelled payments, and mismatched amounts.
8. Add customer notification and staff fulfillment workflow.

## Production security checklist

- Set `APP_ENV=production`, `APP_DEBUG=false`, and a valid `APP_URL`.
- Use HTTPS and secure session cookies.
- Use a strong admin password and restrict admin access.
- Configure backups, logging, monitoring, and rate limits.
- Replace CDN scripts with locally compiled assets and a restrictive Content Security Policy.
- Add privacy/terms/refund policies and a support channel.
- Verify current Roblox terms and delivery eligibility before selling.
- Have payment, coupon, and fulfillment workflows reviewed before going live.

## Tests

Run `php artisan test`. Add integration tests for orders, coupon usage, admin permissions, and payment webhook handling before production.
