📌 Overview
This system allows you to:

Record load transactions with automatic tax calculation (50% of load amount)

Track debt owners (who owes the money)

View transaction history

Delete transactions

🛠️ Features
✔️ Real-time Calculation - Automatically calculates tax and total amount
✔️ Debt Tracking - Records who owes each transaction
✔️ Transaction History - View all past transactions in a table
✔️ CRUD Operations - Create and Delete functionality
✔️ Responsive Design - Works on desktop and mobile

🚀 Installation
Prerequisites

PHP 7.4+

MySQL 5.7+

Web server (Apache/Nginx)

Database Setup

sql
Copy
CREATE TABLE load_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    debt_owner VARCHAR(255) NOT NULL,
    load_amount DECIMAL(10,2) NOT NULL,
    tax DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    date_created DATETIME NOT NULL
);
Configuration
Create config.php with your database credentials:

php
Copy
<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
🖥️ Usage
Access the application in your browser

Fill out the form:

Enter debt owner's name

Enter load amount

Tax and total calculate automatically

View all transactions in the history table

Delete transactions as needed

📂 Project Structure
Copy
load-transactions/
├── index.php         # Main application file
├── config.php        # Database configuration
🌐 Live Demo
View Demo: http://localhost/Debt_Proj/load_form.php

🤝 Contributing
Fork the project

Create your feature branch (git checkout -b feature/AmazingFeature)

Commit your changes (git commit -m 'Add some AmazingFeature')

Push to the branch (git push origin feature/AmazingFeature)

Open a Pull Request

📜 License
MIT License
