#!/bin/bash

# Navigate to the script's directory (ensures it runs correctly even if called from elsewhere)
cd "$(dirname "$0")"

echo "🚀 Starting up Kids Clinic Development Environment..."

# 1. Start Laravel Sail (Docker containers) in the background
echo "📦 Starting Docker containers..."
./vendor/bin/sail up -d

# 2. Ensure composer dependencies are installed
echo "📦 Checking PHP dependencies..."
./vendor/bin/sail composer install

# 3. Ensure NPM dependencies are installed
echo "📦 Checking Node dependencies..."
./vendor/bin/sail npm install

# 4. Run any pending database migrations
echo "🗄️ Running database migrations..."
./vendor/bin/sail artisan migrate

# 5. Clear caches just in case
echo "🧹 Clearing caches..."
./vendor/bin/sail artisan optimize:clear

echo "✅ Environment is ready!"
echo "🌐 You can access the website at: http://localhost"
echo "🎨 Starting Vite frontend server... (Press Ctrl+C to stop)"

# 6. Start the frontend dev server (this will block the terminal so you can see the logs)
./vendor/bin/sail npm run dev
