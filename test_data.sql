DELETE FROM products;
DELETE FROM categories;

INSERT INTO categories (id, name) VALUES (1, 'Monitors');

INSERT INTO products (id, name, brand, price, original_price, description, category_id, images, sizes, colors) VALUES
(1, '27-inch 4K Monitor', 'BrandX', 499.99, 599.99, 'A stunning 27-inch 4K monitor.', 1, '[]', '["S", "M"]', '["Red", "Blue"]'),
(2, 'Another Monitor', 'BrandY', 299.99, 399.99, 'Another great monitor.', 1, '[]', '["L"]', '["Black"]');
