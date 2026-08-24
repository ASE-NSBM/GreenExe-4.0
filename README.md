# GreenExE 4.0 — Competition Registration Platform

Laravel application for the **GreenExE 4.0** competition (concept: *Smart Green City*),
organised by the Association of Software Engineering (ASE) at NSBM Green University.

Built to the specification in `GreenExE_4.0_Full_SRS_Plan.docx`.

## Stack

| Component | Technology |
|---|---|
| Backend | PHP 8.3+ / Laravel 13 |
| Frontend | Blade + Tailwind CSS v4 + vanilla JS |
| Database | Supabase PostgreSQL (SQLite for local dev) |
| ORM | Eloquent |
| Build | Vite + npm |
| Auth | Laravel session auth + `admin` middleware |

## Getting started

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build          # or: npm run dev
php artisan serve
```

Set `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` before seeding — `AdminUserSeeder`
skips the admin account when no password is set. Sign in at `/admin/login`.

### Connecting to Supabase

Fill in the Supabase block in `.env` (Project Settings → Database) and switch the driver:

```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-<region>.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.<project-ref>
DB_PASSWORD=<password>
DB_SSLMODE=require
```

Then run `php artisan migrate --seed`. Credentials live only in environment
variables and are never committed (SRS 8.2).

## Structure

| Path | Purpose |
|---|---|
| [config/greenexe.php](config/greenexe.php) | Event name, contacts, team-size limits, categories, registration window |
| [app/Models/](app/Models/) | `Registration`, `TeamMember`, `CompetitionInformation`, `SmartCityContent`, `Faq`, `User` |
| [app/Http/Controllers/](app/Http/Controllers/) | Public pages + registration |
| [app/Http/Controllers/Admin/](app/Http/Controllers/Admin/) | Dashboard, registration management, content, FAQs |
| [app/Http/Requests/StoreRegistrationRequest.php](app/Http/Requests/StoreRegistrationRequest.php) | Server-side validation + duplicate rules |
| [app/Http/Middleware/EnsureUserIsAdmin.php](app/Http/Middleware/EnsureUserIsAdmin.php) | Admin authorisation |
| [resources/views/](resources/views/) | Public Blade pages, `layouts/`, `partials/`, `admin/` |
| [database/seeders/](database/seeders/) | Admin user + placeholder Smart Green City / competition / FAQ content |
| [routes/web.php](routes/web.php) | Public and admin routes |

## Routes

**Public** — `/`, `/about`, `/smart-city`, `/competition`, `/rules`, `/faq`,
`/organizer`, `/contact`, `GET|POST /register`, `/registration/success`

**Admin** — `GET|POST /admin/login`, `/admin/dashboard`, `/admin/registrations`,
`/admin/registrations/{id}` (`GET`/`PATCH`/`DELETE`), `/admin/export`,
`/admin/faqs`, `/admin/content`, `POST /admin/logout`

## Registration behaviour

- Team size is limited by `GREENEXE_MIN_MEMBERS` / `GREENEXE_MAX_MEMBERS`; member
  sections are generated client-side and hidden ones are disabled so they never reach the server.
- Everything is re-validated server-side; nothing is stored unless the whole submission is valid.
- Duplicate student IDs and emails are rejected inside a team and across the competition.
- Each accepted team gets a reference in the form `GX4-26-AB12CD`.
- The confirmation page reads the reference from the session, so registrations are not browsable by URL.

## Admin

Status values: `pending`, `reviewed`, `approved`, `rejected`, `archived`.
Registrations can be searched (reference, team, project, member name/email/student ID),
filtered by status and category, exported as CSV (one row per member),
archived or deleted. FAQs and Smart Green City / competition copy are editable from `/admin/content`.

## Security

- CSRF on every state-changing form, session regeneration on login and logout.
- Rate limits: 10/min on registration, 5/min on admin login.
- Eloquent everywhere; passwords hashed via `bcrypt`.
- Participant data is only reachable behind the `admin` middleware; admin pages are `noindex`.

## Tests

```bash
php artisan test
```

Covers registration success and validation paths, duplicate handling, admin auth
and authorisation, search/filter, status updates, CSV export, and every public page.

## Before production

Confirm with the organisers (SRS 18): official branding, team-size limits,
eligibility, categories, competition rules, contact and social links, hosting target
and domain, Supabase project, and administrator accounts.
