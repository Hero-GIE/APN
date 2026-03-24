Africa Prosperity Network (APN) - Donation & Membership System
Overview
A Laravel-based web application that manages donations and membership subscriptions for Africa Prosperity Network, featuring Paystack payment integration.

Key Features
💰 Payment Processing
Paystack integration for secure payments

Handles one-time donations & recurring memberships

Automatic transaction verification

👥 User Management
Dual authentication (donors & members)

Automatic account creation on first payment

Profile management with communication preferences

🎫 Membership System
Monthly/annual membership plans

Automatic expiration tracking

Member benefits portal with exclusive content

Renewal processing

📧 Automated Communications
Welcome emails with login credentials

Payment confirmations

Membership renewal notices

Support ticket notifications

🆘 Support System
Integrated ticket system

File attachments

Priority levels (low/medium/high)

Status tracking

📊 Dashboard Features
Payment history & receipts

Membership status overview

Days remaining counter

Transaction records

🎨 Design
Responsive Tailwind CSS

Professional email templates

Mobile-friendly interfaces

Tech Stack
Backend: Laravel PHP

Database: MySQL

Frontend: Blade, Tailwind CSS

Payments: Paystack API

Email: SMTP with custom templates

Core Models
Donor

Member

Donation

MemberPayment

SupportTicket




Run a specific seeder
php artisan db:seed --class=NewsSeeder


✅ Run all seeders (from DatabaseSeeder)
php artisan db:seed


✅ Run migrations + seed together
php artisan migrate --seed



# This is franklinadams773@gmail password in the APN database
> bcrypt('password123');
= "$2y$12$6ES1PaVfEChUWquzmB..YON3GzW3W69dGmTVYziLjV3UJpDOLQS3u"



