/* Database Systems Project Milestone 2 */

/*
--------------------------- 
Create Tables 
---------------------------
*/

/* Create User Table */
CREATE TABLE User
(
    ReviewerID int NOT NULL AUTO_INCREMENT,
    Username varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    PRIMARY KEY (ReviewerID)
);

/* Create Critic Table */
CREATE TABLE Critic
(
    ReviewerID int NOT NULL AUTO_INCREMENT,
    CriticName varchar(255) NOT NULL,
    Publisher varchar(255) NOT NULL,
    PRIMARY KEY (ReviewerID)
);

-- TODO: Figure out how the PKs for Critic and User works

/* Create Director Table */
CREATE TABLE Director
(
    DirectorID int NOT NULL AUTO_INCREMENT,
    Name varchar(255) NOT NULL,
    PRIMARY KEY (DirectorID)
);


/* Create Actor Table */
CREATE TABLE Actor
(
    ActorID int NOT NULL AUTO_INCREMENT,
    Name varchar(255) Not NULL UNIQUE,
    PRIMARY KEY (ActorID)
);

/* Create Review Table */
CREATE TABLE Review
(
    ReviewID int NOT NULL AUTO_INCREMENT,
    MovieID int,
    UserID int,
    Comment varchar(255),
    Rating float,
    ReviewDate date NOT NULL,
    PRIMARY KEY (ReviewID),
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
    FOREIGN KEY (UserID) REFERENCES User(ReviewerID)
);

/* Add Constraint for Review Table */
ALTER TABLE Review
ADD CONSTRAINT chk_ReviewDate
CHECK (
    ReviewDate >= (SELECT ReleaseDate FROM Movie WHERE Movie.MovieID = Review.MovieID)
    AND ReviewDate <= CURRENT_DATE
);

/* Create Movie Table */
CREATE TABLE Movie
(
    MovieID int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    Genre varchar(255) NOT NULL,
    ReleaseDate int(4) NOT NULL,
    Runtime varchar(255) NOT NULL,
    AvgRating float,
    PRIMARY KEY (MovieID)
);

/* Create Genre Table */
CREATE TABLE Genre
(
    GenreID int NOT NULL AUTO_INCREMENT,
    GenreType varchar(255) NOT NULL,
    PRIMARY KEY (GenreID)
);

/* Create MovieActor Table */
CREATE TABLE MovieActor
(
    MovieID int,
    ActorID int,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
    FOREIGN KEY (ActorID) REFERENCES Actor(ActorID)
);

/* Create MovieDirector Table */
CREATE TABLE MovieDirector
(
    MovieID int,
    DirectorID int,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
    FOREIGN KEY (DirectorID) REFERENCES Director(DirectorID)
);

