### Full-Stack LMS – Baseline Project Setup

This repository contains a monorepo scaffold for a **Full-Stack Learning Management System (LMS)** with:

- Laravel API (routes under `routes/api.php`)
- React app in `resources/js` (bundled by Vite)
- Tailwind CSS configured for the React app
- Health check endpoint at GET `/api/health`
- Sample React /health page that calls the API and shows status

## Minimal Structure

```
app/
bootstrap/
config/
database/
public/
resources/
  ├─ css/app.css
  └─ js/ (React source, e.g., main.tsx, routes, pages)
routes/
  ├─ api.php        # contains /api/health
  └─ web.php
vite.config.ts
package.json
composer.json
```

---

## 1. Prerequisites

Ensure the following are installed:

- **PHP** 8.2+
- **Composer** (latest version)
- **Node.js** 18 or 20
- **npm** (comes with Node.js)
- **MySQL** 8+
- **Git**

---

## 2. Environment Variables

`.env.example`
| Variable             | Description                                           | Example Value                  |
|----------------------|-------------------------------------------------------|---------------------------------|
| APP_NAME             | Application name                                      | LMS                             |
| APP_ENV              | Environment type                                      | local                           |
| APP_KEY              | Laravel app key                                       | base64:...                      |
| APP_DEBUG            | Enable debug mode                                     | true                            |
| APP_URL              | URL where Laravel backend runs                        | http://localhost:8000           |
| SESSION_DOMAIN       | Domain for session cookies                             | localhost                       |
| SANCTUM_STATEFUL_DOMAINS | Comma-separated list of stateful domains for Sanctum | localhost,localhost:3000        |
| DB_CONNECTION        | Database connection type                              | mysql                           |
| DB_HOST              | Database host                                         | 127.0.0.1                       |
| DB_PORT              | Database port                                         | 3306                            |
| DB_DATABASE          | Database name                                         | lms_db                          |
| DB_USERNAME          | Database username                                     | root                            |
| DB_PASSWORD          | Database password                                     | (empty or your password)        |

---

## 3. Quick Starts

### Commands assume macOS/Linux; on Windows PowerShell, replace cp with copy. the repository

1. Clone & Install
```
git clone https://github.com/michaeljberry/lms-project.git

cd lms-project
composer install
npm install
```
2. Environment
```
cp .env.example .env
php artisan key:generate
```
3. Database
```
php artisan migrate
```
4. Run the app (two terminals)
```
# Terminal A: Laravel
php artisan serve        # http://127.0.0.1:8000

# Terminal B: Vite dev server (HMR)
npm run dev              # Vite on http://127.0.0.1:5173
```
Open http://127.0.0.1:8000 to use the app. Vite serves assets/HMR behind the scenes.
5. Verify Health
- API: visit http://127.0.0.1:8000/api/health → {"status":"ok"}
- Frontend: visit your React /health route (e.g., http://127.0.0.1:8000/health) and confirm it displays the API status.
---

## 4. Testing the Setup

### API health check
Browser:  
Visit [http://localhost:8000/api/health](http://localhost:8000/api/health) — you should see:
```
{"status":"ok"}
```

cURL:
```
curl http://localhost:8000/api/health
```

Expected response:
```
{"status":"ok"}
```

---

## 5. How It Works

- The (Laravel) exposes an API endpoint at `/api/health` that returns a JSON object `{"status":"ok"}` to indicate the server is running.
- The (React + Vite) has a `/health` page that makes an HTTP GET request to the backend API using Axios, and displays the status.
- Tailwind CSS is configured for styling, with `@tailwind base; @tailwind components; @tailwind utilities;` in `index.css`.
- Environment variables control the URLs and database connection details for local development.
- CORS in Laravel is configured to allow the frontend origin specified in the backend `.env` file.

---

## 6. Acceptance Criteria

- Repository can be cloned and run on a fresh machine without extra configuration beyond documented steps.
- `php artisan migrate` runs successfully and creates database tables.
- Visiting `/api/health` returns `{"status":"ok"}`.
- Visiting `/health` in the frontend shows the API's health status.
- Environment variables are documented and functional.
- Clean commit history with an initial version tag (e.g., `v0.1.0-setup`).

---

## 7. Versioning & First Tag
```
git tag -a v0.1.0-starterkit-setup -m "Initial starter kit setup"
git push --tags
```
---