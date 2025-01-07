CREATE DATABASE IF NOT EXISTS Kanban_Project_db;
USE Kanban_Project_db;

CREATE TABLE IF NOT EXISTS Person (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(100) DEFAULT 'Project Manager',
);

CREATE TABLE IF NOT EXISTS Category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Project (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    isPublic BOOLEAN DEFAULT FALSE,
    manager_id INT NOT NULL,
    completion_percentage INT DEFAULT 0,
    FOREIGN KEY (manager_id) REFERENCES Person(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    createDate DATE DEFAULT (CURRENT_DATE),
    startDate DATE,
    endDate DATE,
    status ENUM('TODO', 'DOING', 'REVIEW', 'DONE') DEFAULT 'TODO',
    tag_id INT DEFAULT NULL,
    category_id INT NOT NULL,
    project_id INT NOT NULL,
    project_category_tag_id INT NOT NULL,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES Category(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Task_Assignment (
    task_id INT NOT NULL,
    person_id INT NOT NULL,
    PRIMARY KEY (task_id, person_id),
    FOREIGN KEY (task_id) REFERENCES Task(id) ON DELETE CASCADE,
    FOREIGN KEY (person_id) REFERENCES Person(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Project_Assignment (
    project_id INT NOT NULL,
    person_id INT NOT NULL,
    role ENUM('Member', 'Pending Request') DEFAULT 'Pending Request',
    PRIMARY KEY (project_id, person_id),
    FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE,
    FOREIGN KEY (person_id) REFERENCES Person(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Project_Category_Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    category_id INT DEFAULT NULL,
    tag_id INT DEFAULT NULL,
    FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Category(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE CASCADE
);

-- Insert users
INSERT INTO Person (name, email, password, role) VALUES
('Ibrahim', 'a@a.com', '$2a$12$BNMYsiPpHKpGV4/5oEZlV.N4S.ZHo2Fp8E5v9MHZKO6frTiUErUR6', 'Admin'),
('Nidam', 'a@z.com', '$2a$12$BNMYsiPpHKpGV4/5oEZlV.N4S.ZHo2Fp8E5v9MHZKO6frTiUErUR6', 'Project Manager'),
('Amina', 'b@b.com', '$2a$12$I385gBiyz2yGKaJbIZ19l.8JOxB0204AGsw5FlUeZAAWGujfSlRry', 'Project Manager'),
('Youssef', 'c@c.com', '$2a$12$I385gBiyz2yGKaJbIZ19l.8JOxB0204AGsw5FlUeZAAWGujfSlRry', 'Project Manager'),
('Sara', 'd@d.com', '$2a$12$I385gBiyz2yGKaJbIZ19l.8JOxB0204AGsw5FlUeZAAWGujfSlRry', 'Project Manager');

-- Insert categories
INSERT INTO Category (name) VALUES
('Development'),
('Design'),
('Testing'),
('Documentation');

-- Insert tags
INSERT INTO Tag (name) VALUES
('Urgent'),
('Feature'),
('Bug'),
('Improvement');

-- Insert projects
INSERT INTO Project (name, description, isPublic, manager_id) VALUES
('Project Alpha', 'Main development project', TRUE, 2), -- Nidam's project
('Project Beta', 'UI/UX design overhaul', FALSE, 3), -- Amina's project
('Project Gamma', 'Testing automation suite', TRUE, 4); -- Youssef's project

-- Link categories and tags to projects
INSERT INTO Project_Category_Tag (project_id, category_id, tag_id) VALUES
(1, 1, 2), -- Project Alpha: Development + Feature
(1, 3, 1), -- Project Alpha: Testing + Urgent
(2, 2, 4), -- Project Beta: Design + Improvement
(3, 4, 3); -- Project Gamma: Documentation + Bug

-- Insert tasks
INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id, project_category_tag_id) VALUES
('Set Up Backend API', 'Implement the REST API for the project', '2025-01-07', '2025-01-10', 'TODO', 2, 1, 1, 1), -- Project Alpha
('Design Homepage', 'Create wireframes for the homepage', '2025-01-07', '2025-01-12', 'DOING', 4, 2, 2, 2), -- Project Beta
('Write Test Cases', 'Add unit and integration tests', '2025-01-08', '2025-01-14', 'REVIEW', 3, 3, 1, 3), -- Project Alpha
('User Guide', 'Write user documentation', '2025-01-09', '2025-01-16', 'DONE', 3, 4, 3, 4); -- Project Gamma

-- Assign tasks to users
INSERT INTO Task_Assignment (task_id, person_id) VALUES
(1, 2), -- Nidam assigned to "Set Up Backend API"
(2, 3), -- Amina assigned to "Design Homepage"
(3, 4), -- Youssef assigned to "Write Test Cases"
(4, 5); -- Sara assigned to "User Guide"

-- Assign members to projects
INSERT INTO Project_Assignment (project_id, person_id, role) VALUES
(1, 2, 'Member'), -- Nidam is the manager, also added explicitly
(1, 5, 'Pending Request'), -- Sara requested to join Project Alpha
(2, 3, 'Member'), -- Amina is the manager of Project Beta
(3, 4, 'Member'), -- Youssef is the manager of Project Gamma
(3, 2, 'Pending Request'); -- Nidam requested to join Project Gamma

