# Collaborate

Collaborate is a web platform that enables users to create and join communities for various activities, whether indoor or outdoor. This application helps users connect with like-minded individuals, share interests, and organize group activities.

## Local Development Setup

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
   - Clone this repository: `git clone https://github.com/saurabhdubeyy/Collaborate.git`
   - Rename the folder to `dashboard` if you prefer

3. **Configure the database**:
   - Start XAMPP Control Panel and start Apache and MySQL services
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Click on "Import" from the top menu
   - Click "Choose File" and select `collaborate_db.sql` from the project
   - Click "Go" to import the database

4. **Access the website**:
   - Visit `http://localhost/dashboard` in your browser to access the site

### Account Login
- You can register a new account or use these demo accounts:
  - Email: `demo@example.com`
  - Password: `password123`

## Deployment to Render

### Prerequisites
- A Render account (free tier is available)
- A GitHub account

### Deployment Steps

1. **Fork or clone this repository to your GitHub account**
   - Visit https://github.com/saurabhdubeyy/Collaborate
   - Click "Fork" to create your own copy

2. **Set up Render Web Service**
   - Sign in to your Render account
   - Click "New" and select "Blueprint"
   - Connect your GitHub account and select your forked repository
   - Render will automatically detect the `render.yaml` file and configure the service accordingly

3. **Environment Variables**
   - Render will automatically set up the database connection variables based on the render.yaml configuration
   - You can add additional environment variables in the Render dashboard if needed

4. **Verify Deployment**
   - Once the deployment is complete, Render will provide a URL to access your application
   - Test the application by registering a new account or using the demo account

## Features
- User registration and authentication
- Profile management with image upload
- Create communities for indoor or outdoor activities
- Search and filter communities
- Join communities and contact organizers

## Project Structure
- `config.php`: Database configuration
- `index.php`: Main entry point
- `login.php` and `register.php`: Authentication pages
- `home.php`: User dashboard
- `get1.php`: Communities listing
- `host.php`: Community creation
- `update_profile.php`: Profile management

## Troubleshooting
- If you encounter database connection issues, check the database config in `config.php`
- For local development, make sure the XAMPP services (Apache and MySQL) are running
- For Render deployment, check the logs in the Render dashboard for any errors

## License
Open source under the MIT License.
