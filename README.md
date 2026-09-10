# Cinema Project

A Laravel project featuring an **Admin Dashboard** (Blade) for managing movies and a **Public Versioned JSON API** (`/api/v1`) for mobile app integration.

---

## Setup & Running Guide

### 1. Storage Link
Create the symbolic link from `public/storage` to `storage/app/public` so movie posters are publicly accessible:
```bash
php artisan storage:link
```

### 2. Run Migrations & Seed Data
Run database migrations and seed default data (admin account + 10 sample movies):
```bash
php artisan migrate:fresh --seed
```

### 3. Default Credentials
- **Admin Dashboard Email:** `admin@cinema.com`
- **Password:** `password`

---

## Architecture & Features

### Part 1 — Admin Dashboard (Blade)
- **Authentication:** Protected under `auth` middleware group. Guests are redirected to `/login`.
- **Movie Management (CRUD):**
  - View paginated movies grid at `/movies`.
  - Create new movie with poster image upload at `/movies/create`.
  - View movie details at `/movies/{id}`.
  - Edit existing movie pre-filled with poster preview at `/movies/{id}/edit`. Automatically deletes old poster file from storage when replaced.
  - Delete movie with image file cleanup from storage.
- **Validation:** Uses `CreateMovieRequest` and `UpdateMovieRequest` (Image validated as `nullable|image|mimes:jpeg,png,jpg,webp|max:2048`).

### Part 2 — Public Mobile API (Prefix: `/api/v1`)
No authentication required — users are identified by `device_id`. All responses return consistent JSON: `{ "message": "...", "data": ... }`.

1. **GET `/api/v1/movies`**
   - List all movies formatted using `MovieResource` with full poster URL (`asset('storage/...')`).

2. **GET `/api/v1/movies/{id}`**
   - Retrieve single movie details. Returns `404` if movie does not exist.

3. **POST `/api/v1/watchlist`**
   - Add a movie to a device's watchlist.
   - **Body:** `{ "device_id": "string", "movie_id": integer }`
   - Validated via `StoreWatchlistRequest`. Prevents duplicate entries for the same `device_id` + `movie_id`.

4. **GET `/api/v1/watchlist?device_id=...`**
   - Retrieve all movies in a device's watchlist (returns full movie data).
   - Requires `device_id` query parameter (returns `422` if missing).

5. **DELETE `/api/v1/watchlist/{id}`**
   - Remove a movie from a device's watchlist by watchlist ID (or by `device_id` + `movie_id`).

---

## Running Tests
Run the test suite using Pest / PHPUnit:
```bash
TERM=dumb php vendor/bin/pest
```
