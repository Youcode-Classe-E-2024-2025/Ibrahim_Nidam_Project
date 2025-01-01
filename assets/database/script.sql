CREATE DATABASE IF NOT EXISTS Kanban_Project_db;

USE Kanban_Project_db;

CREATE TABLE IF NOT EXISTS Person (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Project Manager', 'Member') DEFAULT 'Member',
    isLogged BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS Project(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    isPublic BOOLEAN DEFAULT FALSE,
    manager_id INT NOT NULL,
    completion_percentage INT DEFAULT 0,
    FOREIGN KEY (manager_id) REFERENCES Person(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Task(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(16) NOT NULL,
    description TEXT,
    createDate DATE DEFAULT CURRENT_DATE,
    startDate DATE,
    endDate DATE,
    status ENUM ('TODO', 'DOING', 'REVIEW', 'DONE') DEFAULT 'TODO',
    tag_id INT,
    category_id INT NOT NULL,
    project_id INT NOT NULL,
    FOREIGN KEY (tag_id) REFERENCES Tag(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES Category(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Task_Assignment (
    task_id INT NOT NULL,
    person_id INT NOT NULL,
    PRIMARY KEY (task_id, person_id),
    FOREIGN KEY (task_id) REFERENCES Task(id) ON DELETE CASCADE,
    FOREIGN KEY (person_id) REFERENCES Person(id) ON DELETE CASCADE
);

INSERT INTO Person (name, email, password, role, isLogged) VALUES
('Ibrahim Nidam', 'a@e.com', '$2a$12$CaK1h7hZOPH8lHlrzfWcG.9GKNeQvFzBWkM5oELpFgWJqa0ZyCTOa', 'Project Manager', FALSE),
('Ali Rachid', 'b@e.com', '$2a$12$22jwn/Pb.vCcrFbOe/qgmOtJAGLTE1fcL66VbkFnjn.gffgrB2kX6', 'Member', FALSE),
('Sara Elham', 'c@e.com', '$2a$12$22jwn/Pb.vCcrFbOe/qgmOtJAGLTE1fcL66VbkFnjn.gffgrB2kX6', 'Member', FALSE),
('Omar Haddad', 'd@e.com', '$2a$12$22jwn/Pb.vCcrFbOe/qgmOtJAGLTE1fcL66VbkFnjn.gffgrB2kX6', 'Member', FALSE),
('Lina Amina', 'e@e.com', '$2a$12$22jwn/Pb.vCcrFbOe/qgmOtJAGLTE1fcL66VbkFnjn.gffgrB2kX6', 'Member', FALSE);

INSERT INTO Category (name) VALUES
('Development'),
('Design'),
('Testing'),
('Documentation'),
('Deployment');

INSERT INTO Tag (name) VALUES
('Urgent'),
('Bug'),
('Feature'),
('Improvement'),
('Research');

INSERT INTO Project (name, isPublic, manager_id, completion_percentage) VALUES
('Kanban Board Project', TRUE, 1, 0);

INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id) VALUES
('Set up project environment', 'Initialize the development environment with required tools.', '2025-01-02', '2025-01-05', 'TODO', 3, 1, 1),
('Create UI design', 'Design the user interface for the application.', '2025-01-06', '2025-01-10', 'TODO', 4, 2, 1),
('Write test cases', 'Write unit and integration test cases for the features.', '2025-01-11', '2025-01-15', 'TODO', 2, 3, 1),
('Prepare documentation', 'Document the project workflow and APIs.', '2025-01-16', '2025-01-20', 'TODO', 5, 4, 1),
('Deploy application', 'Deploy the application to the production server.', '2025-01-21', '2025-01-25', 'TODO', 1, 5, 1);

INSERT INTO Task_Assignment (task_id, person_id) VALUES
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 2);