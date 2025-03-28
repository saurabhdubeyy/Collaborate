# Project Structure

## Main Folders
- `css/` - Contains CSS style files for user interfaces
- `image/` - Contains image assets used in the main pages
- `images/` - Contains default avatar and other system images
- `new/` - Contains host community module
- `uploaded_img/` - Storage for user-uploaded profile pictures

## Main Files
- `index.php` - Home page of the website
- `login.php` - User login page
- `register.php` - User registration page
- `home.php` - User profile page after login
- `get1.php` - Communities listing page
- `update_profile.php` - Profile updating page
- `config.php` - Database connection configuration
- `connect.php` - Host community form handler
- `style1.css` - Main CSS file for the site layout

## Database Tables
- `user_form` - Stores user account information
- `host` - Stores community information

## Key Features
1. **User Authentication System**
   - Registration with profile picture
   - Secure login with password hashing
   - Profile management

2. **Community Management**
   - Create communities (indoor or outdoor)
   - Search and filter communities
   - Contact community hosts

3. **User Interface**
   - Responsive design for different device sizes
   - Modern card-based layout for communities
   - User-friendly forms with validation

## Technical Details
- Uses PHP for server-side processing
- MySQL database for data storage
- Uses prepared statements for database security
- Password hashing for secure user authentication
- Session management for user login state
- Client-side validation with HTML5 attributes

## Security Implementations
- Password hashing with PHP's `password_hash()`
- Prepared statements to prevent SQL injection
- Input sanitization
- Session security measures
- Secure file upload handling
- XSS prevention with `htmlspecialchars()`

This structure provides a solid foundation for the Collaborate platform while maintaining good security practices and code organization. 