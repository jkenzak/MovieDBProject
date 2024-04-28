<?php 
require("connect-db.php");    // include("connect-db.php");
require("request-db.php");
?>


<?php 

$list_of_movies = getAllMovies();
$add_form = False;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['addBtn']))
  {
      addReview($_POST['movieID'], $_POST['userID'], $_POST['comment'], $_POST['rating'], $_POST['date']);
      $list_of_reviews = getReviewsByMovieId($_POST['movieID']);
      $review_movie_id = $_POST['movieID'];
      $list_of_movies = getAllMovies();
  }
  else if (!empty($_POST['viewBtn']))
  {  
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
  }
  else if (!empty($_POST['movieaddBtn']))
  {
    $add_form = True;
  }

  //Delete Review Button
  else if (!empty($_POST['deleteReviewBtn']))
  {
      deleteReview($_POST['ReviewID']);
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
      $list_of_movies = getAllMovies();
  }

  //Update Review Button
  else if (!empty($_POST['updateReviewBtn']))
  {
      updateReview($_POST['ReviewID'], $_POST['movieID'], $_POST['userID'], $_POST['comment'], $_POST['rating'], $_POST['date']);
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
      $list_of_movies = getAllMovies();
  }


  // else if (!empty($_POST['cofmBtn']))
  // {
  //    updateRequest($_POST['cofm_reqId'], $_POST['requestedDate'], $_POST['roomNo'], $_POST['requestedBy'], $_POST['requestDesc'], $_POST['priority_option']); 
  //    $list_of_requests = getAllRequests();
  // }
  // else if (!empty($_POST['deleteBtn']))
  // {
  //     deleteRequest($_POST['reqId']);
  //     $list_of_requests = getAllRequests();
  // }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">    
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Upsorn Praphamontripong">
  <meta name="description" content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
  <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
  <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <title>Maintenance Services</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="maintenance-system.css">  
</head>

<body>  
<?php include("header.php"); ?>

<div class="container">
  <div class="row g-3 mt-2">
    <div class="col">
      <h2>Movie Reviews</h2>
    </div>  
  </div>
  
 
<?php if($add_form): ?>
  <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" onsubmit="return validateInput()">
    <table style="width:98%">
      <tr>
        <td width="50%">
          <div class='mb-3'>
            Movie ID
            <input type='text' class='form-control' 
                   id='movieID' name='movieID' 
                   placeholder='' 
                   value="" />
          </div>
        </td>
        <td>
          <div class='mb-3'>
            User ID
            <input type='text' class='form-control' id='userID' name='userID' 
            value="" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class='mb-3'>
            Comment 
            <input type='text' class='form-control' id='comment' name='comment'
                   placeholder='Enter your comment'
                   value="" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class="mb-3">
            Rating
            <input type='text' class='form-control' id='rating' name='rating'
            value="" />
        </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class='mb-3'>
            Date
            <input type='text' class='form-control' id='date' name='date'
            value="" />
          </div>
        </td>
      </tr>
    </table>

    <div class="row g-3 mx-auto">    
      <div class="col-4 d-grid ">
      <input type="submit" value="Add" id="addBtn" name="addBtn" class="btn btn-dark"
           title="Submit a maintenance request" />                  
      </div>	    
      <div class="col-4 d-grid ">
      <input type="submit" value="Confirm update" id="cofmBtn" name="cofmBtn" class="btn btn-primary"
           title="Update a maintenance request" />      
      <input type="hidden" value="<?= $_POST['reqId'] ?>" name="cofm_reqId" />      
      </div>	    
      <div class="col-4 d-grid">
        <input type="reset" value="Clear form" name="clearBtn" id="clearBtn" class="btn btn-secondary" />
      </div>      
    </div>  
    <div>
  </div>  
</form>
<?php endif; ?>
</div>


<!-- <hr/> -->
<div class="container">
<h3>Movie List</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th><b>Movie ID</b></th>
    <th><b>Title</b></th>        
    <th><b>Release Date</b></th> 
    <th><b>Runtime</b></th>
    <th><b>Average Rating</b></th>        
    <th><b>Reviews</b></th> 
    <th></th>
  </tr>
  </thead>
  <?php foreach ($list_of_movies as $movie_info): ?>
  <tr>
     <td><?php echo $movie_info['MovieID']; ?></td>
     <td><?php echo $movie_info['Title']; ?></td>        
     <!-- <td><?php echo $movie_info['Genre']; ?></td>           -->
     <td><?php echo $movie_info['ReleaseDate']; ?></td>
     <td><?php echo $movie_info['Runtime']; ?></td>        
     <td><?php echo $movie_info['AvgRating']; ?></td>               
     <td>
       <form action="request.php" method="post"> 
          <input type="submit" value="View" name="viewBtn" 
                 class="btn btn-primary" /> 
          <input type="hidden" name="MovieID" 
                 value="<?php echo $movie_info['MovieID']; ?>" /> 
       </form>
     </td>
     <td>
       <form action="request.php" method="post"> 
          <input type="submit" value="ADD" name="movieaddBtn" 
                 class="btn btn-success" /> 
          <input type="hidden" name="MovieID" 
                 value="<?php echo $movie_info['MovieID']; ?>" /> 
       </form>
     </td>
  </tr>
  <?php if($list_of_reviews!=null && $review_movie_id==$movie_info['MovieID']): ?>
    <thead>
      <tr style="background-color:#D6D6D7">
        <th><b>Author Name</b></th>
        <th><b>Type</b></th>        
        <th><b>Publisher</b></th> 
        <th><b>Comment</b></th>
        <th><b>Rating</b></th>        
        <th><b>Date</b></th>
        <th></th> 
      </tr>
    </thead>
      <?php foreach ($list_of_reviews as $review_info): ?>
        <tr>
          <td><?php echo findAuthorName($review_info['ReviewID'], $review_info['UserID']); ?></td>
          <?php $usertype = getUserType($review_info['ReviewID']); ?>
          <?php if($usertype): ?>
            <td>Critic</td>
            <td><?php echo getPublisher($review_info['UserID']); ?></td>
          <?php else: ?>
            <td>User</td>
            <td>N/A</td>
          <?php endif; ?>                
          <td><?php echo $review_info['Comment']; ?></td>
          <td><?php echo $review_info['Rating']; ?></td>        
          <td><?php echo $review_info['ReviewDate']; ?></td> 
        </tr>
      <?php endforeach; ?>
      <tr style="background-color:#D6D6D7">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
  <?php endif; ?>
<?php endforeach; ?>  

</table>
</div>   


<br/><br/>

<?php // include('footer.html') ?> 

<!-- <script src='maintenance-system.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>