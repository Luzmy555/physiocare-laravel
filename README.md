<div align="center">
  <img src="public/images/Logo%20actualizado.png" width="96" alt="FisioCare Ayla logo" />

  # FisioCare Ayla

  **A physiotherapy clinic management platform** — public appointment booking, role-based dashboards, clinical records and staff scheduling, built with Laravel.

  [![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
  [![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
  [![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?logo=alpinedotjs&logoColor=white)](https://alpinejs.dev/)
  [![Vite](https://img.shields.io/badge/Vite-7-646CFF?logo=vite&logoColor=white)](https://vitejs.dev/)

  **English** · [Español](README.es.md)
</div>

---

## Overview

FisioCare Ayla is a web application built for a real physiotherapy clinic: a public marketing site where prospective patients learn about the clinic's specialties and book an appointment online, and an internal system where **Administrators**, **Physiotherapists** and **Patients** each get a dashboard tailored to their role — appointments, clinical histories, therapist schedules and clinic-wide stats.

It's a server-rendered Laravel app on purpose: Blade views, Tailwind CSS for styling, and Alpine.js for the small bits of interactivity (live availability lookups, FAQ accordions, image carousels) — no SPA framework or separate frontend build pipeline to maintain.

## Screenshots

<table>
  <tr>
    <td width="100%" colspan="2" align="center">
      <img src="docs/screenshots/landing.gif" alt="Public landing page walkthrough — hero, specialties, testimonials and FAQ" /><br/>
      <sub align="center">Public site — hero, specialties, testimonials &amp; FAQ</sub>
    </td>
  </tr>
  <tr>
    <td width="50%"><img src="docs/screenshots/login.png" alt="Login screen" /><br/><sub align="center">Login</sub></td>
    <td width="50%"><img src="docs/screenshots/dashboard-admin.png" alt="Administrator dashboard with sidebar navigation and clinic-wide stats" /><br/><sub align="center">Administrator dashboard</sub></td>
  </tr>
  <tr>
    <td width="50%"><img src="docs/screenshots/dashboard-fisioterapeuta.png" alt="Physiotherapist dashboard with today's agenda" /><br/><sub align="center">Physiotherapist dashboard — today's agenda &amp; recent clinical notes</sub></td>
    <td width="50%"><img src="docs/screenshots/gestion-citas.png" alt="Admin appointment management screen with filters and confirm/cancel actions" /><br/><sub align="center">Admin — appointment management</sub></td>
  </tr>
</table>

## Features

**Public site**
- Marketing homepage with hero section, clinic overview, nine specialty cards (traumatology, sports, pediatric, geriatric, cardiovascular, respiratory, occupational, palliative and community physiotherapy), patient testimonials and an FAQ section.
- Public appointment booking (no account required): choose a specialty, then only the therapists who cover it, then a date, then only the time slots that therapist actually has free — resolved live via an AJAX endpoint keyed on specialty + schedule.
- Automatic confirmation email sent to the patient once a booking is submitted.

**Appointments**
- Two parallel booking flows: `citas` (internal, created by staff for registered patients) and `citas_publicas` (public bookings, walk-in-style, tracked by email/ID card until the patient has an account).
- Status workflow (`pendiente → confirmada`, plus `cancelada`) with admin actions to confirm or cancel any booking.
- Physiotherapists get a same-day agenda, their full appointment list, and can confirm appointments or attach a clinical note directly from their view.

**Clinical records**
- `historiales_clinicos` links a patient and therapist to observations, diagnosis and treatment for each encounter.
- File attachments per clinical record (PDF, images, Word docs, up to 10MB) — lab results, notes, referrals — stored privately and only downloadable by the treating therapist or an admin.
- Free-text prescriptions (`recetas`) per appointment: the therapist writes medications and instructions, then opens a print-ready, clinic-branded prescription page.
- Access is scoped by role at the controller level, not just hidden in the UI: a physiotherapist's clinical-record list, view, edit and attachments are filtered to their own patients — trying to open another therapist's record returns a 403, even by guessing the URL.

**Staff & scheduling**
- Physiotherapist profiles (contact info, license number, specialty, working hours) manageable from the admin panel.
- Per-therapist weekly schedule (`horarios`: day, available flag, start/end time) — therapists can edit their own via "Mi horario"; availability shown to public visitors is computed from it.

**Platform**
- Custom role-based access control (`CheckRole` middleware) for three roles — `paciente`, `medico` (physiotherapist) and `admin` — stored in a dedicated `roles` table rather than a package, with routes, menus and the dashboard view all adapting to the signed-in role.
- Route-level authorization on top of that: the full patient/specialty/appointment/role catalogs are admin-only; physiotherapists get their own pre-scoped views (`/medico/*`) instead of the general admin CRUD.
- Laravel Breeze-based authentication (registration, login, password reset, email verification).
- Full admin CRUD for patients, physiotherapists, specialties, appointments, users and roles.
- A small shared Blade component library (`components/ui/*`: inputs, buttons, cards, tables, badges) and two layout shells (`components/layouts/internal.blade.php` for the authenticated app, `components/layouts/auth.blade.php` for login/register) so every internal screen shares one consistent, Tailwind-based design system instead of one-off styles per page.

## Tech stack

| Layer | Choice |
|---|---|
| Framework | Laravel 12 (PHP 8.2) |
| Database | MySQL, via Eloquent ORM (SQLite supported for local/dev) |
| Auth | Laravel Breeze, custom `CheckRole` middleware for role-based authorization |
| Frontend | Blade templates, Tailwind CSS 3, Alpine.js, Vite |
| Testing | Pest (unit + feature tests) |
| Tooling | Laravel Pint (code style), Laravel Pail (log viewer), Laravel Tinker |

### A couple of engineering decisions worth mentioning

- **Roles as data, not a package**: instead of pulling in a full permissions package, roles live in a simple `roles` table (`paciente` / `medico` / `admin`) referenced by `rol_id` on the user, checked by a small custom `CheckRole` middleware (`->middleware('role:admin')`). Enough for three fixed roles without the overhead of a general-purpose ACL system.
- **Two appointment tables on purpose**: `citas` serves the original internal booking flow tied to a registered `Paciente`, while `citas_publicas` captures the public, no-login booking flow (identified by ID card/email) that later became the primary one — kept separate rather than forcing both shapes into a single schema.
- **Live availability without a calendar library**: the public booking form calls `/api/fisioterapeutas/{especialidad}` to filter therapists by specialty and working hours as the visitor fills the form, instead of loading every therapist up front or embedding a full calendar widget.

## Roles & permissions

| | Admin | Physiotherapist | Patient |
|---|:---:|:---:|:---:|
| Dashboard (role-specific stats) | ✅ | ✅ | ✅ |
| Manage appointments (confirm/cancel, all) | ✅ | own only | book only |
| Today's agenda / my appointments | – | ✅ | ✅ (own) |
| Clinical records (list/view/edit/attachments) | ✅ (all) | ✅ (own patients only — enforced server-side, 403 otherwise) | – |
| Prescriptions | – | ✅ (own appointments) | – |
| Patients, specialties, internal appointments, roles (CRUD) | ✅ | – | – |
| Users & roles | ✅ | – | – |
| My schedule (weekly working hours) | – | ✅ | – |

## Getting started

### Prerequisites

- PHP 8.2+ and Composer
- Node.js + npm
- MySQL/MariaDB (or SQLite for a quick local run)

### Setup

```bash
git clone https://github.com/Luzmy555/physiocare-laravel.git
cd physiocare-laravel

composer install
npm install

cp .env.example .env
php artisan key:generate
# Set DB_* in .env to your MySQL credentials, or switch DB_CONNECTION=sqlite
# and create database/database.sqlite for a zero-config local run.

php artisan migrate --seed
npm run build

php artisan serve
```

The app will be available at `http://localhost:8000`. Seeding creates the three roles, a set of specialties, and sample physiotherapists — check `database/seeders/` for details.

For active development, `composer run dev` starts the PHP server, queue listener, log viewer and Vite dev server together.

## Project structure

```
app/
├── Http/Controllers/    # Citas, Pacientes, Fisioterapeutas, Especialidades, Historiales, Usuarios, Roles, Horarios, Dashboard...
├── Http/Middleware/     # CheckRole — role-based route access
└── Models/              # Eloquent models (Cita, CitaPublica, Paciente, Fisioterapeuta, Especialidad, HistorialClinico, Horario, Rol, User)
database/
├── migrations/          # Schema per module
└── seeders/             # Roles, specialties & sample physiotherapists/patients
resources/
├── views/
│   ├── components/ui/       # Shared Blade components (input, select, button, card, table, badge...)
│   ├── components/layouts/  # internal.blade.php (authenticated shell) · auth.blade.php (login/register)
│   └── ...                  # public site, auth, admin/, medico/, and role dashboards
├── css/ · js/            # Tailwind entry + Alpine.js
lang/es/                 # Spanish translations (validation, auth, pagination messages)
routes/
└── web.php              # Public routes, resource routes, and role-gated route groups
```

## License

No license file is currently published for this repository — all rights reserved by the author unless a `LICENSE` file is added.
