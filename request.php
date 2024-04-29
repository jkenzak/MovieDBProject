<?php 
require("connect-db.php");    // include("connect-db.php");
require("request-db.php");
?>


<?php 

session_start();

$list_of_movies = getAllMovies();

$add_form = False;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['addBtn']))
  {
      addReview($_POST['MovieID'], $_POST['userID'], $_POST['comment'], $_POST['rating'], $_POST['Date']);
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
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
      deleteReview($_POST['ReviewID'], $_POST['userID']);
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
      $list_of_movies = getAllMovies();
  }

  //Update Review Button
  else if (!empty($_POST['updateReviewBtn']))
  {
      $update_form = $_POST['update'];
  }

  else if (!empty($_POST['cofmBtn']))
  {
    updateReview($_POST['ReviewID'], $_POST['MovieID'], $_POST['comment'], $_POST['rating'], $_POST['Date']);
    $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
    $review_movie_id = $_POST['MovieID'];
    $list_of_movies = getAllMovies();
  }


  //Function to organize movies by rating
  else if (!empty($_POST['sortRatingBtn']))
  {
      $list_of_movies = getMoviesByRating();
  }

  else if (!empty($_POST['searchBtn']))
  {
      $list_of_movies = searchMovie($_POST['searchfor']);
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
  
 
<?php if($add_form or $update_form): ?>
  <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" onsubmit="return validateInput()">
    <table style="width:98%">
      <tr>
        <td colspan=2>
          <div class='mb-3'>
            Comment 
            <input type='text' class='form-control' id='comment' name='comment'
                   placeholder='Enter your comment'
                   value="<?php if($update_form){echo $_POST['Comment'];} ?>" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class="mb-3">
            <!-- Rating
            <input type='text' class='form-control' id='rating' name='rating'
            value="" /> -->
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" selected="<?php if($update_form){echo $_POST['rating'];} ?>">
              <option value=10>10</option>
              <option value=9.75>9.75</option>
              <option value=9.5>9.5</option>
              <option value=9.25>9.25</option>
              <option value=9>9.0</option>
              <option value=8.75>8.75</option>
              <option value=8.5>8.5</option>
              <option value=8.25>8.25</option>
              <option value=8.0>8.0</option>
              <option value=7.75>7.75</option>
              <option value=7.5>7.5</option>
              <option value=7.25>7.25</option>
              <option value=7>7.0</option>
              <option value=6.75>6.75</option>
              <option value=6.5>6.5</option>
              <option value=6.25>6.25</option>
              <option value=6.0>6.0</option>
              <option value=5.75>5.75</option>
              <option value=5.5>5.5</option>
              <option value=5.25>5.25</option>
              <option value=5>5.0</option>
              <option value=4.75>4.75</option>
              <option value=4.5>4.5</option>
              <option value=4.25>4.25</option>
              <option value=4>4.0</option>
              <option value=3.75>3.75</option>
              <option value=3.5>3.5</option>
              <option value=3.25>3.25</option>
              <option value=3>3.0</option>
              <option value=2.75>2.75</option>
              <option value=2.5>2.5</option>
              <option value=2.25>2.25</option>
              <option value=2>2.0</option>
              <option value=1.75>1.75</option>
              <option value=1.5>1.5</option>
              <option value=1.25>1.25</option>
              <option value=1>1.0</option>
              <option value=0.75>0.75</option>
              <option value=0.5>0.5</option>
              <option value=0.25>0.25</option>
              <option value=0>0</option>

        </div>
        </td>
      </tr>
    </table>

    <div class="row g-3 mx-auto">    
      <div class="col-4 d-grid ">
      <input type="submit" value="Add" id="addBtn" name="addBtn" class="btn btn-dark"
           title="Submit new review" />
      <input type="hidden" name="MovieID" value="<?php echo $_POST['MovieID']; ?>" /> 
      <input type="hidden" name="Date" value="<?php date_default_timezone_set("America/New_York"); echo date("Y-m-d"); ?>" />                  
      <input type="hidden" name="userID" value="<?php echo $_SESSION['id'] ?>" />
      </div>	    
      <div class="col-4 d-grid ">
      <?php if($update_form): ?>
        <input type="hidden" name="ReviewID" value="<?php echo $_POST['ReviewID'] ?>" />
        <input type="hidden" name="movieID" value="<?php echo $_POST['movieID']; ?>" /> 
        <input type="hidden" name="Date" value="<?php date_default_timezone_set("America/New_York"); echo date("Y-m-d"); ?>" />                  
        <input type="hidden" name="userID" value="<?php echo $_SESSION['id'] ?>" />
      <?php endif; ?>
      <input type="submit" value="Confirm update" id="cofmBtn" name="cofmBtn" class="btn btn-primary"
           title="Update review" />         
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
  <table class="w3-table center" style="width:100%">
    <tr>
      <td>
        <form action="request.php" method="post">
          <input type="text" name="searchfor" style="width:500px" />
          <input type="hidden" name="searchBtn" value="1" />
          <input type="submit" value="Search" class="btn btn-primary"/>
        </form>
      </td>
      <td>
        <form action="request.php" method="post">
          <input type="hidden" name="sortRatingBtn" value="1">
          <input type="submit" value="Sort by Ratings" class="btn btn-primary">
        </form>
      </td>
   </table>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th><b>Title</b></th>
    <th><b>Genre</b></th>        
    <th><b>Release Date</b></th> 
    <th><b>Runtime</b></th>
    <th><b>Average Rating</b></th>        
    <th><b>Reviews</b></th> 
    <th></th>
  </tr>
  </thead>
  <?php foreach ($list_of_movies as $movie_info): ?>
  <tr>
     <td><?php echo $movie_info['Title']; ?></td>        
     <td><?php foreach (getGenre($movie_info['MovieID']) as $r){echo $r[0];} ?></td>
     <td><?php echo $movie_info['ReleaseDate']; ?></td>
     <td><?php echo $movie_info['Runtime']; echo " min" ?></td>   
     <?php if(is_null($movie_info['AvgRating'])): ?>
        <td>N/A</td>
     <?php else: ?>     
        <td><?php echo round($movie_info['AvgRating'], 2); ?></td> 
     <?php endif; ?>              
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
          <?php if($_SESSION['id']): ?> 
            <input type="submit" value="ADD" name="movieaddBtn" 
                  class="btn btn-success" />
          <?php else: ?>
            <input type="submit" value="ADD" name="movieaddBtn" 
                  class="btn btn-success" disabled/>
          <?php endif;?>
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
          <td>
            <form action="request.php" method="post"> 
              <input type="hidden" name="Comment" value="<?php echo $review_info['Comment']; ?>" />
              <input type="hidden" name="ReviewID" value="<?php echo $review_info['ReviewID']; ?>" /> 
              <input type="hidden" name="movieID" value="<?php echo $review_info['MovieID']; ?>" />
              <input type="hidden" name="rating" value="<?php echo $review_info['Rating']; ?>" />
              <input type="hidden" name="date" value="<?php echo $review_info['ReviewDate']; ?>" />
              <input type="hidden" name="update" value=1 />
              <?php if($_SESSION['id']): ?>
                <input type="submit" value="Update Review" id="updateReviewBtn" name="updateReviewBtn" class="btn btn-warning" />
              <?php else: ?>
                <input type="submit" value="Update Review" id="updateReviewBtn" name="updateReviewBtn" class="btn btn-warning" disabled/>
              <?php endif; ?>
              </form>
          </td>
          <td>
            <form action="request.php" method="post">
              <?php if($_SESSION['id']): ?> 
                <input type="submit" value="Delete Review" id="deleteReviewBtn" name="deleteReviewBtn" class="btn btn-danger" />
              <?php else: ?>
                <input type="submit" value="Delete Review" id="deleteReviewBtn" name="deleteReviewBtn" class="btn btn-danger" disabled/>
              <?php endif; ?>
                <input type="hidden" name="ReviewID" value="<?php echo $review_info['ReviewID']; ?>" /> 
            </form>
          </td>
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
