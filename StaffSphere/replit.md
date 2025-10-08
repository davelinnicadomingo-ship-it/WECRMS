# Employee Concern and Request Management System

## Overview
A comprehensive PHP-based web application for managing employee concerns and requests with integrated HR management tools and an intelligent chatbot assistant.

## Tech Stack
- **Backend**: PHP 8.2
- **Database**: PostgreSQL (Neon-backed Replit database)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Server**: PHP Built-in Development Server

## Key Features
1. **Ticket Management System**
   - Create, view, and track support tickets
   - Categorized requests (Leave, Payroll, IT Support, Training, etc.)
   - Priority levels (Low, Medium, High)
   - Real-time status updates

2. **Status Tracking & Progress**
   - Four status levels: Pending, In Progress, Resolved, Closed
   - Complete history timeline for each ticket
   - Status change notifications
   - Progress notes and updates

3. **HR Management Dashboard**
   - View all employee tickets
   - Assign tickets to HR staff
   - Update ticket status
   - Filter and search functionality
   - Ticket statistics and analytics

4. **Chatbot Assistant**
   - Pre-configured FAQ responses
   - Keyword-based intelligent matching
   - Quick question suggestions
   - Real-time chat interface

5. **Employee Portal**
   - Personal ticket dashboard
   - Create new tickets
   - Track ticket progress
   - View responses from HR

## Project Structure
```
/
├── api/                    # API endpoints for AJAX operations
│   ├── chatbot.php        # Chatbot response handler
│   ├── update_status.php  # Status update endpoint
│   └── assign_ticket.php  # Ticket assignment endpoint
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   └── js/
│       ├── main.js        # Core JavaScript functionality
│       └── hr.js          # HR-specific functions
├── config/
│   ├── database.php       # Database connection class
│   └── session.php        # Session management functions
├── database/
│   └── schema.sql         # Database schema definition
├── includes/
│   ├── header.php         # Site header component
│   └── chatbot.php        # Chatbot UI component
├── index.php              # Employee dashboard
├── login.php              # Login page
├── register.php           # Employee registration
├── logout.php             # Logout handler
├── create_ticket.php      # Ticket creation form
├── ticket_details.php     # Ticket detail view
└── hr_dashboard.php       # HR management dashboard
```

## Database Schema
- **employees**: User accounts and profiles
- **ticket_categories**: Predefined ticket categories
- **tickets**: Main ticket records
- **status_history**: Ticket status change log
- **ticket_responses**: Comments and responses
- **chatbot_responses**: Pre-configured chatbot answers

## Default Credentials
- **HR Admin Login**:
  - Employee ID: HR001
  - Password: admin123

## Running the Application
The application runs on port 5000 using PHP's built-in development server.
Access at: http://localhost:5000

## Recent Changes
- October 4, 2025: Initial system setup with complete ticket management, HR dashboard, and chatbot functionality
