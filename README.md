# 🎬 Cinema Project

A cinema management system built with **Laravel 12**. It includes an authenticated admin dashboard for managing movies, a public API for a mobile app (no login required), and an AI-powered chatbot that answers questions using the site's real movie data.

## ✨ Features

### Admin Dashboard (Blade)
- Login / Register (session-based authentication)
- Full movie management: create, view, edit, delete
- Image upload with automatic cleanup of old/removed images
- Built-in AI Chatbot page

### Public API (no authentication — mobile app)
- Browse all movies
- View movie details
- Add / view / remove movies from a personal watchlist, identified by a `device_id` (no login needed)

### AI Chatbot
- Powered by Google Gemini
- Answers are grounded in the site's actual movie data (title, description, year, rating) so it won't invent details about movies that don't exist

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 12 (PHP 8.2+) |
| Database | MySQL / SQLite |
| Frontend | Blade + Tailwind CSS (CDN) |
| Asset bundling | Vite |
| AI | Google Gemini API |
| Testing | Pest |

## 🚀 Getting Started

### 1. Clone the repository
```bash
git clone https://github.com/MohammedHaitham007/Cinema_Project.git
cd Cinema_Project
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

Then open `.env` and configure your database connection. The project supports either:

**Option A — SQLite (simplest, no setup needed):**
```env
DB_CONNECTION=sqlite
```
Create an empty file at `database/database.sqlite`.

**Option B — MySQL (e.g. via XAMPP):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinema
DB_USERNAME=root
DB_PASSWORD=
```
Make sure MySQL is running and a `cinema` database exists.

Also add your Gemini API key for the chatbot to work:
```env
GEMINI_API_KEY=your_api_key_here
```

### 4. Run migrations and seed sample data
```bash
php artisan migrate:fresh --seed
```
This creates a default admin account (`admin@cinema.com` / `password`) and 10 sample movies.

### 5. Link storage (required for movie images)
```bash
php artisan storage:link
```

> ⚠️ **Note:** If you run the project with `php artisan serve` on Windows, uploaded images may return a `403 Forbidden` error. This is a known limitation of PHP's built-in development server, which does not follow symbolic links for security reasons. To avoid this, serve the project through **Apache** (e.g. via XAMPP) instead.

### 6. Run the app
```bash
php artisan serve
```
Or place the project under XAMPP's `htdocs` folder and access it through Apache.

## 📡 API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/movies` | List all movies |
| GET | `/api/movies/{id}` | Get a single movie's details |
| GET | `/api/watchlist?device_id=...` | Get a device's watchlist |
| POST | `/api/watchlist` | Add a movie to the watchlist (`device_id`, `movie_id`) |
| DELETE | `/api/watchlist/{id}` | Remove a movie from the watchlist (by watchlist id or movie id) |
| POST | `/api/chatbot/send` | Send a message to the chatbot |

## 🗄️ Database Schema

**movies**: `id`, `title`, `description`, `release_year`, `rating`, `image`

**watchlists**: `id`, `device_id`, `movie_id` (foreign key) — identified purely by device, no login required

**users**: standard Laravel authenticatable user (used only for the admin dashboard)

## 🔑 Default Admin Credentials

```
Email: admin@cinema.com
Password: password
```

## 📄 License

This project was built for educational purposes.
