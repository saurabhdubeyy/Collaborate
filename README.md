# Collaborate

Collaborate is a web platform that enables users to create and join communities for various activities, whether indoor or outdoor. This application helps users connect with like-minded individuals, share interests, and organize group activities.

## Setup Instructions

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP (or any other similar server package)

### Installation
1. **Install XAMPP Server**:
   - Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)

2. **Set up the project**:
   - Navigate to your XAMPP installation folder (usually `C:\xampp` on Windows)
   - Open the `htdocs` folder
   - Rename the existing `dashboard` folder to `dashboard_old` (backup)
   - Create a new folder named `dashboard`
   - Copy all files from this project into the `dashboard` folder
   - Also copy `index.php` to the `htdocs` folder

3. **Configure the database**:
   - Start XAMPP Control Panel and start Apache and MySQL services
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Click on "Import" from the top menu
   - Click "Choose File" and select `collaborate_db.sql` from the project
   - Click "Go" to import the database

4. **Access the website**:
   - Visit `http://localhost` in your browser to access the site

### Account Login
- You can register a new account or use these demo accounts:
  - Email: `demo@example.com`
  - Password: `password123`

## Features
- User registration and authentication
- Profile management with image upload
- Create communities for indoor or outdoor activities
- Search and filter communities
- Join communities and contact organizers

## Troubleshooting
- If you encounter database connection issues, check the database config in `config.php`
- Make sure the XAMPP services (Apache and MySQL) are running
- Verify that permissions are correctly set for upload directories

## License
Open source under the MIT License.
