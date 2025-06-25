# One2One4 Blood Donation Platform

A comprehensive web application that connects blood donors with recipients, helping to save lives through efficient blood donation management.

## Features

- **User Registration & Authentication**
  - Secure login and registration system
  - Profile management with personal and medical information
  - Blood donation history tracking

- **Blood Donor Management**
  - Searchable donor directory with filtering by blood type, location, etc.
  - Donor availability status tracking
  - Geographic location-based donor search

- **Blood Request System**
  - Create and manage blood donation requests
  - Track request status (pending, approved, completed)
  - Assign donors to specific requests

- **Location-based Services**
  - Hierarchical location structure (Division > District > Upazila)
  - Location-based donor search and filtering
  - Hospital location management

- **Admin Dashboard**
  - User management
  - Content management
  - Location management
  - Request and donation approval

- **Mobile-Friendly Interface**
  - Responsive design works on all devices
  - Mobile-specific navigation and layout

## Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Spatie Laravel Permission

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/one2one4.git
cd one2one4
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file and configure your database:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run database migrations and seeders:
```bash
php artisan migrate --seed
```

6. Start the development server:
```bash
php artisan serve
```

7. Access the application at http://localhost:8000

## Screenshots

- Dashboard
- Donor Search
- Blood Request Management
- User Profile
- Admin Panel

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

For any inquiries, please contact us at [your-email@example.com]
