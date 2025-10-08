-- Employee Concern and Request Management System Database Schema

-- Employees table
CREATE TABLE IF NOT EXISTS employees (
    id SERIAL PRIMARY KEY,
    employee_id VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ticket categories table
CREATE TABLE IF NOT EXISTS ticket_categories (
    id SERIAL PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tickets table
CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    ticket_number VARCHAR(50) UNIQUE NOT NULL,
    employee_id INTEGER REFERENCES employees(id) ON DELETE CASCADE,
    category_id INTEGER REFERENCES ticket_categories(id),
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    priority VARCHAR(20) DEFAULT 'medium',
    status VARCHAR(50) DEFAULT 'pending',
    assigned_to INTEGER REFERENCES employees(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Status history table for tracking progress
CREATE TABLE IF NOT EXISTS status_history (
    id SERIAL PRIMARY KEY,
    ticket_id INTEGER REFERENCES tickets(id) ON DELETE CASCADE,
    old_status VARCHAR(50),
    new_status VARCHAR(50) NOT NULL,
    updated_by INTEGER REFERENCES employees(id),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ticket responses/comments table
CREATE TABLE IF NOT EXISTS ticket_responses (
    id SERIAL PRIMARY KEY,
    ticket_id INTEGER REFERENCES tickets(id) ON DELETE CASCADE,
    employee_id INTEGER REFERENCES employees(id),
    response_text TEXT NOT NULL,
    is_internal BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chatbot responses table for pre-configured messages
CREATE TABLE IF NOT EXISTS chatbot_responses (
    id SERIAL PRIMARY KEY,
    keyword VARCHAR(100) NOT NULL,
    question TEXT NOT NULL,
    response TEXT NOT NULL,
    category VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default ticket categories
INSERT INTO ticket_categories (category_name, description) VALUES
('Leave Request', 'Vacation, sick leave, personal leave requests'),
('Payroll Inquiry', 'Salary, benefits, deductions related questions'),
('IT Support', 'Computer, software, hardware, network issues'),
('Training Request', 'Professional development and training requests'),
('Workplace Concern', 'Workplace safety, harassment, conflicts'),
('Benefits Inquiry', 'Health insurance, retirement, other benefits'),
('Equipment Request', 'Office supplies, equipment needs'),
('Policy Question', 'Company policies and procedures'),
('Other', 'General concerns and requests')
ON CONFLICT DO NOTHING;

-- Insert default HR admin account (password: admin123)
INSERT INTO employees (employee_id, full_name, email, department, password, role) VALUES
('HR001', 'HR Administrator', 'hr@company.com', 'Human Resources', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr_admin')
ON CONFLICT (employee_id) DO NOTHING;

-- Insert sample chatbot responses
INSERT INTO chatbot_responses (keyword, question, response, category, is_active) VALUES
('leave', 'How do I request leave?', 'To request leave, create a new ticket with the category "Leave Request" and specify the dates and type of leave you need. Your manager will be notified automatically.', 'Leave', TRUE),
('payroll', 'When is payday?', 'Payroll is processed on the last working day of each month. If you have specific payroll questions, please create a ticket under "Payroll Inquiry".', 'Payroll', TRUE),
('password', 'I forgot my password', 'Please contact IT Support by creating a ticket under "IT Support" category. Include your employee ID and they will assist you with password reset.', 'IT Support', TRUE),
('benefits', 'What benefits do I have?', 'Our company offers health insurance, dental coverage, retirement plans, and paid time off. For detailed information about your specific benefits, create a ticket under "Benefits Inquiry".', 'Benefits', TRUE),
('training', 'How do I request training?', 'To request training, create a ticket under "Training Request" category. Include the training name, provider, dates, and cost estimate.', 'Training', TRUE),
('ticket', 'How do I create a ticket?', 'Click on "Create New Ticket" button, select the appropriate category, fill in the details of your concern or request, and submit. You will receive a ticket number for tracking.', 'General', TRUE),
('status', 'How do I check my ticket status?', 'Go to "My Tickets" dashboard to view all your tickets and their current status. You can filter by status or search by ticket number.', 'General', TRUE),
('contact', 'How do I contact HR?', 'You can create a ticket for any HR-related concerns, or email us at hr@company.com. For urgent matters, call extension 1234.', 'Contact', TRUE),
('working hours', 'What are the working hours?', 'Standard working hours are Monday-Friday, 9:00 AM to 5:00 PM. For specific schedule questions, please create a ticket under "Policy Question".', 'Policy', TRUE),
('emergency', 'What do I do in an emergency?', 'In case of emergency, call 911 first. Then notify your supervisor and HR. For workplace safety concerns, create a ticket under "Workplace Concern".', 'Emergency', TRUE)
ON CONFLICT DO NOTHING;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_tickets_employee ON tickets(employee_id);
CREATE INDEX IF NOT EXISTS idx_tickets_status ON tickets(status);
CREATE INDEX IF NOT EXISTS idx_tickets_category ON tickets(category_id);
CREATE INDEX IF NOT EXISTS idx_status_history_ticket ON status_history(ticket_id);
CREATE INDEX IF NOT EXISTS idx_ticket_responses_ticket ON ticket_responses(ticket_id);
CREATE INDEX IF NOT EXISTS idx_chatbot_keyword ON chatbot_responses(keyword);
