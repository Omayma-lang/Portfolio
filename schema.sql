-- Freelance Portfolio Database Schema
-- Run this in phpMyAdmin (XAMPP) or via MySQL CLI on port 3307

CREATE DATABASE IF NOT EXISTS portfolio_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portfolio_db;

-- Projects table: one row per finished project/site
CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  short_description TEXT NOT NULL,
  full_description LONGTEXT,
  tech_used TEXT,
  live_url VARCHAR(500),
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Project images: multiple screenshots per project
CREATE TABLE IF NOT EXISTS project_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_id INT NOT NULL,
  image_path VARCHAR(500) NOT NULL,
  caption VARCHAR(255) DEFAULT NULL,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_project_images_project
    FOREIGN KEY (project_id) REFERENCES projects(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Certificates: credentials you can showcase later
CREATE TABLE IF NOT EXISTS certificates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  issuer VARCHAR(255) DEFAULT NULL,
  cert_date VARCHAR(100) DEFAULT NULL,
  image_path VARCHAR(500) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Site settings: editable hero/about copy without editing code
CREATE TABLE IF NOT EXISTS site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value LONGTEXT
) ENGINE=InnoDB;

-- Seed some default settings for the home page
INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES
('hero_heading', 'Welcome, I''m Omayma.'),
('hero_subheading', 'A Full-Stack Developer combining the precision of backend engineering with the beauty of frontend design. I transform creative ideas into living digital experiences delivered right on time.'),
('about_text', 'I build web experiences that help small businesses and individuals turn visitors into customers. My work spans web development, with UI/UX design and video editing as complementary skills I bring to every project.'),
('contact_email', 'okhelfaoui23@gmail.com');
