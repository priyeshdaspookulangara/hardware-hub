-- Create a new table to store product images
CREATE TABLE product_images (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    sort_order INT(11) NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Remove the old JSON-based 'images' column from the products table
ALTER TABLE products DROP COLUMN images;
