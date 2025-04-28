🛒 GroupOn Produce
Connecting Farmers and Customers Directly for Fresh, Affordable Produce

📖 Project Overview
GroupOn Produce is a web-based platform that connects farmers directly with customers, allowing the sale and purchase of fresh agricultural products.
Built using a PHP MVC framework (CodeIgniter or similar), it ensures organized, efficient, and scalable development.

This platform supports easy produce listing, secure ordering, profile management, and direct communication between users.

🚀 Features
👨‍🌾 Farmer Registration & Login
Farmers can register, log in, and manage their profiles securely.

🛍️ Product Listings & Quantity Management
Farmers can add new produce, update product details, edit available quantity, and mark items out of stock.

🛒 Customer Shopping Cart
Customers can add products to their shopping cart and place orders seamlessly.

💳 Order Placement & Status Update
Customers can place orders and track their status (Pending ➔ Shipped ➔ Delivered).
Farmers have the ability to update order status directly from their panel.

📝 Profile Management
Both farmers and customers can view and update their personal details and account settings.

📞 Contact Us Form
Customers can reach out via the Contact Us form for queries or support.

🔐 Forgot Password Feature
Allows users to recover their accounts securely.

🛑 Out of Stock Indicator
Customers can see which products are unavailable.

🔒 Secure Login Sessions
Proper session handling and security practices are followed.

🛠️ Tech Stack
Frontend: HTML5, CSS3, Bootstrap, JavaScript

Backend: PHP (Framework - CodeIgniter or similar)

Database: MySQL

Version Control: Git, GitHub

Package Management: Composer

📂 Project Structure
bash
Copy
Edit
GroupOn-Produce/
├── application/     # MVC structure (Controllers, Models, Views)
├── assets/          # Static files (CSS, JS, Images)
├── system/          # Framework core files
├── vendor/          # Composer dependencies
├── .editorconfig    # Editor configurations
├── .gitignore       # Git ignore file
├── .htaccess        # Apache server configurations
├── composer.json    # Composer package file
├── composer.lock    # Composer lock file
├── index.php        # Entry point of the application
├── license.txt      # License information
└── readme.rst       # Project documentation (older version)
⚙️ Setup Instructions
Clone the Repository

bash
Copy
Edit
git clone https://github.com/KoteshRekha/GroupOn-Produce.git
Install Dependencies

Navigate to the project directory and install dependencies using Composer:

bash
Copy
Edit
composer install
Set Up the Database

Create a MySQL database (e.g., groupon_produce).

Import the database tables using the provided .sql file (if available).

Update the database configuration:

Go to application/config/database.php

Set your database hostname, username, password, and database name.

Run the Application

Deploy the project to your local server (XAMPP / WAMP / MAMP).

Access the app via http://localhost/GroupOn-Produce/.

✨ Future Enhancements (Optional)
Integrate payment gateway for direct transactions.

Add customer reviews and ratings for farmers/products.

Enable real-time chat with notifications.

Implement admin dashboard for managing users and orders.

Develop a mobile-first responsive design.

👩‍💻 Contributors
Kotesh Rekha

Siva Pavan Kumar Chava

Sridhar Cheppala

Aarjap Piya

Sai Vivek Gankidi

📜 License
This project is licensed under the MIT License.








###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/userguide3/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Contributing Guide <https://github.com/bcit-ci/CodeIgniter/blob/develop/contributing.md>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
