<?php

session_start();

function addReview($movieID, $userID, $comment, $rating, $date)
{
   global $db;   
   // $reqDate = date('Y-m-d');
      
   $query = "INSERT INTO Review (MovieID, UserID, Comment, Rating, ReviewDate) VALUES (:movieID, :userID, :comment, :rating, :date)";  
   
   try { 

      // prepared statement
      // pre-compile
      $statement = $db->prepare($query);

      // fill in the value
      $statement->bindValue(':movieID', $movieID);
      $statement->bindValue(':userID', $userID);
      $statement->bindValue(':comment',$comment);
      $statement->bindValue(':rating', $rating);
      $statement->bindValue(':date', $date);

      // exe
      $statement->execute();
      $statement->closeCursor();
   } catch (PDOException $e)
   {
      $e->getMessage();
   } catch (Exception $e) 
   {
      $e->getMessage();
   }

}

function getAllMovies()
{
   global $db;
   $query = "select * from Movie";    
   $statement = $db->prepare($query);
   $statement->execute();
   $result = $statement->fetchAll(); 
   $statement->closeCursor();

   return $result;
}

function getReviewsByMovieId($id)  
{
   global $db;
   $query = "select * from Review where MovieID=:MovieID"; 
   $statement = $db->prepare($query);
   $statement->bindValue(':MovieID', $id);
   $statement->execute();
   $result = $statement->fetchAll();
   $statement->closeCursor();

   return $result;
}

//delete review
function deleteReview($reviewID, $userID) {
   global $db;

   $query = "SELECT * FROM Review WHERE ReviewID = :reviewID AND UserID = :userID";
   $statement = $db->prepare($query);
   $statement->bindValue(':reviewID', $reviewID);
   $statement->bindValue(':userID', $userID);
   $statement->execute();
   $result = $statement->fetch();
   $statement->closeCursor();

   if ($result) {
       $query = "DELETE FROM Review WHERE ReviewID = :reviewID";
       $statement = $db->prepare($query);
       $statement->bindValue(':reviewID', $reviewID);
       $statement->execute();
       $statement->closeCursor();
   }
}

//update review
function updateReview($reviewID, $movieID, $userID, $comment, $rating, $date) {
    global $db;

    $query = "SELECT * FROM Review WHERE ReviewID = :reviewID AND UserID = :userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':reviewID', $reviewID);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    if ($result) {
        $query = "UPDATE reviews SET MovieID = :movieID, UserID = :userID, Comment = :comment, Rating = :rating, ReviewDate = :date WHERE ReviewID = :reviewID";
        $statement = $db->prepare($query);
        $statement->bindValue(':reviewID', $reviewID);
        $statement->bindValue(':movieID', $movieID);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':comment', $comment);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':date', $date);
        $statement->execute();
        $statement->closeCursor();
    }
}

//organize movies by rating
function getMoviesByRating()
{
   {
      global $db;
      $query = "select * from Movie order by AvgRating DESC";    
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(); 
      $statement->closeCursor();
   
      return $result;
   }
}

function registerUser($username, $password) {
   global $db;
   $query = "INSERT INTO User (Username, Password) VALUES (:username, :password)";

   try {
       $statement = $db->prepare($query);
       $statement->bindValue(':username', $username);
       $statement->bindValue(':password', $password);
       $statement->execute();
       $statement->closeCursor();
       return true;
   } catch (PDOException $e) {
       echo 'PDOException: ' . $e->getMessage();
       return false;
   }
}

function loginUser($username, $password) {
   global $db;
   $query = "SELECT Password FROM User WHERE Username = :username";

   try {
       $statement = $db->prepare($query);
       $statement->bindValue(':username', $username);
       $statement->execute();
       $result = $statement->fetch();
       $statement->closeCursor();

       if ($password == $result) {
           if (!isset($_SESSION['loggedin'])) { 
               session_start();
           }
           $_SESSION['loggedin'] = true;
           $_SESSION['username'] = $username;
           return true;
       } else {
           return false;
       }
   } catch (PDOException $e) {
       echo 'PDOException: ' . $e->getMessage();
       return false;
   }
}

function getUserType($reviewID){
   global $db;

   $query = "SELECT is_critic FROM Review WHERE ReviewID = :reviewid";
   $statement = $db->prepare($query);
   $statement->bindValue(':reviewid', $reviewID);
   $statement->execute();
   $is_critic = $statement->fetch();
   $statement->closeCursor();

   return $is_critic[0];
}

function findAuthorName($reviewID, $userID){
   global $db;

   $is_critic = getUserType($reviewID);

   if($is_critic){
      $query = "SELECT CriticName FROM Critic WHERE ReviewerID = :userid";
      $statement = $db->prepare($query);
      $statement->bindValue(':userid', $userID);
      $statement->execute();
      $result = $statement->fetch();
      $statement->closeCursor();
   }
   else{
      $query = "SELECT Username FROM User WHERE ReviewerID=:userid";
      $statement = $db->prepare($query);
      $statement->bindValue(':userid', $userID);
      $statement->execute();
      $result = $statement->fetch();
      $statement->closeCursor();
   }
   return $result[0];

}

function getPublisher($criticID){
   global $db;

   $query = "SELECT Publisher FROM Critic WHERE ReviewerID = :criticid";
   $statement = $db->prepare($query);
   $statement->bindValue(':criticid', $criticID);
   $statement->execute();
   $publisher = $statement->fetch();
   $statement->closeCursor();

   return $publisher[0];
}

function searchMovie($searchfor){
   global $db;

   $searchfor = "%".$searchfor."%";

   $query = "select * from Movie where UPPER(Title) LIKE UPPER(:searchfor)";

   $statement = $db->prepare($query);
   $statement->bindValue(':searchfor', $searchfor);
   $statement->execute();
   $result = $statement->fetchAll();
   $statement->closeCursor();

   return $result;
}

function getGenre($movieid){
   global $db;

   $query = "select genre from Genre where MovieID=:movieid";

   $statement = $db->prepare($query);
   $statement->bindValue(':movieid', $movieid);
   $statement->execute();
   $result = $statement->fetchAll();
   $statement->closeCursor();

   return $result;
}


// function updateRequest($reqId, $reqDate, $roomNumber, $reqBy, $repairDesc, $reqPriority)
// {
//    global $db;
//    $query = "update requests set reqDate=:reqDate, roomNumber=:roomNumber, reqBy=:reqBy, repairDesc=:repairDesc, reqPriority=:reqPriority where reqId=:reqId" ; 

//    $statement = $db->prepare($query);
//    $statement->bindValue(':reqId', $reqId);
//    $statement->bindValue(':reqDate', $reqDate);
//    $statement->bindValue(':roomNumber', $roomNumber);
//    $statement->bindValue(':reqBy',$reqBy);
//    $statement->bindValue(':repairDesc', $repairDesc);
//    $statement->bindValue(':reqPriority', $reqPriority);

//    $statement->execute();
//    $statement->closeCursor();



// }

// function deleteRequest($reqId)
// {
//    global $db;

//    $query = "delete from requests where reqId=:reqId";

//    $statement = $db->prepare($query);
//    $statement->bindValue(':reqId', $reqId);

//    $statement->execute();
//    $statement->closeCursor();
    
// }




?>
