# Laravel Authentication & Notification System

A complete, production‑ready authentication backend built with **Laravel**, featuring:

- 🔐 Laravel Sanctum Authentication  
- 📧 Email Verification Flow  
- 🔑 Password Reset (Secure Token System)  
- 📬 Queue‑Based Email Sending (Redis / Database Queue)  
- 🔔 Real‑Time Web Notifications (Pusher / WebSockets)  
- 📱 Firebase Push Notifications (Android / iOS / Web)  
- 📝 Activity Logging System  
- ❗ Failed Jobs Dashboard  
- 🧩 Clean, modular, scalable architecture  

---

## 🚀 Features

### 🔐 Authentication
- Register / Login / Logout  
- Sanctum token‑based authentication  
- Auto‑invalidate tokens after password reset  

### 📧 Email System
- Email verification with secure token  
- Password reset with email link  
- HTML email templates  
- Queue‑based sending for performance  

### 🔔 Notifications
- Real‑time notifications using Pusher  
- Firebase Cloud Messaging (FCM) push notifications  
- Database notifications for dashboard  
- Triggered on:
  - Email verification  
  - Password reset  
  - Login events  

### 📝 Logging
- Logs all important actions (login, verify, reset, etc.)  
- API endpoint to view logs  

### ❗ Failed Jobs Dashboard
- View failed queue jobs  
- Retry jobs  
- Debug exceptions  

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 10 |
| Auth | Laravel Sanctum |
| Queue | Redis / Database Queue |
| Real‑Time | Pusher / Laravel WebSockets |
| Push Notifications | Firebase Cloud Messaging (FCM) |
| Database | MySQL / MariaDB |
| Mail | SMTP (Gmail recommended) |

---

🔥 Firebase Setup (Push Notifications)
- Go to Firebase Console
- Create a project
- Enable Cloud Messaging
- Go to:
Project Settings → Cloud Messaging → Cloud Messaging API (Legacy)
- Copy the Server Key
- Add it to .env:
FCM_SERVER_KEY=AAAAxxxxxxxxxxxxxxxxxxxxxxxxxxxx


- Save device tokens from the frontend using:
POST /api/save-device-token




🔔 Real‑Time Notifications (Pusher)
Add to .env:
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=xxxx
PUSHER_APP_KEY=xxxx
PUSHER_APP_SECRET=xxxx
PUSHER_APP_CLUSTER=mt1


Install Pusher:
composer require pusher/pusher-php-server








👤 Developer
Name: Fadi
Email: your-email@example.com
LinkedIn: https://www.linkedin.com/in/your-profile (linkedin.com in Bing)


## 📦 Installation

Clone the project:

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
Install dependencies:
composer install
npm install


Create environment file:
cp .env.example .env


Generate app key:
php artisan key:generate


Run migrations:
php artisan migrate



Start queue worker:
php artisan queue:work


Run the server:
php artisan serve

