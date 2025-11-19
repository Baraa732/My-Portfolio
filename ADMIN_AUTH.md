# Admin Authentication System

## Overview
Complete admin authentication system for the portfolio website with secure access control.

## Features
- ✅ Admin login form with validation
- ✅ Admin middleware protection
- ✅ Admin user management
- ✅ Secure logout functionality
- ✅ Dashboard access control

## Admin Credentials
- **Email**: baraaalrifaee732@gmail.com
- **Password**: admin123

## Routes
- `/admin/login` - Admin login page
- `/admin` - Admin dashboard (protected)
- `/logout` - Logout (POST)

## Security Features
1. **AdminMiddleware**: Protects all admin routes
2. **Admin Check**: Only users with `is_admin = true` can access
3. **Session Management**: Proper session handling and regeneration
4. **CSRF Protection**: All forms protected with CSRF tokens

## Files Created/Modified
1. `app/Http/Middleware/AdminMiddleware.php` - Admin access control
2. `database/migrations/2025_01_20_000000_add_is_admin_to_users_table.php` - Admin field
3. `database/seeders/AdminUserSeeder.php` - Admin user creation
4. `app/Models/User.php` - Added is_admin field
5. `routes/web.php` - Updated middleware
6. `resources/views/admin/dashboard.blade.php` - Added logout button

## Testing
Visit `/test-admin` to verify admin user setup.

## Usage
1. Navigate to `/admin/login`
2. Enter admin credentials
3. Access protected dashboard at `/admin`
4. Use logout button to securely exit