CREATE TABLE profile (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  title VARCHAR(100) NOT NULL,
  bio TEXT,
  email VARCHAR(100),
  phone VARCHAR(20),
  profile_image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  skill_name VARCHAR(100) NOT NULL,
  proficiency_level VARCHAR(50) NOT NULL,
  category VARCHAR(50) DEFAULT 'Technical',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  link VARCHAR(255),
  tech_stack VARCHAR(255),
  project_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Optional indexes for performance
CREATE INDEX idx_profile_name ON profile(full_name);



INSERT INTO profile (full_name, title, bio, email, phone, profile_image)
VALUES ('John Doe', 'Full Stack Developer', 'Passionate about web development.', 'john@example.com', '123-456-7890', 'assets/img/profile.jpg');
