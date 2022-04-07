<?php session_start(); ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Ratings</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="stylesheet.css">
      <script src="https://kit.fontawesome.com/d688da91fc.js" crossorigin="anonymous"></script>
	  <?PHP

//Assignment Link
define("SERVER_NAME","novio-dev-1.cptgeqlvlgbo.us-east-1.rds.amazonaws.com");
define("DBF_rating_NAME", "cspuser");
define("DBF_PASSWORD", "admin.csp1");
define("DATABASE_NAME", "Newzeen");


$thisrating = unserialize(urldecode($_SESSION['sessionThisRating']));
// Create connection object
$conn = NULL;
createConnection();
if(isset($_POST['select'])) // Selecting Dropdown
{	$ratingID = $_POST['select'];
    $sql = "SELECT * FROM Newzeen.rating WHERE rating_id = ".$ratingID.";" ;    
           if($stmt = $conn->prepare($sql)) {
              // Pass the parameters
              //6$stmt->bind_param("i", $idRunner);
              if($stmt->errno) {
                displayMessage("stmt prepare( ) had error.", "red" ); 
              }
              
               // Execute the query
               $stmt->execute();
               if($stmt->errno) {
                 displayMessage("Could not execute prepared statement", "red" );
               }
                                
               // Optional - Download all the rows into a cache
               // When fetch( ) is called all the records will be downloaded
               $stmt->store_result( );
                                
               // Get number of rows 
               //(only good if store_result( ) is used first)
               $rowCount = $stmt->num_rows;
                                
               // Bind result variables
               // one variable for each field in the SELECT
               // This is the variable that fetch( ) will use to store the result
               $stmt->bind_result($ratingID, $listingID, $userID, $starRating, $reviewTitle, $review,);
               
               // Fetch the value - returns the next row in the result set
               while($stmt->fetch( )) {
               }
               
               // Free results
               $stmt->free_result( );
               
               // Close the statement
               $stmt->close( );
                 
            } // end if( prepare( ))
               
	$thisRating = [
        "rating_id" => $ratingID,
        "listing_id" => $listingID,
        "user_id" => $userID,
		"star_rating" => $starRating,
        "review_title" => $reviewTitle,
        "review"=> $review
    ];
	
	$_SESSION['sessionThisRating'] = urlencode(serialize($thisRating));

}
if(isset($_POST['new'])) // when click on Update button
{
$sql= "call createRating(".$_POST['listing'].",'" .$_POST['user']."','" .$_POST['txtStarRating']."','".$_POST['txtReviewTitle']."','".$_POST['txtReview']."');";
echo "<h2>".$sql."</h2>";
$result = $conn->query($sql);
}
if(isset($_POST['update'])) // when click on Update button
{
$email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
$sql= "call updateRating(".$ratingID.",'" .$_POST['listing']."','" .$_POST['user']."','" .$_POST['txtStarRating']."','".$_POST['txtReviewTitle']."','".$_POST['txtReview']."');";

echo "<h2>".$sql."</h2>";
$sql=htmlentities($sql);
$result = $conn->query($sql);
if($result) {
    $isSuccessful = true;
 }

}
if(isset($_POST['delete'])) // when click on Update button
{
$sql= "call deleteRating(".$ratingID.")";
$result = $conn->query($sql);
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * displayrating( ) - Display the projectReport
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function displayRatingTable( ) {
   global $conn;
   $sql = "SELECT rating.rating_id as 'Rating ID',
		listing.listing_name as 'Listing Name',
        user.username as 'Username',
        rating.star_rating as 'Star Rating',
        rating.review_title as 'Review Title',
        rating.review as 'Review'
						FROM Newzeen.rating
						JOIN Newzeen.listing ON (rating.listing_id = listing.listing_id) 
                        JOIN Newzeen.user ON (rating.user_id = user.user_id);";
   $result = $conn->query($sql);
   displayResult($result, $sql);
}
 
/********************************************
 * displayResult( ) - Execute a query and display the result
 * Parameters: $rs  - Result set to display as 2D array
 *             $sql - SQL string used to display an error msg
 ********************************************/
function displayResult($result, $sql) {
	
    if ($result->num_rows > 0) {
       echo "<table border='1'>\n";
        // print headings (field names)
        $heading = $result->fetch_assoc( );
        echo "<tr>\n";
	
        // Print field names as table headings
        foreach($heading as $key=>$value){	
            echo "<th>" . $key . "</th>\n";
        }
        echo "</tr>";
        // Print the values for the first row
        echo "<tr>";
	
		foreach($heading as $key=>$value){
				echo "<td>" . $value . "</td>\n";
        }

        // output rest of the records
        while($row = $result->fetch_assoc()) {
            //print_r($row);
            //echo "<br />";
            echo "<tr>\n";
            // print data
			$count = 0;
            foreach($row as $key=>$value) {
				
				echo "<td>".$value . "</td>\n";
				
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    // No results
    } else {
       echo "<strong>zero results using SQL: </strong>" . $sql;
    } 
   
} // end of displayResult( )
function createConnection( ) {
   global $conn;
   // Create connection object
   $conn = new mysqli(SERVER_NAME, DBF_rating_NAME, DBF_PASSWORD);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
   // Select the database
   $conn->select_db(DATABASE_NAME);
} // end of createConnection( )

/********************************************
 * runQuery( ) - Execute a query and display message
 *    Parameters:  $sql         -  SQL String to be executed.
 *                 $msg         -  Text of message to display on success or error
 *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
 *                 $echoSuccess - boolean True=Display message on success
 ********************************************/
function runQuery($sql, $msg, $echoSuccess) {
   global $conn;
    
   // run the query
   if ($conn->query($sql) === TRUE) {
      if($echoSuccess) {
         echo $msg . " successful.<br />";
      }
   } else {
      echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
   }   
} // end of runQuery( ) 

// Close the database

?>
   </head>
   <body>
      <header>
         <!-- begin nav menu -->
         <div class="navbar">
			<a><button type="submit"><i class="fa fa-search"></i></button></a>
            <a style="float: right"><input type="text" placeholder="Search..."></a>
			<a href="account.html">Account</a>
			<a href="contact.html">Contact</a>
			<a href="about.html">About</a>
            <a href="store.html">Store</a>
            <a href="index.html">Home</a>
            <a style="float: left" id="title">NewZeen</a>
            <!-- end nav menu -->
         </div>
      </header>
      <!-- begin left sidebar -->
      <section id="left-side">
		<div class = "admin-title">
         <p id>Admin Interface</p>
		 </div>
         <div class="left-menu">
            <a href="Users.php">Users</a>
            <br><br>
            <a href="vendors.php">Vendors</a>
            <br><br>
            <a href="listings.php">Listings</a>
            <br><br>
            <a href="ratings.php">Ratings</a>
         </div>
      </section>
      <!-- end left sidebar -->
      
	         <section id="blank-space">
      </section>
  
      <section id="about">
        <h1>Admin Ratings Interface</h1>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
			method="POST"
			name="ratingRegistration"
			id="ratingRegistration">
			<fieldset>
				<legend>Rating's Information</legend>
			<div class="topLabel">

			<label for="rating">Rating ID</label>
			<select name="select" id="select" onChange="this.form.submit();">
					<option value = "ratingSelect">Select a Rating ID</option>
					<?PHP
					$sql = "SELECT rating.rating_id as 'rating_id'
						FROM Newzeen.rating;";
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()) {    
						echo "<option value='" . $row['rating_id'] . "'>" . $row['rating_id'] . "</option>\n";
					}
					?>
			</select> 
  
		</div>

	<div class="topLabel">
        <label for="listing">Listing</label>
			<select name="listing" id="listing">
				<option value = "listingSelect">Select a Listing</option>
				<?PHP
				$sql = "SELECT listing.listing_id as 'listing_id',
						listing.listing_name as 'listing_name'
						FROM Newzeen.listing;";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {    
					echo "<option value='" . $row['listing_id'] . "'>" . $row['listing_name']."</option>\n";
				}
				?>
			</select> 
    </div>
	
   	<div class="topLabel">
        <label for="user">Username</label>
			<select name="user" id="user">
				<?PHP
				$sql = "SELECT user.user_id as 'user_id',
						user.username as 'username'
						FROM Newzeen.user;";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {    
					echo "<option value='" . $row['user_id'] . "'>" . $row['username']."</option>\n";
				}
				?>
			</select> 
    </div>
	<div class="topLabel">
        <label for="txtStarRating">Star Rating</label>
        <input type="text" name="txtStarRating"   id="txtStarRating"   value="<?php echo $thisRating['star_rating']; ?>" />
  
	</div>
	
	<div class="topLabel">
        <label for="txtReviewTitle">Review Title</label>
        <input type="text" name="txtReviewTitle"   id="txtReviewTitle"   value="<?php echo $thisRating['review_title']; ?>" />
  
	</div>
	<div class="topLabel">
        <label for="txtReview">Review</label>
        <input type="text" name="txtReview"   id="txtReview"  value="<?php echo $thisRating['review']; ?>" />
    </div>
	
	
	 </fieldset>

<div id="crudButtons"> 
	<button name="new"    
           value="new"  
           onclick="this.form.submit();">
           Create
   </button>
   <br>      
	<br>
	<button name="update" 
           value="update" 
           onclick="this.form.submit();">
           Update
	</button>
    <br>      
	<br>
   <button name="delete" 
           value="delete"
           onclick="this.form.submit();">
           Delete
   </button>
    <br/>
    <br/>
</div>
   
</form>
<?php
displayRatingTable();
?>
<script>
    // Populate the drop-down box with current value
    document.getElementById("select").value = "<?PHP echo $thisRating['rating_id']; ?>";
    document.getElementById("listing").value = "<?PHP echo $thisRating['listing_id']; ?>";
    document.getElementById("user").value = "<?PHP echo $thisRating['user_id']; ?>"
</script>
      </section>
      <section id="misc">
         <p>----------</p>
      </section>
      <footer>
         <p>&copy; hollandc@csp.edu 2022</p>
         <p>All images used with permission from https://www.pexels.com/
      </footer>
   </body>
</html>
© 2022 GitHub, Inc.
Terms
Privacy
Security
Status
Docs
Contact GitHub
Pricing
API
Training
Blog
About
Loading complete