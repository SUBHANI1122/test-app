This service lets me manage translations for multiple locales with tagging for context (like mobile, desktop, web). I can create, update, search, and export translations through clean API endpoints. The JSON export is optimized to handle large datasets (100k+ records) and always returns the latest translations without extra caching layers.

I followed PSR-12 coding standards, applied SOLID principles, and wrote optimized SQL queries for speed. All endpoints are secured with token-based authentication, and response times stay well under 200ms for CRUD operations and under 500ms for large JSON exports.

For testing scalability, I’ve included a Laravel command that seeds 100k+ translation records using batch inserts, so I can stress-test the performance anytime.

Set up Laravel 11 project – Installed a fresh Laravel 11 app and configured .env for database and API token auth.

Designed the database schema – Created migrations for translations, tags, tag_translation pivot table, and api_tokens with proper indexing for fast lookups.


Built Eloquent models – Added Translation, Tag, and ApiToken models with relationships and fillable properties.

Implemented repository pattern – Wrote a TranslationRepository to keep queries optimized and maintain separation of concerns.

Added service layer – Created a TranslationService for all business logic so controllers stay clean and focused.

Developed API controllers – Added endpoints for create, update, view, search, and JSON export (streaming large datasets).

Secured endpoints – Built token-based authentication middleware that checks API tokens from the api_tokens table.

Performance tuning – Used cursor-based pagination, eager loading, and batch inserts for scalability.

Seeder/Command for stress testing – Wrote an Artisan command to insert 100k+ translations in batches for performance benchmarking.

Tested and validated – Verified response times were <200ms for CRUD and <500ms for large export calls.

Clone the repository
run composer install
run php artisan key:generate
php artisan migrate
php artisan translations:seed --count=100000
php artisan tinker
\App\Models\ApiToken::create(['name' => 'TestToken', 'token' => hash('sha256', 'your-token-here')]);
php artisan serve

