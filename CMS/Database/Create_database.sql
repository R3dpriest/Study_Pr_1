SET @old_sql_mode = @@SESSION.sql_mode;
SET @@SESSION.sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

----------- EVERYTHING PROFILE RELATED ----------- 

/* Users */
CREATE TABLE Prof_Users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL UNIQUE,
	hashed_password VARCHAR(255) NOT NULL,
	right_names_id INT NOT NULL,							-- links the rights profile
	enabled BOOLEAN NOT NULL DEFAULT 1;
	FORGEIN KEY (right_names_id) REFERENCES right_names(id) on DELETE CASCADE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO Prof_Users (id, username, email, hashed_password, right_names_id, enabled) VALUES (0 ,'Global Admin' ,'example.example.exe' ,'HASH' ,1 ,1), (1 ,'Generic User' ,'example.example.exe' ,'HASH' ,2 ,1);

/* Profiles */
CREATE TABLE Prof_profles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	users_id INT NOT NULL,
	first_name VARCHAR(100) NOT NULL,
	last_name VARCHAR(100) NOT NULL,
	street VARCHAR(255) NOT NULL,
	city VARCHAR(255) NOT NULL,
	phone VARCHAR(20) NULL,
	donor BOOLEAN DEFAULT FALSE,		-- if profile is made as company this can become yes
	FORGEIN KEY (users_id) REFERENCES Prof_Users(id) on DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* set over arching rights profile */
CREATE TABLE Prof_Rights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20) NOT NULL,  -- aka "Read CMS"
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_right_names (id, name, description) VALUES (0, 'Read All', 'Generic read tag'), (1, 'Read CMS', 'This user can view CMS content.'), (2, 'Write CMS', 'This user can alter CMS content.'), (3, 'Logged Read', 'Generic tag for people logged in.');

