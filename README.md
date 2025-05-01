# InvoiceStream
InvoiceStream provides a simple way to track work arrangements and generate invoices for clients. 

## Features
- Manages unlimited client arrangements.
- Records work entries with date, duration and hourly rate specifics.
- Calculates earnings metrics, including uninvoiced work and total hours.
- Generates downloadable PDF invoices for selected work entries.

## Installation
To run InvoiceStream locally using Laravel Sail, follow these steps:
### Prerequisites
- **Docker:** Ensure Docker is installed and running on your machine.
### Steps
1. **Clone the Repository**
2. **Set up Environment Variables**
3. **Install Composer Dependencies:** ```composer install```
4. **Start Docker Containers:** ```./vendor/bin/sail up```
5. **Generate Application Key:** ```./vendor/bin/sail artisan key:generate```
6. **Run Database Migration and Seeder:** ```./vendor/bin/sail artisan migrate:fresh --seed```
7. **Create Storage Symlink:** ```./vendor/bin/sail artisan storage:link```
8. **Install NPM Dependencies:** ```./vendor/bin/sail npm install```
9. **Build Frontend Assets:** ```./vendor/bin/sail npm run build```
10. **Access the Application:** InvoiceStream should now be accessible at 127.0.0.1

## Maintainers
- **Sam Watts** - [@sjwatts119](https://github.com/sjwatts119)