/* Create FavoriteMovies Table */
CREATE TABLE FavoriteMovies
(
    ReviewID int,
    MovieID int,
    Ranking int,
    FOREIGN KEY (ReviewerID) REFERENCES User(ReviewerID),
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

-- TODO: Figure out how to reference PK of both User and Critic

/*
--------------------------- 
Retrieve Data 
---------------------------
*/

/* Retire User Data */
SELECT *
FROM User;

/* Retrieve Critic Information */
SELECT *
FROM Critic;

/* Retrieve Director Information */
SELECT *
FROM Director;

/* Retrieve Actor Information */
SELECT *
FROM Actor;

/* Retrieve Review Information */
SELECT *
FROM Review;

/* Retrieve Movie Information */
SELECT *
FROM Movie;

/* Retrieve Genre Information */
SELECT *
FROM Genre;

/* Retrieve MovieActor Information */
SELECT *
FROM MovieActor;

/* Retrieve MovieDirector Information */
SELECT *
FROM MovieDirector;

/* Retrieve FavoriteMovies Information */
SELECT *
FROM FavoriteMovies;

-- TODO: Add more specific Retrieval Queries

/* 
---------------------------
Add Data
---------------------------
*/

/* Add Data to User */
INSERT INTO User (Username, Password)
VALUES ('test_user', 'password123');

/* Add Data to Critic */
INSERT INTO Critic (CriticName, Publisher)
VALUES ('test_critic', 'test_publisher');

/* Add Data to Director */
CREATE TRIGGER addDirector
AFTER INSERT ON Movie
FOR each row
begin
    INSERT IGNORE INTO Director (Name)
    VALUES ((SELECT Director FROM clean_imdb WHERE clean_imdb.Series_Title=new.Title));
end#

/* Add Data to Actor */

CREATE TRIGGER addActor
AFTER INSERT ON Movie
FOR each row
begin
    INSERT IGNORE INTO Actor (Name)
    VALUES ((SELECT Star1 FROM clean_imdb WHERE clean_imdb.Series_Title=new.Title));
    INSERT IGNORE INTO Actor (Name)
    VALUES ((SELECT Star2 FROM clean_imdb WHERE clean_imdb.Series_Title=new.Title));
    INSERT IGNORE INTO Actor (Name)
    VALUES ((SELECT Star3 FROM clean_imdb WHERE clean_imdb.Series_Title=new.Title));
    INSERT IGNORE INTO Actor (Name)
    VALUES ((SELECT Star4 FROM clean_imdb WHERE clean_imdb.Series_Title=new.Title));
end#

/* Add Data to Review */
INSERT INTO Review (MovieID, UserID, Comment, Rating, ReviewDate)
VALUES ((SELECT MovieID FROM Movie WHERE Name='test_movie'), (SELECT ReviewerID FROM User WHERE Username='test_user'), 'The greatest movie I have ever seen!', 10, curdate());

/* Add Data from csv file to Movie */
/* import csv file into its own table first */
/* Apollo 13 (around row 987) had PG as release year manually fixed to 1995 */
INSERT INTO Movie (Title, Genre, ReleaseDate, Runtime)
SELECT Series_Title, Genre, Released_Year, Runtime FROM clean_imdb;


/* Add Data to Genre */
INSERT INTO Genre (GenreType) VALUES
('Drama'), 
('Crime'), 
('Action'),
('Biography'),
('Western'),
('Comedy'),
('Adventure'),
('Animation'),
('Horror'),
('Mystery'),
('Film-Noir'),
('Fantasy'),
('Family'),
('Thriller');


/* Add Data to MovieActor */
INSERT INTO MovieActor (MovieID, ActorID)
SELECT MovieID, ActorID 
FROM Movie m 
LEFT OUTER JOIN clean_imdb ci 
ON m.Title = ci.Series_Title 
LEFT OUTER JOIN Actor a 
ON a.Name = ci.Star1;

INSERT INTO MovieActor (MovieID, ActorID)
SELECT MovieID, ActorID 
FROM Movie m 
LEFT OUTER JOIN clean_imdb ci 
ON m.Title = ci.Series_Title 
LEFT OUTER JOIN Actor a 
ON a.Name = ci.Star2;

INSERT INTO MovieActor (MovieID, ActorID)
SELECT MovieID, ActorID 
FROM Movie m 
LEFT OUTER JOIN clean_imdb ci 
ON m.Title = ci.Series_Title 
LEFT OUTER JOIN Actor a 
ON a.Name = ci.Star3;

INSERT INTO MovieActor (MovieID, ActorID)
SELECT MovieID, ActorID 
FROM Movie m 
LEFT OUTER JOIN clean_imdb ci 
ON m.Title = ci.Series_Title 
LEFT OUTER JOIN Actor a 
ON a.Name = ci.Star4;

/* Add Data to MovieDirector */
INSERT INTO MovieDirector (MovieID, DirectorID)
SELECT MovieID. DirectorID
FROM Movie m 
LEFT OUTER JOIN clean_imdb ci 
ON m.Title = ci.Series_Title 
LEFT OUTER JOIN Director d 
ON d.Name = ci.Director;

/* Add Data to FavoriteMovies */
-- TODO:

/* 
---------------------------
Update Data 
---------------------------
*/

/* Update clean_imdb */
UPDATE clean_imdb
SET Genre = (SELECT GenreID FROM Genre WHERE GenreType=clean_imdb.Genre)

/* Update AvgRating in Movie Table */
CREATE TRIGGER trg_UpdateAverageRating
AFTER INSERT OR UPDATE OR DELETE ON Review
FOR EACH ROW
BEGIN
    UPDATE Movie
    SET AverageRating = (
        SELECT AVG(Rating)
        FROM Review
        WHERE MovieID = NEW.MovieID
    )
    WHERE MovieID = NEW.MovieID;
END;

/* 
---------------------------
Delete Data 
---------------------------
*/

/* Delete Data from User */
DELETE FROM User
WHERE ReviewerID=id;

/* Delete Data from Critic */
DELETE FROM Critic
WHERE ReviewerID=id;

/* Delete Data from Director */
DELETE FROM Director
WHERE DirectorID=id;

/* Delete Data from Actor */
DELETE FROM Actor
WHERE ActorID=id;

/* Delete Data from Review */
DELETE FROM Review
WHERE ReviewID=id;

CREATE TRIGGER removeUserReview
AFTER DELETE ON User
FOR each row
begin
    DELETE FROM Review
    WHERE Review.UserID=old.ReviewerID;
end#

CREATE TRIGGER removeCriticReview
AFTER DELETE ON Critic
FOR each row
begin
    DELETE FROM Review
    WHERE Review.UserID=old.ReviewerID;
end#

/* Delete Data from Movie */
DELETE FROM Movie
WHERE MovieID=id;

/* Delete Data from Genre */
DELETE FROM Genre
WHERE GenreID=id;

/* Delete Data from MovieActor */
DELETE FROM MovieActor
WHERE MovieID=movie_id AND ActorID=actor_id;

CREATE TRIGGER removedMovieActor
AFTER DELETE ON Movie
FOR each row
begin
    DELETE FROM MovieActor
    WHERE MovieID=old.MovieID;
end#

CREATE TRIGGER removedActorMovie
AFTER DELETE ON Actor
FOR each row
begin
    DELETE FROM MovieActor
    WHERE ActorID=old.ActorID;
end#

/* Delete Data from MovieDirector */
DELETE FROM MovieDirector
WHERE MovieID=move_id AND DirectorID=director_id;

CREATE TRIGGER removedMovieDirector
AFTER DELETE ON Movie
FOR each row
begin
    DELETE FROM MovieDirector
    WHERE MovieID=old.MovieID;
end#

CREATE TRIGGER removedDirectorMovie
AFTER DELETE ON Director
FOR each row
begin
    DELETE FROM MovieDirector
    WHERE DirectorID=old.DirectorID; 

/* Delete Data from FavoriteMovies */
DELETE FROM FavorieMovies;
--TODO: Need to complete