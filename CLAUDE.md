# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Quick Start
```bash
# Start complete development environment (recommended)
composer dev

# This runs concurrently:
# - Laravel server (php artisan serve)
# - Queue listener (php artisan queue:listen)
# - Real-time log viewer (php artisan pail)
# - Vite dev server (npm run dev)
```

### Testing
```bash
# Run test suite
composer test

# Run specific test
php artisan test --filter TestName

# Run with coverage
php artisan test --coverage
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration (drop all tables)
php artisan migrate:fresh

# Seed database
php artisan db:seed
```

### Filament Commands
```bash
# Create new resource
php artisan make:filament-resource ModelName

# Create new page
php artisan make:filament-page PageName

# Upgrade Filament
php artisan filament:upgrade
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific file
./vendor/bin/pint path/to/file.php
```

### Production Build
```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Architecture Overview

### Application Type
Laravel 12.0 application with Filament 3.3 admin panel and real-time broadcasting features using Laravel Reverb.

### Key Components

1. **Models & Relationships**
   - `House` → has many `Post` (one-to-many)
   - `Post` → belongs to `House`
   - Models located in `app/Models/`

2. **Filament Resources**
   - `HouseResource`: Simple CRUD for houses (name field only)
   - `PostResource`: CRUD for posts with image uploads and house relationship
   - Resources located in `app/Filament/Resources/`

3. **Real-time Features**
   - **Event**: `PostCreated` broadcasts when new posts are created
   - **Channel**: Broadcasts on 'posts' channel
   - **Component**: `RealtimePost` Livewire component displays latest post
   - **WebSocket**: Laravel Reverb handles WebSocket connections

4. **Broadcasting Flow**
   1. Post created via Filament admin (`/app/posts/create`)
   2. `CreatePost::afterCreate()` dispatches `PostCreated` event
   3. Event broadcasts through Reverb WebSocket server
   4. Dashboard page listens via Laravel Echo
   5. `RealtimePost` component updates automatically

5. **Storage**
   - Database: SQLite (`database/database.sqlite`)
   - File uploads: `storage/app/public/posts/`
   - Public disk configured for post images

6. **Frontend Stack**
   - Vite for asset bundling
   - Tailwind CSS v4
   - Laravel Echo for WebSocket client
   - Livewire for reactive components

### Important Notes

- The `PostCreated` event includes a 'content' field that doesn't exist in the database schema
- Image URLs in events are processed to include full storage path
- Queue listener must be running for background jobs
- Vite dev server required for frontend hot reload
- All Filament routes are under `/app` prefix

### Testing Approach
- PHPUnit for unit and feature tests
- In-memory SQLite for test database
- Tests located in `tests/Unit/` and `tests/Feature/`