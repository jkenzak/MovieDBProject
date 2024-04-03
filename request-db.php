<?php
// function addRequests($reqDate, $roomNumber, $reqBy, $repairDesc, $reqPriority)
// {
//    global $db;   
//    $reqDate = date('Y-m-d');
      
//    $query = "INSERT INTO requests (reqDate, roomNumber, reqBy, repairDesc, reqPriority) VALUES (:reqDate, :roomNumber, :reqBy, :repairDesc, :reqPriority)";  
   
//    try { 

//       // prepared statement
//       // pre-compile
//       $statement = $db->prepare($query);

//       // fill in the value
//       $statement->bindValue(':reqDate', $reqDate);
//       $statement->bindValue(':roomNumber', $roomNumber);
//       $statement->bindValue(':reqBy',$reqBy);
//       $statement->bindValue(':repairDesc', $repairDesc);
//       $statement->bindValue(':reqPriority', $reqPriority);

//       // exe
//       $statement->execute();
//       $statement->closeCursor();
//    } catch (PDOException $e)
//    {
//       $e->getMessage();
//    } catch (Exception $e) 
//    {
//       $e->getMessage();
//    }

// }

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
