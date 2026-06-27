# Kids Clinic Server Setup Guide for Windows (XAMPP)

This guide will walk you through setting up and running the Kids Clinic server natively on a Windows machine from scratch. We will use **XAMPP** (which includes PHP and MySQL), **Composer** (to manage PHP dependencies), and **Node.js** (to manage frontend assets).

## Step 1: Download and Install Prerequisites

You will need to install two standard development tools:

1. **XAMPP** (Provides PHP and a MySQL database)
   - Download from: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
   - Run the installer. You can leave all default options checked.
   - *Note: XAMPP is usually installed at `C:\xampp`.*

2. **Composer** (PHP Package Manager)
   - Download the Windows Installer from: [https://getcomposer.org/download/](https://getcomposer.org/download/) (Click on `Composer-Setup.exe`)
   - Run the installer. It will automatically detect your PHP installation inside the XAMPP folder (e.g., `C:\xampp\php\php.exe`).

> **Important:** After installing these two tools, **restart your computer** to ensure all command-line paths are properly updated.

---

## Step 2: Start the Database (MySQL)

We need to start the MySQL server to host our database.

1. Open the **XAMPP Control Panel** (you can search for it in the Windows Start menu).
2. You will see a list of modules. Click the **"Start"** button next to **MySQL**.
   *(It will turn green when it successfully starts).*
3. You can also click **"Start"** next to **Apache** if you'd like to use `phpMyAdmin` to view the database visually.

---

## Step 3: Create the Database

Now we will create a blank database for the application to use.

1. Open your web browser and go to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   *(Make sure Apache and MySQL are running in XAMPP).*
2. Click on **"Databases"** in the top menu.
3. Under "Create database", enter the name: `laravel`
4. Click the **"Create"** button. 

---

## Step 4: Configure the Project

Now let's prepare the actual code.

1. Extract or place the `kids-clinic` project folder anywhere on your computer (for example, on your Desktop or in your Documents).
2. Open the project folder.
3. Find the file named `.env.example`.
4. Copy and paste the file in the same folder, and rename the copy to just `.env`.
   *(By default, this file is already configured to connect to your XAMPP MySQL setup: username `root` and no password).*

---

## Step 5: Install Project Dependencies

We need to tell Composer to download all the backend code libraries the project relies on.

1. Open your Windows **Start menu**, search for **Command Prompt** (or PowerShell), and open it.
2. Navigate to your project folder. For example, if it's on your desktop:
   ```cmd
   cd C:\Users\YourName\Desktop\kids-clinic
   ```
3. Install the PHP dependencies by running:
   ```cmd
   composer install
   ```

---

## Step 6: Finalize Database and Settings

We just need to initialize the application and set up our database tables.

1. In the same Command Prompt window, generate a security key:
   ```cmd
   php artisan key:generate
   ```
2. Build the database tables (this connects to the `laravel` database you created earlier):
   ```cmd
   php artisan migrate
   ```

---

## Step 7: Run the Application!

To run the application locally, you just need to start the backend server.

1. In your Command Prompt (make sure you are inside `C:\Users\YourName\Desktop\kids-clinic`), run:
   ```cmd
   php artisan serve
   ```
   *(This window needs to stay open while you use the site.)*

## 🎉 View the Website!

Your server is now fully running. Open your web browser and visit:
**[http://127.0.0.1:8000](http://127.0.0.1:8000)**

You should see the "Kids Clinic" login page!

---

### How to shut it down
When you are done:
1. Go to your Command Prompt window (running `php artisan serve`) and press `Ctrl + C` to stop it.
2. Open the **XAMPP Control Panel** and click **"Stop"** next to MySQL and Apache.
