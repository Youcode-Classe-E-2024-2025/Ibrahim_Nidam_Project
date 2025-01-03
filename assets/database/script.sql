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
    tag_id INT,
    category_id INT NOT NULL,
    project_id INT NOT NULL,
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
    PRIMARY KEY (project_id, person_id),
    FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE,
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

INSERT INTO Project (name, description, isPublic, manager_id, completion_percentage) VALUES
('Kanban Board Project', 'A board to manage tasks in columns', TRUE, 1, 0),
('E-commerce App', 'An application to handle online sales and checkouts', FALSE, 1, 0),
('Mobile Game', 'A fun casual game for iOS and Android platforms', TRUE, 1, 0),
('Chat Application', 'A real-time chat app with notifications', FALSE, 1, 0);

INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id) VALUES
('Set Up Repository', 'Initialize Git repository and set up project structure', '2025-01-02', '2025-01-05', 'TODO', 3, 1, 1),
('Define Workflow', 'Establish Kanban workflow stages and policies', '2025-01-06', '2025-01-10', 'TODO', 4, 2, 1),
('Design UI Mockups', 'Create initial UI mockups for the Kanban board', '2025-01-11', '2025-01-15', 'TODO', 3, 2, 1),
('Implement Authentication', 'Develop user authentication system', '2025-01-16', '2025-01-20', 'TODO', 1, 1, 1),
('Deploy Initial Version', 'Deploy the initial version of the Kanban board application', '2025-01-21', '2025-01-25', 'TODO', 5, 5, 1);

INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id) VALUES
('DB Schema Design', 'Design database schema for products and users', '2025-02-01', '2025-02-05', 'TODO', 3, 1, 2),
('Payment System', 'Integrate payment gateway system', '2025-02-06', '2025-02-10', 'TODO', 1, 1, 2),
('Product Catalog', 'Create product listing interface', '2025-02-11', '2025-02-15', 'TODO', 3, 2, 2),
('User Auth', 'Implement user authentication', '2025-02-16', '2025-02-20', 'TODO', 1, 1, 2),
('Test Payment', 'Test payment system integration', '2025-02-21', '2025-02-25', 'TODO', 2, 3, 2);

INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id) VALUES
('Game Design Doc', 'Create game design document', '2025-03-01', '2025-03-05', 'TODO', 5, 4, 3),
('Character Art', 'Design main character sprites', '2025-03-06', '2025-03-10', 'TODO', 3, 2, 3),
('Game Mechanics', 'Implement core game mechanics', '2025-03-11', '2025-03-15', 'TODO', 3, 1, 3),
('Sound Effects', 'Create and integrate SFX', '2025-03-16', '2025-03-20', 'TODO', 4, 2, 3),
('Beta Testing', 'Conduct beta testing phase', '2025-03-21', '2025-03-25', 'TODO', 2, 3, 3);

INSERT INTO Task (title, description, startDate, endDate, status, tag_id, category_id, project_id) VALUES
('WebSocket Setup', 'Set up WebSocket server', '2025-04-01', '2025-04-05', 'TODO', 3, 1, 4),
('Chat UI Design', 'Design chat interface', '2025-04-06', '2025-04-10', 'TODO', 4, 2, 4),
('Message System', 'Implement messaging system', '2025-04-11', '2025-04-15', 'TODO', 3, 1, 4),
('Security Check', 'Perform security audit', '2025-04-16', '2025-04-20', 'TODO', 1, 3, 4),
('API Documentation', 'Document chat API endpoints', '2025-04-21', '2025-04-25', 'TODO', 5, 4, 4);

INSERT INTO Task_Assignment (task_id, person_id) VALUES
(1, 2), (2, 3), (3, 4), (4, 5), (5, 2),
(6, 2), (7, 3), (8, 4), (9, 5), (10, 2),
(11, 3), (12, 4), (13, 5), (14, 2), (15, 3),
(16, 4), (17, 5), (18, 2), (19, 3), (20, 4);