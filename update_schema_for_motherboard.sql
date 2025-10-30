-- First, add the new columns to the category_properties table
ALTER TABLE `category_properties`
ADD COLUMN `display_name` VARCHAR(255) NOT NULL AFTER `property_name`,
ADD COLUMN `data_type` VARCHAR(50) NOT NULL AFTER `display_name`,
ADD COLUMN `notes` TEXT AFTER `data_type`;

-- Insert the 'Motherboard' category if it doesn't exist
INSERT INTO categories (name)
SELECT 'Motherboard'
WHERE NOT EXISTS (SELECT 1 FROM categories WHERE name = 'Motherboard');

-- Get the ID of the 'Motherboard' category
SET @motherboard_category_id = (SELECT id FROM categories WHERE name = 'Motherboard' LIMIT 1);

-- Insert the properties for the 'Motherboard' category
INSERT INTO category_properties (category_id, property_name, display_name, data_type, notes) VALUES
(@motherboard_category_id, 'Brand', 'Manufacturer Brand', 'Text', ''),
(@motherboard_category_id, 'Model_Name', 'Full Model Name', 'Text', 'Primary identifier.'),
(@motherboard_category_id, 'CPU_Socket_Type', 'CPU Socket Type', 'Text', 'e.g., LGA 1700, AM5.'),
(@motherboard_category_id, 'Chipset_Model', 'Chipset', 'Text', 'e.g., Z790, B650.'),
(@motherboard_category_id, 'Form_Factor', 'Form Factor', 'Dropdown/Text', 'e.g., ATX, Micro-ATX.'),
(@motherboard_category_id, 'Memory_Type', 'RAM Type', 'Dropdown/Text', 'e.g., DDR5, DDR4.'),
(@motherboard_category_id, 'Memory_Slots', 'RAM (DIMM) Slots', 'Integer', 'Number of slots.'),
(@motherboard_category_id, 'Max_Memory_Speed_MHz', 'Max RAM Speed (OC)', 'Integer', 'Value in MHz.'),
(@motherboard_category_id, 'Primary_PCIe_Version', 'Primary PCIe Version', 'Text', 'e.g., PCIe 5.0.'),
(@motherboard_category_id, 'M2_Slot_Count', 'M.2 Slots', 'Integer', 'Number of M.2 slots.'),
(@motherboard_category_id, 'SATA_Port_Count', 'SATA Ports', 'Integer', 'Number of SATA ports.'),
(@motherboard_category_id, 'LAN_Speed', 'Ethernet (LAN) Speed', 'Text', 'e.g., 2.5GbE.'),
(@motherboard_category_id, 'Wireless_Connectivity', 'Wi-Fi / Bluetooth', 'Text', 'e.g., Wi-Fi 6E, BT 5.3.'),
(@motherboard_category_id, 'Included_Accessories', 'Included Accessories', 'Multi-Select/Text', 'List of included items.'),
(@motherboard_category_id, 'Condition', 'Product Condition', 'Dropdown/Text', 'e.g., New, Used.'),
(@motherboard_category_id, 'Product_Description', 'Additional Details / Notes', 'Long Text', '');
