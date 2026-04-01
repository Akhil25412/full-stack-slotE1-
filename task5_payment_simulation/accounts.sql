USE student_db;

CREATE TABLE IF NOT EXISTS accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_name VARCHAR(100) NOT NULL,
    balance DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
    account_type ENUM('USER', 'MERCHANT') NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample accounts
-- User starts with $500, Merchant starts with $1000
INSERT IGNORE INTO accounts (id, account_name, balance, account_type) VALUES 
(1, 'User Wallet', 500.00, 'USER'),
(2, 'Merchant Store', 1000.00, 'MERCHANT');
