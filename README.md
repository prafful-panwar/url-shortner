# ShortyLink — Multi-Company URL Shortener

A production-ready URL shortener service built with **Laravel 12**, **Inertia.js**, and **Vue 3**. Designed with strict OOP, SOLID principles, and Laravel best practices.

---

## Architecture

The codebase is structured into clearly separated layers, each with a single responsibility:

| Layer             | Location                | Responsibility                                                  |
| ----------------- | ----------------------- | --------------------------------------------------------------- |
| **Controllers**   | `app/Http/Controllers/` | HTTP in/out only. No business logic.                            |
| **Form Requests** | `app/Http/Requests/`    | Validation & authorization of HTTP input.                       |
| **DTOs**          | `app/DTOs/`             | Typed, immutable data carriers between HTTP and service layers. |
| **Services**      | `app/Services/`         | All business logic. Consumed by controllers.                    |
| **Policies**      | `app/Policies/`         | Authorization rules per model.                                  |
| **Models**        | `app/Models/`           | Eloquent relationships, casts, and semantic helpers only.       |
| **Enums**         | `app/Enums/`            | Type-safe constants with attached domain behavior.              |

---

## Roles & Access Control

| Role         | Can Create URLs | Can See URLs  | Can Invite                     |
| ------------ | --------------- | ------------- | ------------------------------ |
| `SuperAdmin` | ❌              | All companies | Admins (creates new company)   |
| `Admin`      | ✅              | Own company   | Admins + Members (own company) |
| `Member`     | ✅              | Own URLs only | ❌                             |

---

## Tech Stack

- **PHP 8.5** / **Laravel 12**
- **Inertia.js v2** + **Vue 3**
- **MySQL**
- **Bun** (Fast Package Manager & Runtime)
- **Rector** — automated code quality
- **PHPStan (Larastan)** — static analysis (Level 8)
- **Pest 4** — feature tests
- **Laravel Pint** — code formatting

---

## Setup

Follow these steps to get the project running on your local machine:

### 1. Clone the repository

```bash
git clone https://github.com/prafful-panwar/url-shortner.git
cd url-shortner
```

### 2. Database Configuration

This project defaults to **SQLite**. If you wish to use **MySQL**, update the following variables in your `.env` file after the configuration step:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Mail Configuration

This application requires an SMTP server to send invitations. For local development, you can use a free account from **[Mailtrap](https://mailtrap.io/)**. Update your `.env` file with your credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### 4. Automatic Setup

The project includes a convenient setup script that handles dependency installation, environment configuration, key generation, and database preparation:

```bash
composer run setup
```

### 5. Running the Application

To start the development server (including Vite and the Laravel server):

```bash
composer run dev
```

The application will be available at [http://localhost:8000](http://localhost:8000).

### 6. Default Credentials

Once the setup is complete and the application is running, you can log in with the following default superadmin account:

- **Email:** `superadmin@example.com`
- **Password:** `password`

---

## Invitation Flow

1. **SuperAdmin** logs in → **Invitations** → sends invite with a company name and `admin` role.
2. **Admin** logs in → **Invitations** → sends invite with `admin` or `member` role to someone in their company.
3. Invitee receives a link at `/invitations/accept/{token}`, sets their name and password, and is automatically logged in.

---

## Short URL Lifecycle

- Authenticated Admin/Member creates a URL via `/short-urls`.
- A unique 6-character code is generated with collision-safe retry logic.
- Anyone (unauthenticated) can access `/s/{code}` to be redirected. Visit count is incremented on every access.

---

## Code Quality & Testing

We maintain high standards through automated tools:

```bash
# Run all feature tests
php artisan test

# Run the full code quality suite
composer code-shield
```

The `composer code-shield` pipeline runs:

1. **Rector** — automated code improvements
2. **Pint** — code style enforcement
3. **PHPStan** — static analysis (Level 8)
4. **Pest** — feature tests
5. **Pest Type Coverage** — enforces 100% type coverage
6. **ESLint** — Vue/JS linting

---

## Key Design Decisions

- **`UserRole` enum** carries domain behavior (`getAllowedRolesToInvite()`) — logic stays where data lives.
- **`readonly` DTOs** ensure data passed between layers is immutable.
- **`DB::transaction()`** wraps multi-step writes in `InvitationService` to ensure atomicity.
- **Soft deletes** on `ShortUrl` — deleted URLs can be recovered, redirect history preserved.
- **Invokable single-action controllers** (`WelcomeController`, `DashboardController`) for routes with a single responsibility.
- **`ShortUrlPolicy`** enforces create/view/delete rules — controllers never check roles directly (except `canCreate` flag for the UI, derived from a policy check in the Form Request).

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
