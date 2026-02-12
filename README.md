# Laravel Social Friend System

A clean and modern Laravel application for managing user connections. This project allows users to search for people, send friend requests, manage incoming requests, and view their current friend list with a fully responsive UI built with Tailwind CSS and Alpine.js.

## 🚀 Features

* **User Authentication:** Secure Login and Registration system.
* **Friend List:** View all connected friends with the "Since" date and an option to **Unfriend**.
* **Request Management:**
    * **Incoming:** Accept or Reject friend requests.
    * **Outgoing:** View requests you have sent and **Cancel** them if needed.
* **Find Friends:**
    * Search for users by name.
    * **Smart Actions:** The UI automatically detects the relationship status:
        * *Add Friend* (if no connection exists).
        * *Request Sent* (if you already sent one).
        * *Accept/Reject* (if they sent you a request).
        * *Already Friends* (if you are connected).
* **Modern UI:** Built with Tailwind CSS and Alpine.js for flash notifications and mobile responsiveness.

## 🛠️ Tech Stack

* **Framework:** Laravel (PHP)
* **Frontend:** Blade Templates
* **Styling:** Tailwind CSS
* **Interactivity:** Alpine.js
* **Database:** MySQL / SQLite

## ⚙️ Installation & Setup

Follow these steps to set up the project locally.

### 1. Clone the repository
```bash
git clone https://github.com/yash22nayak/socialapp
cd socialapp

```

### 2. Install Dependencies

Install PHP and Node.js dependencies.

```bash
composer install
npm install

```

### 3. Environment Setup

Copy the example environment file and generate the application key.

```bash
cp .env.example .env
php artisan key:generate

```

### 4. Database Setup

Configure your database credentials in the `.env` file (DB_DATABASE, DB_USERNAME, etc.). Then run the migrations.

```bash
php artisan migrate

```

### 5. Build Assets

Compile the Tailwind CSS assets.

```bash
npm run dev

```

---

## 📖 Usage Guide

Follow this specific flow to test the application logic:

### Step 1: Registration

Navigate to the **Register** page and create a new account with your details.

### Step 2: Seed Data

To populate the application with other users (so you have people to search for and friend requests), run the seeder command:

```bash
php artisan db:seed

```

### Step 3: Dashboard (Friends List)

After logging in, you will be redirected to the default **Home** page.

* This page displays your current list of friends.
* You can click **Unfriend** to remove a user from this list.

### Step 4: Find Friends

Click on the **"Find People"** link in the header.

* Use the search bar to find users.
* **Send Request:** Click "Add Friend" to send a request.
* **Context Aware:** If a user has already sent *you* a request, you will see options to **Accept** or **Reject** directly on their card.

### Step 5: Request List

Click on the **"Request List"** link in the header.

* **Received:** See who wants to be your friend. You can **Confirm** or **Delete** the request.
* **Sent:** View pending requests you sent to others. You can **Cancel** the request here.

---

## 📂 Project Structure

* `resources/views/home.blade.php` - Displays the Friends List.
* `resources/views/friend-requests/index.blade.php` - Manages Sent and Received requests.
* `resources/views/friend-request/search-users.blade.php` - Search functionality and Add Friend logic.
* `resources/views/layouts/app.blade.php` - Main layout containing the Navbar and Flash Messages.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
