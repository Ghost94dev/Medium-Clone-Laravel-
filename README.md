📝 Medium Clone (Laravel)

A Medium-inspired blogging platform built with Laravel, focused on real-world features, clean UI, and progressive improvement.

This project is developed incrementally following a feature roadmap, similar to how production applications evolve.

🚀 Features
✅ Implemented

User authentication (Register / Login / Logout)

User profiles

Follow / Unfollow users

Create, edit, delete posts

Post categories

Post images

Like & unlike counts

Slug-based post URLs

Responsive layout (Tailwind CSS)

✅ Roadmap Features Implemented
2️⃣ Comments

Authenticated users can comment on posts

Users can delete only their own comments

Comment timestamps and authors displayed

Authorization checks enforced

6️⃣ Search

Search posts via navigation search bar

Search by keyword

Clean and centered UI (Medium-like)

Optimized query logic

🧭 Planned Features

The following features are planned and will be added later:

1️⃣ Rich Text Editor

3️⃣ Draft Posts

4️⃣ Authorization Policies

5️⃣ Slug Collision Handling

🛠️ Tech Stack

Backend: Laravel

Frontend: Blade, Tailwind CSS, Alpine.js

Database: sqlite MySQL 

Auth: Laravel Breeze

Deployment: Render

⚙️ Installation
git clone https://github.com/your-username/medium-clone.git
cd medium-clone

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

php artisan serve

🔍 Search Usage

Use the search bar in the navigation

Enter keywords to search posts

Results update based on the query

🔐 Authorization

Users can edit/delete their own posts

Users can delete their own comments

Unauthorized actions are blocked

Policies will be introduced later

🌍 Live Demo

(Will be added after deployment)

👨‍💻 Author

Madozin Evlin Dev
Software Developer | Laravel | AI Enthusiast

📌 Project Status

🚧 Active Development
Built to demonstrate real Laravel application structure and best practices.