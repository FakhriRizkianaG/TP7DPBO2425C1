-- ======================================================
-- Database: GameDB
-- ======================================================

CREATE DATABASE IF NOT EXISTS gameDB;
USE gameDB;

-- ======================================================
-- Table: User
-- ======================================================
CREATE TABLE User (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Bio TEXT,
    DateJoined DATE NOT NULL
);

-- ======================================================
-- Table: Developer
-- ======================================================
CREATE TABLE Developer (
    DevId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Owner INT NOT NULL,
    Status ENUM('Indie', 'Commercial') NOT NULL,
    FOREIGN KEY (Owner) REFERENCES User(UserId)
);

-- ======================================================
-- Table: Games
-- ======================================================
CREATE TABLE Games (
    GameId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Developer INT NOT NULL,
    Genre VARCHAR(50),
    Price INT,
    FOREIGN KEY (Developer) REFERENCES Developer(DevId)
);

-- ======================================================
-- Dummy Data
-- ======================================================

-- Insert into User
INSERT INTO User (Name, Bio, DateJoined) VALUES
('Fakhri Rizkiana', 'I do A lot of stuff', '2024-05-14'),
('Kim Ji Hoon', 'A Korean game developer', '2020-10-22'),
('Andrew Wilson', 'CEO of EA.', '2023-02-08'),
('Ankou', 'I like cats.', '2015-02-08'),
('Daffa Dhiya', 'Waifuku Kucing.', '2025-07-30'),
('Budi Santoso', 'just Chilling.', '2020-07-30');

-- Insert into Developer
INSERT INTO Developer (Name, Owner, Status) VALUES
('Frizkian Studio', 1, 'Indie'),
('Project Moon', 2, 'Indie'),
('Electronic Arts', 3, 'Commercial'),
('NEKO WORKs', 4, 'Commercial');

-- Insert into Games
INSERT INTO Games (Name, Developer, Genre, Price) VALUES
('Treasure i Cannot Posses', 1, 'Dating Sim', 75000),
('Lobotomy Corporration', 2, 'Management Simulation', 120000),
('Library of Ruina', 2, 'Card Game', 120000),
('Limbus Company', 2, 'Gacha RPG', 0),
('Cash Grab game', 3, 'Arcade', 300000),
('FIFA Football', 3, 'Sport', 700000),
('nekopara VOL 1', 4, 'Visual Novel', 152000);
