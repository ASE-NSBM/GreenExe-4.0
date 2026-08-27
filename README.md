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
| Admin | Filament v5 panel at `/admin` |
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
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.<project-ref>
DB_PASSWORD=<password>
DB_SSLMODE=require
```

Use the **session** pooler on port 5432. The transaction pooler (6543) breaks
PDO prepared statements, and the direct `db.<project-ref>.supabase.co` host is
IPv6-only, so it is unreachable from IPv4 networks. Supabase provides the
database only — authentication is Laravel's session guard behind the Filament
panel, and Supabase Auth is not used.

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

**Admin** — the Filament panel owns `/admin`:

| Path | Purpose |
|---|---|
| `/admin/login`, `POST /admin/logout` | Panel authentication (FR-56, FR-57) |
| `/admin` | Dashboard with summary widgets (FR-58) |
| `/admin/registrations` | List, search, filter (FR-59 to FR-61) |
| `/admin/registrations/{id}` | Full team and project details (FR-62, FR-63) |
| `/admin/registrations/{id}/edit` | Edit team, project and status; manage members (FR-62 to FR-64) |
| `/admin/export` | CSV export, one row per member (FR-66) |
| `/admin/faqs` | Manage FAQs (FR-67) |
| `/admin/competition-information` | Competition and organizer copy (FR-68, FR-70) |
| `/admin/smart-city-contents` | Smart Green City copy (FR-69) |

### How this maps to SRS 7.1

The SRS route table predates the choice of Filament, which is Livewire-based and
does not expose `PATCH`/`DELETE` endpoints per record — status changes, archiving
and deletion are panel actions against the same models. Every requirement in
Module 9 is covered; two documented paths are kept as redirects so the addresses
in the SRS still resolve:

| SRS 7.1 | Now |
|---|---|
| `GET /admin/dashboard` | redirects to `/admin` |
| `GET/POST /admin/content` | redirects to `/admin/competition-information` |
| `PATCH /admin/registrations/{id}` | "Set status" action (FR-64) |
| `DELETE /admin/registrations/{id}` | "Archive" and "Delete" actions (FR-65) |
| `GET /admin/export` | unchanged — a real streamed download |

Registrations cannot be created from the panel; they only arrive through the
public form. Team and project fields are editable there, with the same rules
`StoreRegistrationRequest` applies, so a correction cannot store something the
public form would have rejected. Members are managed in a relation manager on the
view and edit pages: each one can be opened on its own, edited, added or removed.
`member_count` follows the member list, and promoting a member to team leader
demotes the previous one. Access is gated by `User::canAccessPanel()`, which reuses the same
`isAdmin()` role check as the rest of the app (FR-71).

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
filtered by status and category, exported as CSV (one row per member), archived or
deleted. FAQs, competition copy, organizer details and Smart Green City content are
edited as Filament resources.

Filament publishes its own assets to `public/css/filament` and `public/js/filament`.
After upgrading the package run `php artisan filament:upgrade` (already wired into
`composer update` by the package).

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
