# Laravel Dusk Tests for Filament Skeleton

This directory contains browser tests for the Filament admin panel using Laravel Dusk.

## Setup

1. Make sure you have Chrome installed on your system
2. Install Laravel Dusk dependencies:
   ```
   php artisan dusk:install
   ```
3. Make sure the ChromeDriver version matches your Chrome version:
   ```
   php artisan dusk:chrome-driver --detect
   ```

## Running Tests

To run all Dusk tests:
```
php artisan dusk
```

To run a specific test:
```
php artisan dusk --filter=FilamentLoginTest
```

## Test Structure

- **Components/**: Reusable Dusk components for interacting with common UI elements
- **Pages/**: Page objects representing different pages in the admin panel
- **FilamentLoginTest.php**: Tests for login functionality
- **DashboardTest.php**: Tests for dashboard navigation and widgets
- **UserManagementTest.php**: Tests for user creation and management

## Helpful Tips

1. If tests are failing due to timing issues, adjust the wait times in the test methods
2. Use the `DuskTestCase::browse()` method for consistent wait behavior
3. When the UI changes, update the page objects and components rather than individual tests
4. Run tests with `--stop-on-failure` flag to debug issues one at a time

## Modifying Tests

The test suite is designed to follow the Page Object pattern for maintainability:

1. Add new selectors to page objects in the `elements()` method
2. Add new interaction methods to page objects
3. Keep tests focused on business logic rather than UI implementation details

## Environment Configuration

Tests use the `.env.dusk.local` file for configuration. Modify this file to match your testing environment.