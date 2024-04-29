<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'request.php';
      break; 
   case '/request.php':     // if you plan to also allow a URL with the file name 
      require 'request.php';
      break;              
   case '/login.php':
      require 'login.php';
      break;
   case '/signup.php':
        require 'signup.php';
        break;
   case '/signout.php':
        require 'signout.php';
        break;
   case '/login.html':
         require 'login.html';
         break;
   case '/authenticate.php':
         require 'authenticate.php';
         break;
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>