/* profile names */
CREATE TABLE Prof_right_names (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(40) NOT NULL,			-- "Not logged in"
	description VARCHAR(255) NULL		-- "This user has not logged in"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO Prof_right_names (id, name, description) VALUES (0, 'not logged in', 'This user is not logged in.'), (1, 'Global Admin', 'This user is not logged in.'), (2, 'User account', 'Default user.'), ;

/* profiles - rights table*/
CREATE TABLE Prof_right_profiles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	right_names_id INT(10) NOT NULL,			-- "1" references the named user profile
	rights_id INT(10) NOT NULL,					-- "12" references all rights assigned
	FOREIGN KEY (right_names_id) REFERENCES Prof_right_names(id) ON DELETE CASCADE,
	FOREIGN KEY (right_id) REFERENCES Prof_rights(id) ON DELETE CASCADE,
	UNIQUE KEY unique_cms_page (rights_id, right_names_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO Prof_right_profiles (right_names_id, rights_id) VALUES (0, 0), (1, 0), (2, 0), (0, 3), (1, 3), (2, 3), (1, 1), (1, 2);


----------- EVERYTHING CMS RELATED -----------

/* languages */
CREATE TABLE CMS_Lang (
	id INT AUTO_INCREMENT PRIMARY KEY,
	lang_key VARCHAR(255) NOT NULL,				-- "EN", "NL"
	lang_description VARCHAR() NULL				-- "English", Nederlands
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO CMS_Lang (id, lang_key, lang_description) VALUES (0, 'EN', 'English'), (1, 'NL', 'Nederlands');

----------- SUB - CONTENT -----------

/* Translating - widget types */

CREATE TABLE CMS_Page_types (
	id INT AUTO_INCREMENT PRIMARY KEY,
	option_type VARCHAR(255) NOT NULL,				-- "CMS_Form", "CMS_Page_Text"
	option_description VARCHAR(255) NOT NULL		-- "Forms", "Textcontent"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO CMS_Page_types (id, option_type, option_description) VALUES (0, 'Plain', 'Just plain text. Nothing else.'), (1, 'Code', 'Text, but this allows code'), (2, 'Form', 'This activate form logic.'), (3, 'Override', 'Prematurely exit the page generation.');


/* Storage pages */
CREATE TABLE CMS_Pages (
	id INT AUTO_INCREMENT PRIMARY KEY,
	page_name VARCHAR(100) NOT NULL,			-- "index"
	page_ext VARCHAR(6) NOT NULL, 				-- ".PHP", ".HTML"
	lang_id INT(10) NOT NULL,					-- "1"
	lang_Tx VARCHAR(3) NOT NULL,				-- "1"
	read_id INT(10) NULL DEFAULT 0,				-- what rights are needed to READUP
	read_write_id INT(10) NOT NULL,				-- what rights can write
	page_head VARCHAR(160) NOT NULL,
	created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (page_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
	UNIQUE KEY unique_cms_page (lang_id, page_name, page_ext)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO CMS_Page_types (id, page_name, page_ext, lang_id, lang_Tx, read_id, read_write_id, page_head) VALUES 
(0, 'Index', '.php', 0, 'EN', 0, );

	
/* content page modules */
CREATE TABLE CMS_Page_content (
	id INT AUTO_INCREMENT PRIMARY KEY,
	Pages_id INT(10) NOT NULL,					-- links to the main page // should have preselected language
	Page_types_id INT(10) NOT NULL,				-- Type of content
	Content_id INT(30) NOT NULL,				-- Links to spefic ID that is preselected 
	sort INT(5) NOT NULL,					-- The order at wich it must be loaded on the page.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* Translating forms - The overaching anchor */

CREATE TABLE CMS_Forms (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description VARCHAR(200) NULL,
	location VARCHAR(50) NOT NULL,
	created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
	
/* forms - these generate fields */
 
CREATE TABLE CMS_Form_fields (
	id INT AUTO_INCREMENT PRIMARY KEY,
	form_id INT NOT NULL,						-- Link to CMS_Forms
	field_key VARCHAR(100) NOT NULL,			-- For the name field_id
	field_type ENUM('text', 'textarea', 'select', 'email', 'checkbox', 'radio', 'button') NOT NULL, -- for the type field
	field_anker VARCHAR(100) NULL,				-- for the ID field
	field_description VARCHAR(100) NULL,		-- for internal Description
	field_required BOOLEAN DEFAULT FALSE,		-- says if field is required
	field_label VARCHAR(120) NULL,				-- create label with this text
	field_placeholder VARCHAR(40) NULL,			-- placeholder / button text info
	sort_order INT DEFAULT 0,					-- Sorts the fields upon generation
	FOREIGN KEY (form_id) REFERENCES CMS_Forms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* forms translations */

CREATE TABLE CMS_Form_field_translation (
	id INT AUTO_INCREMENT PRIMARY KEY,
	field_id INT NOT NULL,								-- Link to CMS_Form_fields
	lang_id INT NOT NULL,								-- 1, 2, 3
	lang_label VARCHAR(255) NOT NULL,					-- Label "Name", "Naam"
	lang_placeholder VARCHAR(255) NULL,					-- Placeholder "Hover", "zweven"
	FOREIGN KEY (field_id) REFERENCES CMS_form_fields(id) ON DELETE CASCADE,
	FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
	UNIQUE KEY unique_field_lang (field_id, lang_code)	-- makes sure translations are unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- escape this content $escaped = mysqli_real_escape_string($conn, $user_input);

CREATE TABLE CMS_content_raw (
	id INT AUTO_INCREMENT PRIMARY KEY,
	content LONGTEXT NOT NULL,
	description TEXT NULL,
	created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

----------- SUB - MENU -----------

CREATE TABLE CMS_menu_links (
	id INT AUTO_INCREMENT PRIMARY KEY,
	lang_id INT NOT NULL,								-- what language the field is
	pages_id INT NOT NULL,								-- the page it links to
	rights_id INT NOT NULL,								-- the aka the id of "Read CMS"
	description TEXT NULL,
	sort INT(10) NOT NULL,	
	style VARCHAR(20) NULL,								-- css reference
	created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (lang_id) REFERENCES CMS_Lang(id) ON DELETE CASCADE,
	FOREIGN KEY (pages_id) REFERENCES CMS_Pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;





SET @@SESSION.sql_mode = @old_sql_mode;