CREATE TABLE offers (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    offer_type ENUM('percentage', 'fixed_amount', 'bogo') NOT NULL,
    discount_value DECIMAL(10, 2) NOT NULL,
    scope ENUM('product', 'category', 'global') NOT NULL,
    applicable_id INT(11) UNSIGNED,
    coupon_code VARCHAR(255) UNIQUE,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT 1
);
