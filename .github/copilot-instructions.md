<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# Copilot Instructions for Laundry Management System

This is a Laravel-based laundry management system with WhatsApp API integration.

## Project Structure
- **Backend**: Laravel 10 with Eloquent ORM
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (development) / MySQL (production)
- **API Integration**: RuangWA.id WhatsApp API

## Key Models
- `Pelanggan` (Customer): id_pelanggan, nama, nomor_telepon
- `Pesanan` (Order): id_pesanan, id_pelanggan, jenis_layanan, jumlah_pakaian, status, etc.
- `Admin`: id_admin, nama_admin, email, password

## Code Style Guidelines
- Use Indonesian naming for models and database fields (pelanggan, pesanan, etc.)
- Follow Laravel conventions for controllers, models, and migrations
- Use Tailwind CSS classes for styling
- Implement proper validation in controllers
- Use proper Eloquent relationships

## WhatsApp Integration
- Webhook endpoint: `/api/whatsapp/webhook`
- Message parsing for order creation
- Status update notifications
- Use the `WhatsAppService` class for all WhatsApp operations

## Important Features
- Order status tracking with WhatsApp notifications
- Dashboard with statistics
- CRUD operations for customers, orders, and admins
- Reporting with order duration calculations
