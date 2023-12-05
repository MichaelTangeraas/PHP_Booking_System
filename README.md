# IS-115 | PHP based Booking System

### Description:

A PHP based "Booking System" draft created as part of the semester project for the course IS-115, Autumn 2023.

### Authors:

[Hans Christian Morka(blathee)](https://github.com/Blathee)

[Ivar Michael Tangeraas(imttv)](https://github.com/imttv)

### How to run the website using XAMPP:

1. Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. Clone or download the project files from this repository.
3. Copy the project folder to the `htdocs` folder in your XAMPP installation directory **(Do not include the DB_Backup folder)**.
4. Start the Apache and MySQL modules in XAMPP Control Panel.
5. Navigate to `http://localhost/phpmyadmin/` in a web browser and create a new database named `is115_bookingsystem`.
6. Import the `is115_bookingsystem.sql` file from the DB_Backup folder into the newly created database.
7. Open a web browser and go to `http://localhost/is115_project/public_html/` to access the website.
8. **Sign up and start booking!**

### Testing the website:

When following all the steps above, you will automatically have access to a couple of test accounts.
These test accounts have already made some bookings, and will therefore show up in the booking list.

**Test accounts for LA:**

- Ola Nordmann - email: la@test.no, password: Tester123\*

**Test accounts for Students:**

- Kari Skog - email: student@test.no, password: Tester123\*
- Michael Tangeraas - email: mt@test.no, password: Tester123\*
- Hans Christian Morka - email: hc@test.no, password: Tester123\*

### Support and issues:

If you encounter any issues while testing the website, please add an issue to this repository.
