# CoreTech-Innovations-Dynamic-Website-Backend 

🚀 A secure and dynamic backend system for CoreTech Innovations.  
All website content (Home, About, Services, Portfolio, Contact) is managed from a MySQL database instead of hardcoding.  
Includes an admin panel for content management, service/portfolio updates, and message storage.  

---

## 📌 Features
- 🔐 **Admin Login** – Secure login with username + password  
- 🏠 **Dynamic Home Page** – Hero text, tagline, slider images from DB  
- 👥 **About Page** – Manage mission, vision, team members  
- 🛠️ **Services Page** – Add, edit, delete services  
- 📂 **Portfolio Page** – Upload projects with image, title, description  
- ✉️ **Contact Page** – Stores messages in DB  
- 📊 **Database** – MySQL schema with tables: `users`, `services`, `team`, `portfolio`, `messages`

---

## 🛠️ Technology Stack
- PHP 8+  
- MySQL  
- HTML5 / CSS3 / Bootstrap  
- XAMPP (Localhost Deployment)

---

## 📂 Installation
1. Clone the repo:  
   ```bash
   git clone https://github.com/yourusername/coretech-backend.git
  
2. Import the database:

Open phpMyAdmin → Create database coretech_db

Import database.sql file

Configure DB connection:

Open config.php

Update with your DB credentials

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "coretech_db";
Start XAMPP → Apache + MySQL

Open in browser:
http://localhost/coretech-backend/admin
