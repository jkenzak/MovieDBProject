<?php 
require("connect-db.php");    // include("connect-db.php");
require("request-db.php");
?>


<?php 

$list_of_movies = getAllMovies();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  // if (!empty($_POST['addBtn']))
  // {
  //     addRequests($_POST['requestedDate'], $_POST['roomNo'], $_POST['requestedBy'], $_POST['requestDesc'], $_POST['priority_option']);
  //     $list_of_requests = getAllRequests();
  // }
  if (!empty($_POST['updateBtn']))
  {  
      $list_of_reviews = getReviewsByMovieId($_POST['MovieID']);
      $review_movie_id = $_POST['MovieID'];
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

<!-- <div class="container">
  <div class="row g-3 mt-2">
    <div class="col">
      <h2>Maintenance Request</h2>
    </div>  
  </div>
  
 

  <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" onsubmit="return validateInput()">
    <table style="width:98%">
      <tr>
        <td width="50%">
          <div class='mb-3'>
            Requested date:
            <input type='text' class='form-control' 
                   id='requestedDate' name='requestedDate' 
                   placeholder='Format: yyyy-mm-dd' 
                   pattern="\d{4}-\d{1,2}-\d{1,2}" 
                   value="<?php if ($request_to_update != null && $clear != True) echo $request_to_update['reqDate'] ?>" />
          </div>
        </td>
        <td>
          <div class='mb-3'>
            Room Number:
            <input type='text' class='form-control' id='roomNo' name='roomNo' 
            value="<?php if ($request_to_update != null) echo $request_to_update['roomNumber'] ?>" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class='mb-3'>
            Requested by: 
            <input type='text' class='form-control' id='requestedBy' name='requestedBy'
                   placeholder='Enter your name'
                   value="<?php if ($request_to_update != null) echo $request_to_update['reqBy'] ?>" />
          </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class="mb-3">
            Description of work/repair:
            <input type='text' class='form-control' id='requestDesc' name='requestDesc'
            value="<?php if ($request_to_update != null) echo $request_to_update['repairDesc'] ?>" />
        </div>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <div class='mb-3'>
            Requested Priority:
            <select class='form-select' id='priority_option' name='priority_option'>
              <option selected></option>
              <option value='high' <?php if ($request_to_update!=null && $request_to_update['reqPriority']=='high') echo ' selected="selected"' ?> >
                High - Must be done within 24 hours</option>
              <option value='medium' <?php if ($request_to_update!=null && $request_to_update['reqPriority']=='medium') echo ' selected="selected"' ?> >
                Medium - Within a week</option>
              <option value='low' <?php if ($request_to_update!=null && $request_to_update['reqPriority']=='low') echo ' selected="selected"' ?> >
                Low - When you get a chance</option>
            </select>
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

</div> -->


<!-- <hr/> -->
<div class="container">
<h3>List of requests</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th><b>ReqID</b></th>
    <th><b>Date</b></th>        
    <th><b>Room#</b></th> 
    <th><b>By</b></th>
    <th><b>Description</b></th>        
    <th><b>Priority</b></th> 
    <th><b>Update?</b></th>
    <th><b>Delete?</b></th>
  </tr>
  </thead>
  <?php foreach ($list_of_movies as $movie_info): ?>
  <tr>
     <td><?php echo $movie_info['MovieID']; ?></td>
     <td><?php echo $movie_info['Title']; ?></td>        
     <td><?php echo $movie_info['Genre']; ?></td>          
     <td><?php echo $movie_info['ReleaseDate']; ?></td>
     <td><?php echo $movie_info['Runtime']; ?></td>        
     <td><?php echo $movie_info['AvgRating']; ?></td>               
     <td>
       <form action="request.php" method="post"> 
          <input type="submit" value="Update" name="updateBtn" 
                 class="btn btn-primary" /> 
          <input type="hidden" name="MovieID" 
                 value="<?php echo $movie_info['MovieID']; ?>" /> 
       </form>
     </td>
     <td>
       <form action="request.php" method="post"> 
          <input type="submit" value="Delete" name="deleteBtn" 
                 class="btn btn-danger" /> 
          <input type="hidden" name="reqId" 
                 value="<?php echo $movie_info['MovieID']; ?>" /> 
       </form>
     </td>
  </tr>
  <?php if($list_of_reviews!=null && $review_movie_id==$movie_info['MovieID']): ?>
      <?php foreach ($list_of_reviews as $review_info): ?>
        <tr>
          <td><?php echo $review_info['ReviewID']; ?></td>
          <td><?php echo $review_info['MovieID']; ?></td>        
          <td><?php echo $review_info['UserID']; ?></td>          
          <td><?php echo $review_info['Comment']; ?></td>
          <td><?php echo $review_info['Rating']; ?></td>        
          <td><?php echo $review_info['ReviewDate']; ?></td> 
        </tr>
      <?php endforeach; ?>
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