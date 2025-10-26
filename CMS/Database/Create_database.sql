SET @old_sql_mode = @@SESSION.sql_mode;
SET @@SESSION.sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- Prof_right_names
CREATE TABLE Prof_right_names (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL,
    description VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_right_names (id, name, description) VALUES
(0, 'not logged in', 'This user is not logged in.'),
(1, 'Global Admin', 'This user has full access.'),
(2, 'User account', 'Default user.'),
(3, 'WMS Admin', 'Warehouse administrator');

-- Prof_Rights
CREATE TABLE Prof_Rights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_Rights (id, title, description) VALUES
(0, 'Read All', 'Generic read tag'),
(1, 'Read CMS', 'This user can view CMS content.'),
(2, 'Write CMS', 'This user can alter CMS content.'),
(3, 'Logged Read', 'Generic tag for people logged in.'),
(4, 'Open WMS', 'User can view WMS data'),
(5, 'Edit WMS', 'User can alter WMS data');

-- Prof_Users
CREATE TABLE Prof_Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    hashed_password VARCHAR(255) NOT NULL,
    right_names_id INT NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (right_names_id) REFERENCES Prof_right_names(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_Users (id, username, email, hashed_password, right_names_id, enabled) VALUES
(0, 'Global Admin', 'example@example.exe', 'HASH', 1, true),
(1, 'Generic User', 'example@example.org', 'HASH', 2, true),
(2, 'ClientUser1', 'example@example.de', 'HASH', 2, true),
(3, 'ClientUser2', 'example@example.nl', 'HASH', 2, true);

-- Prof_profiles
CREATE TABLE Prof_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    street VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    donor BOOLEAN DEFAULT FALSE,
    client BOOLEAN DEFAULT FALSE,
    staff BOOLEAN DEFAULT FALSE,
    vegetarian BOOLEAN DEFAULT FALSE,
    loc_id INT NOT NULL,
	roles_id INT NULL,
	date_gone_start DATE NULL,
	date_gone_end DATE NULL,
	FOREIGN KEY (users_id) REFERENCES Prof_Users(id) ON DELETE CASCADE,
	FOREIGN KEY (roles_id) REFERENCES WMS_Roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_profiles (id, users_id, first_name, last_name, street, city, phone, donor, client, staff, vegetarian, loc_id) VALUES
(0, 0, 'Name', 'Namerson', 'Long Name Street', 'Short City', '1234123412', true, false, false, true, 0, 1),
(1, 1, 'Naam', 'Naamsen', 'lange Naam Laan', 'Korte Stad', '1234567890', true, false, false, true, 1, 0),
(2, 2, 'Client 1', 'clientson', 'Long ClientName', 'ClientCity', '1231231230', false, true, false, false, 2, 1),
(3, 3, 'Client 2', 'clientbar', 'Long StreetName', 'ClientCity', '1223164230', false, true, false, false, 2, 2);

CREATE TABLE Prof_Time_off(
	id BIGINT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	start_TiO DATETIME NOT NULL,
	end_TiO DATETIME NOT NULL,
	FOREIGN KEY (users_id) REFERENCES Prof_Users(id) ON DELETE CASCADE
}

-- Prof_right_profiles
CREATE TABLE Prof_right_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    right_names_id INT NOT NULL,
    rights_id INT NOT NULL,
    FOREIGN KEY (right_names_id) REFERENCES Prof_right_names(id) ON DELETE CASCADE,
    FOREIGN KEY (rights_id) REFERENCES Prof_Rights(id) ON DELETE CASCADE,
    UNIQUE KEY unique_right_profile (rights_id, right_names_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_right_profiles (right_names_id, rights_id) VALUES
(0, 0), (0, 3),
(1, 0), (1, 3), (1, 1), (1, 2),
(2, 0), (2, 3),
(3, 0), (3, 3), (3, 4), (3, 5);

-- CMS_Lang
CREATE TABLE CMS_Lang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_key VARCHAR(255) NOT NULL,
    lang_description VARCHAR(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Lang (id, lang_key, lang_description) VALUES
(0, 'EN', 'English'),
(1, 'NL', 'Nederlands');

-- CMS_Page_types
CREATE TABLE CMS_Page_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    option_type VARCHAR(255) NOT NULL,
    option_description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Page_types (id, option_type, option_description) VALUES
(0, 'Plain', 'Just plain text. Nothing else.'),
(1, 'Code', 'Text, but this allows code'),
(2, 'Form', 'This activates form logic.'),
(3, 'Override', 'Prematurely exit the page generation.');

-- CMS_Pages
CREATE TABLE CMS_Pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(100) NOT NULL,
    page_ext VARCHAR(6) NOT NULL,
    lang_id INT NOT NULL,
    lang_Tx VARCHAR(3),
    read_id INT DEFAULT 0,
    read_write_id INT NOT NULL,
    page_head VARCHAR(160) NOT NULL,
    page_load_options ENUM('process', 'write', 'read', 'lock') NOT NULL DEFAULT 'process',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cms_page (lang_id, page_name, page_ext)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Pages (id, page_name, page_ext, lang_id, lang_Tx, read_id, read_write_id, page_head, page_load_options) VALUES
(0, 'Index', '.php', 0, 'EN', 0, 2, 'Welcome', 'process'),
(1, 'CMS_Forms_page', '.php', 0, 'EN', 1, 2, 'CMS - Form creator', 'write'),
(2, 'WMS_Inventory', '.php', 0, 'EN', 1, 2, 'WMS - Inventory', 'lock');

-- CMS_Page_content
CREATE TABLE CMS_Page_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Pages_id INT NOT NULL,
    Page_types_id INT NOT NULL,
    Content_id INT NOT NULL,
    sort INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Page_content (id, Pages_id, Page_types_id, Content_id, sort) VALUES
(0, 0, 0, 0, 0),
(1, 1, 1, 1, 0),
(2, 1, 1, 2, 1);

/* Translating forms - The overaching anchor */

-- CMS_Forms
CREATE TABLE CMS_Forms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(200),
    location VARCHAR(50) NOT NULL,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Forms (id, name, description, location) VALUES
(0, 'Example', 'This is an example form.', './EN/Index.php'),
(1, 'CMS_Form_form', 'Generate Form.', './EN/Index.php');

-- CMS_Form_fields
CREATE TABLE CMS_Form_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    field_key VARCHAR(255) NOT NULL,
    field_type ENUM('text', 'textarea', 'select', 'email', 'checkbox', 'radio', 'button', 'number') NOT NULL,
    field_anker VARCHAR(100),
    field_description VARCHAR(200),
    field_required BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (form_id) REFERENCES CMS_Forms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Form_fields (id, form_id, field_key, field_type, field_anker, field_description, field_required, sort_order) VALUES
(0, 0, 'example_info1', 'email', 'I1', 'This one can be deleted, or kept as example.', true, 0),
(1, 0, 'example_info2', 'button', 'I2', 'This one can be deleted, or kept as example.', true, 1),
(2, 1, 'CMS_Forms_id', 'number', 'CMSF1', 'id of page', true, 0),
(3, 1, 'CMS_Forms_name', 'text', 'CMSF2', 'Name of field', true, 1),
(4, 1, 'CMS_Forms_type', 'text', 'CMSF3', 'Type of element', true, 2),
(5, 1, 'CMS_Forms_handle', 'text', 'CMSF4', 'Unique ID', true, 3),
(6, 1, 'CMS_Forms_description', 'textarea', 'CMSF5', 'description', true, 4),
(7, 1, 'CMS_Forms_req', 'checkbox', 'CMSF6', 'Required or not', true, 5),
(8, 1, 'CMS_Forms_sort', 'number', 'CMSF7', 'Sorting order', true, 6),
(9, 1, 'CMS_Forms_Submit', 'button', 'CMSF8', 'submit button', true, 7);

-- CMS_Form_field_translation
CREATE TABLE CMS_Form_field_translation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_id INT NOT NULL,
    lang_id INT NOT NULL,
    lang_label VARCHAR(255) NOT NULL,
    lang_placeholder VARCHAR(255),
    lang_center VARCHAR(60),
    FOREIGN KEY (field_id) REFERENCES CMS_Form_fields(id) ON DELETE CASCADE,
    FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
    UNIQUE KEY unique_field_lang (field_id, lang_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Form_field_translation (id, field_id, lang_id, lang_label, lang_placeholder, lang_center) VALUES
(0, 0, 0, 'Email Example:', 'Something@something.com', ''),
(1, 1, 0, '', '', 'Click'),
(2, 2, 0, 'Form', 'Unique form ID', ''),
(3, 3, 0, 'Name the field', 'Must be unique', ''),
(4, 4, 0, 'Type of field', 'Textarea, Number', ''),
(5, 5, 0, 'Script ID', 'Must be unique', ''),
(6, 6, 0, 'Description', 'Trivial field information', ''),
(7, 7, 0, 'Required', '', ''),
(8, 8, 0, '', '', 'Submit');

-- CMS_Translations_Other
CREATE TABLE CMS_Translations_Other (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT NOT NULL,
    handle_tag VARCHAR(100) NOT NULL,
    page_id INT NOT NULL,
    text VARCHAR(100) NOT NULL,
    FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
    UNIQUE KEY unique_translate_lang (lang_id, page_id, handle_tag)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Translations_Other (id, lang_id, handle_tag, page_id, text) VALUES
(0, 0, 'WMS_inv_sta_1', 2, 'Staff (volenteers)'),
(1, 0, 'WMS_inv_sta_2', 2, 'Clients'),
(2, 0, 'WMS_inv_sta_3', 2, 'Vegetarians'),
(3, 0, 'WMS_inv_sto_1', 2, 'Stockpile (current)'),
(4, 0, 'WMS_inv_sto_2', 2, 'Stockpile (previous)'),
(5, 0, 'WMS_inv_sto_3', 5, 'Last shipment'),
(6, 0, 'WMS_inv_sto_4', 5, 'shelf-life'),
(7, 0, 'WMS_inv_sto_5', 5, 'Options'),
(8, 0, 'WMS_inv_sto_6', 5, '📦 Transfer');

-- CMS_content_raw
CREATE TABLE CMS_content_raw (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content LONGTEXT NOT NULL,
    description TEXT,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_content_raw (id, content, description) VALUES
(0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Example text'),
(1, '&lt;h1&gt;CMS - Form generator&lt;/h2&gt;&lt;br&gt;Please use the form below to create new forms.', 'CMS - Form - Header'),
(2, 'Welcome at the foodbank.\n This is our newest foodbank page.', 'Index welcome page');

-- CMS_Selectfield
CREATE TABLE CMS_Selectfield (
    id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT,
    descript VARCHAR(200) NOT NULL,
    data_type ENUM('Data', 'Page') NOT NULL,
    FOREIGN KEY (form_id) REFERENCES CMS_Forms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Selectfield (id, form_id, descript, data_type) VALUES
(0, 0, 'Example', 'Data');

-- CMS_SelectOption
CREATE TABLE CMS_SelectOption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_value VARCHAR(10) NOT NULL,
    data_text VARCHAR(255) NOT NULL,
    select_id VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_SelectOption (id, data_value, data_text, select_id) VALUES
(0, '1', 'Example 1', 'Na1'),
(1, '1', 'Example 2', 'Na2');

-- CMS_menu_links
CREATE TABLE CMS_menu_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT NOT NULL,
    pages_id INT NOT NULL,
    rights_id INT NOT NULL,
    description TEXT,
    sort INT NOT NULL,
    style VARCHAR(20),
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
    FOREIGN KEY (pages_id) REFERENCES CMS_Pages(id) ON DELETE CASCADE,
    FOREIGN KEY (rights_id) REFERENCES Prof_Rights(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- WMS_Locations
CREATE TABLE WMS_Locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loc_name VARCHAR(100) NOT NULL,
    loc_zipcode VARCHAR(20) NOT NULL,
    loc_city VARCHAR(100) NOT NULL,
    loc_street VARCHAR(150) NOT NULL,
    loc_1e_contact_id INT NOT NULL,
    loc_2e_contact_id INT,
    loc_enabled BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Locations (id, loc_name, loc_zipcode, loc_city, loc_street, loc_1e_contact_id, loc_2e_contact_id, loc_enabled) VALUES
(0, 'Headquarters', '1111 AA', 'Amsterdam', 'Hoofstraat 11', 0, NULL, true),
(1, 'Breda - Centrum', '2222 BB', 'Breda', 'Brabant weg 1', 0, NULL, true),
(2, 'Amsterdam - Noord', '1111 AB', 'Amsterdam', 'Arnhemse laan 4', 1, NULL, true);

-- WMS_Time_Measure
CREATE TABLE WMS_Time_Measure (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Time_type VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Time_Measure (id, Time_type) VALUES
(0, 'Hours'),
(1, 'Days'),
(2, 'Weeks'),
(3, 'Months'),
(4, 'Years');

-- WMS_Unit_type
CREATE TABLE WMS_Unit_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_type VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Unit_type (id, unit_type) VALUES
(0, 'Kilograms'),
(1, 'Liters'),
(2, 'Packs'),
(3, 'Cartons');

-- WMS_Food_type
CREATE TABLE WMS_Food_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_type VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Food_type (id, food_type) VALUES
(0, 'Grains'),
(1, 'Fruits'),
(2, 'Vegetables'),
(3, 'Dairy'),
(4, 'Meat');

-- WMS_Food_products
CREATE TABLE WMS_Food_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    u_type_id INT NOT NULL,
    f_type_id INT NOT NULL,
    shelflife INT,
    t_type_id INT,
    FOREIGN KEY (u_type_id) REFERENCES WMS_Unit_type(id) ON DELETE CASCADE,
    FOREIGN KEY (f_type_id) REFERENCES WMS_Food_type(id) ON DELETE CASCADE,
    FOREIGN KEY (t_type_id) REFERENCES WMS_Time_Measure(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Food_products (id, u_type_id, f_type_id, shelflife, t_type_id) VALUES
(0, 1, 2, 5, 2),
(1, 2, 0, 1, 2),
(2, 2, 3, 1, 2);

-- WMS_Food_translations
CREATE TABLE WMS_Food_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    f_product_id INT NOT NULL,
    lang_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (f_product_id) REFERENCES WMS_Food_products(id) ON DELETE CASCADE,
    FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Food_translations (id, f_product_id, lang_id, name) VALUES
(0, 0, 0, 'Apple'),
(1, 1, 0, 'Cereal'),
(2, 2, 0, 'Yogurt');

-- WMS_Don_CMR
CREATE TABLE WMS_Don_CMR (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT,
    loc_id INT NOT NULL,
    processed BOOLEAN DEFAULT FALSE,
    pledge_d DATETIME NOT NULL,
    expected_d DATETIME,
    FOREIGN KEY (loc_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- WMS_Donations
CREATE TABLE WMS_Donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_id INT NOT NULL,
    loc_id INT NOT NULL,
    volume INT NOT NULL,
    donor_id INT,
    donor_cmr_id INT NOT NULL,
    pledge_d DATETIME NOT NULL,
    expected_d DATETIME,
    delivery BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (ingredient_id) REFERENCES WMS_Food_products(id) ON DELETE CASCADE,
    FOREIGN KEY (donor_id) REFERENCES Prof_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (donor_cmr_id) REFERENCES WMS_Don_CMR(id) ON DELETE CASCADE,
    FOREIGN KEY (loc_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- WMS_Transfer
CREATE TABLE WMS_Transfer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_id INT NOT NULL,
    loc_sending_id INT NOT NULL,
    loc_recieving_id INT NOT NULL,
    volume INT NOT NULL,
    delivery BOOLEAN DEFAULT FALSE,
    dilivery_date DATETIME NOT NULL,
    FOREIGN KEY (ingredient_id) REFERENCES WMS_Food_products(id) ON DELETE CASCADE,
    FOREIGN KEY (loc_sending_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE,
    FOREIGN KEY (loc_recieving_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Transfer (id, ingredient_id, loc_sending_id, loc_recieving_id, volume, delivery, dilivery_date) VALUES
(0, 1, 0, 1, 22, true, '2025-12-27 10:36:00');

-- WMS_Process
CREATE TABLE WMS_Process (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_id INT NOT NULL,
    loc_id INT NOT NULL,
    volume INT NOT NULL,
    process_date DATETIME NOT NULL,
    FOREIGN KEY (ingredient_id) REFERENCES WMS_Food_products(id) ON DELETE CASCADE,
    FOREIGN KEY (loc_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO WMS_Process (id, ingredient_id, loc_id, volume, process_date) VALUES
(0, 1, 1, 7, NOW());

-- WMS_Stock
CREATE TABLE WMS_Stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_id INT NOT NULL,
    loc_id INT NOT NULL,
    stockpile_new INT NOT NULL,
    stockpile_pre INT NOT NULL,
    last_update DATETIME NOT NULL,
    FOREIGN KEY (ingredient_id) REFERENCES WMS_Food_products(id) ON DELETE CASCADE,
    FOREIGN KEY (loc_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE WMS_Weeks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    week INT NOT NULL,
    year INT NOT NULL,
    start_date DATE,
    end_date DATE,
    UNIQUE (week, year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE WMS_Roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	discription VARCHAR(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO WMS_Roles (id, name, discription) VALUES 
(0, 'Driver', 'Driving to and from food distribution points'),
(1, 'Sorting and Quality', 'Helping to check the quality of ingredients and help package them'),
(2, 'Food Distribution', 'Help to give out food parcels to families in need'),
(3, 'Coordinator', 'Various coordinative and administrative functions');

CREATE TABLE WMS_Roster (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	weeks_id INT NOT NULL,
	prof_id INT NOT NULL,
	loc_id INT NOT NULL,
	day_mon BOOLEAN DEFAULT FALSE,
	day_tue BOOLEAN DEFAULT FALSE,
	day_wed BOOLEAN DEFAULT FALSE,
	day_thu BOOLEAN DEFAULT FALSE,
	day_fri BOOLEAN DEFAULT FALSE,
	day_sat BOOLEAN DEFAULT FALSE,
	day_sun BOOLEAN DEFAULT FALSE,
	FOREIGN KEY (role_id) REFERENCES WMS_Roles(id) ON DELETE CASCADE,
	FOREIGN KEY (prof_id) REFERENCES Prof_users(id) ON DELETE CASCADE,
	FOREIGN KEY (role_id) REFERENCES WMS_Roles(id) ON DELETE CASCADE,
	FOREIGN KEY (loc_id) REFERENCES WMS_Locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELIMITER //

CREATE PROCEDURE AddUpcomingWeeks()
BEGIN
	DECLARE current_date DATE; DECLARE target_date DATE; DECLARE d DATE; DECLARE week INT; DECLARE year INT;
	SET current_date = CURDATE(); SET target_date = DATE_ADD(current_date, INTERVAL 6 MONTH); SET d = current_date;

	WHILE d <= target_date DO SET week = WEEK(d, 3); SET year = YEAR(d + INTERVAL (4 - WEEKDAY(d)) DAY); 
	IF NOT EXISTS(	SELECT 1 FROM WMS_Weeks WHERE week = week AND year = year) THEN INSERT INTO WMS_Weeks (week, year, start_date, end_date) VALUES (week, year, DATE_SUB(d, INTERVAL WEEKDAY(d) DAY), DATE_ADD(DATE_SUB(d, INTERVAL WEEKDAY(d) DAY), INTERVAL 6 DAY)); END IF;

	SET d = DATE_ADD(d, INTERVAL 7 DAY); END WHILE; END //

DELIMITER ;


CREATE EVENT IF NOT EXISTS QuarterlyWeekCheck ON SCHEDULE EVERY 3 MONTH STARTS CURRENT_TIMESTAMP DO CALL AddUpcomingWeeks();


-- Herstel SQL-mode
SET @@SESSION.sql_mode = @old_sql_mode;

//profile aanpassinen met roles_id
	date_gone_start DATE NULL,
	date_gone_end DATE NULL,