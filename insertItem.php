<!doctype html>

<?php

require_once("generate.php");
require_once("profile.php");

if (!isset($_SESSION)) {
    session_start();
}

#check to make sure logged in correctly, if not send to login page

if (!isset($_SESSION["username"]) || !isset($_SESSION["password"])) {
    header("Location: login.php");
} else {
    $username = $_SESSION['username'];
    $passwordValue = $_SESSION['password'];
    $temp = new Profile("", "", []);
    $profile = $temp->find_profile_on_db($username);
    if ($profile == null) { #couldnt find the username on the db
        header("Location: login.php");
    }
    $password_encrypted = $profile->get_password();
    if (!password_verify($passwordValue, $password_encrypted)) { #password was wrong
        header("Location: login.php");
    }
}
$username = $_SESSION['username'];
$passwordValue = $_SESSION['password'];

function connectToDB($host, $user, $password, $database) {
	$db_connection = new mysqli($host, $user, $password, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	} else {
	        return $db_connection;
	}
}  

#check to make sure logged in correctly, if not send to login page

?>

<html>

  <head>
    <title>Edit Inventory</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
   
  </head>
  
  <body>    
    <div class = "header" style="margin:10px">
      <p><img src="mainImg.jpg" alt="Yellow swap Arrows" height='100' width='110'>
      <h1>&nbspEdit Inventory</h1></p>
    </div>
    <div class = "container-fluid">

    <?php 
    $host = "localhost";
	  $user = "swapadmin";
	  $password = "password";
	  $database = "swapbase";
	  $table = "items";
	
	  $db = connectToDB($host, $user, $password, $database);
	
	  $sql = "SELECT `image`, `name`, `description`, `value` FROM `items` WHERE `user-key` = '".$username."'";
	
	  $result = mysqli_query($db, $sql);	
          $row_count=mysqli_num_rows($result);
          
				echo("<table class = table table-bordered>");
				echo("<tr><th>Image</th><th>Name</th><th>Description</th><th>Value</th></tr>");
				for($i =0; $i < $row_count; $i++){
				  $result->data_seek($i);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          
          
          echo("<tr><td>");
          
          echo("<img alt='product image' height='110' src='data:image/jpeg;base64,".$row['image']."'></td>");
          
          echo("<td>".($row['name'])."</td><td>".($row['description'])."</td><td>".($row['value'])."</td></tr>");
				}  
        echo("</table>");

        //Chris' code which appends an error to the insertion page if the name of an item
        //a user is trying to insert already exists in the db
        if (isset($_SESSION['name_exists']) && $_SESSION['name_exists'] == true){
          echo "Item with that name already exists in the database!";
          $_SESSION['name_exists'] = false; //reset the variable
        }
    ?>
    </div>
    
    <div class = "container-fluid" >

      <form id="insert_form" action="inserted.php" method = "POST" >
      
           <div class="btn btn-warning btn-sm float-left">
             <span>Upload File</span>
             <input id="file" type="file" name = "file" required>
           </div>
         <br/><br/>
         
         <input type = "text" name = "name" class="form-control" placeholder = "Item-Name" required><br/>
         
         <!--Need a custom error message when pattern doesn't match. Having it in the page looks tacky-->
         <em>Description cannot cannot contain any special characters. Must be within 140 characters and not contain +-!@#$%&</em>
         <input type = "text" name = "desc" class="form-control" placeholder = "Description" pattern= "[\w\s]+"
          min="1" max="140" required></br>
        
         <input type = "number" name = "value" class="form-control" placeholder = "Value" min="1" max="500000"
         required><br/>
      
         <input type="submit" value="Submit" class="btn btn-warning" style = "width:40%">
         
      </form>
      <form action="landing.php"">
         <input type="submit" value="Return to Main Menu" class="btn btn-warning" style = "width:40%; margin-top:5px">
      </form>
    </div>
    
    <div class = "container-fluid">
      <hr>
      <p>If you have any questions about Swap, please contact the system administrator at <a href="mailto:admin@swap.com">admin@swap.com</a></p>
    </div>

    <script src = "validation.js"></script>
    
  </body>
</html>

<style>
.header img {
  float: left;
  width: 100px;
  clear: right;

}
.header h1 {
  position: relative;
  top: 15px;
  left: 10px;
  padding-bottom: 60px;

}


</style>

