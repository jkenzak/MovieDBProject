<?php
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
function deleteReview($reviewID) {
   global $db;

   $query = "DELETE FROM Review WHERE ReviewID = :reviewID";
   $statement = $db->prepare($query);
   $statement->bindValue(':reviewID', $reviewID);
   $statement->execute();
   $statement->closeCursor();
}

//update review
function updateReview($reviewID, $movieID, $userID, $comment, $rating, $date) {
    global $db;
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
       $user = $statement->fetch(PDO::FETCH_ASSOC);
       $statement->closeCursor();

       if ($user && password_verify($password, $user['Password'])) {
           if (!isset($_SESSION['loggedin'])) {  // Check if session has already been started
               session_start();
           }
           $_SESSION['loggedin'] = true;
           $_SESSION['username'] = $username;
           return true;
       } else {
           return false; // If password doesn't match or user doesn't exist
       }
   } catch (PDOException $e) {
       echo 'PDOException: ' . $e->getMessage();
       return false;
   }
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