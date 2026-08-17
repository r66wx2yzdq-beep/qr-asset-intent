# qrintent — Fixed-Asset Inventory System with QR Codes

A web application for tracking an organisation's fixed assets: registering equipment,
assigning it to employees and locations, attaching photos, generating QR codes for
fast stock-taking, and importing/exporting data via Excel.

## Tech stack

- PHP + MySQL (mysqli)
- HTML / CSS / JavaScript
- [PhpOffice/PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) — Excel import
- Excel + VBA macro — QR-code generation

## Features

- Two roles: regular user (`php/`) and administrator (`phpadmin/`)
- Full CRUD for assets: add, edit, delete, attach an object photo
- Bulk import of assets and users from Excel
- Export data to Excel for reporting
- QR-code generation by inventory number
- "Presence check" mode (inventory cycle) in the admin panel

## Getting started

1. Clone the repository.
2. Install dependencies: `composer install` (creates the `vendor/` folder).
3. Copy the config and fill in your own values:
   ```bash
   cp config.example.php config.php
   ```
   Values can be set directly in `config.php` or via environment variables
   (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `SQL_KEY`).
4. Create the database and tables (`users`, `usersinfo`, `equipment`).
5. Deploy on a PHP-capable server with the project directory as the web root.

> `config.php` is listed in `.gitignore` and must never be committed.

## Project structure

```
php/         User-facing pages (dashboard, assets, profile, files)
phpadmin/    Admin panel (asset & user management, inventory cycle)
css/         Stylesheets
script.php   Lightweight API endpoint used by the QR/mobile client
config.*.php Database & secret configuration
```

## Known limitations / roadmap

This started as a learning project. Before using it in production I would:

- switch to **prepared statements** — queries are currently built via string
  concatenation (SQL-injection risk);
- **hash passwords** (`password_hash` / `password_verify`) instead of storing them in plain text;
- add CSRF protection and validation of uploaded files;
- move the shared layout/navigation into templates to remove duplication between `php/` and `phpadmin/`.
