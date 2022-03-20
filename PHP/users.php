<?php session_start(); ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Users</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css">
      <script src="https://kit.fontawesome.com/d688da91fc.js" crossorigin="anonymous"></script>
	  <?PHP

//Assignment Link
define("SERVER_NAME","novio-dev-1.cptgeqlvlgbo.us-east-1.rds.amazonaws.com");
define("DBF_USER_NAME", "cspuser");
define("DBF_PASSWORD", "admin.csp1");
define("DATABASE_NAME", "Newzeen");


$thisUser = unserialize(urldecode($_SESSION['sessionThisUser']));
// Create connection object
$conn = NULL;
createConnection();
if(isset($_POST['select'])) // Selecting Dropdown
{	$userID = $_POST['select'];
    $sql = "SELECT * FROM Newzeen.user WHERE user_id = ".$userID.";" ;    
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
               $stmt->bind_result($userID, $email, $username,$password, $firstName, $lastName, $address);
               
               // Fetch the value - returns the next row in the result set
               while($stmt->fetch( )) {
               }
               
               // Free results
               $stmt->free_result( );
               
               // Close the statement
               $stmt->close( );
                 
            } // end if( prepare( ))
               
	$thisUser = [
        "user_id" => $userID,
        "email" => $email,
        "username" => $username,
		"password" => $password,
        "firstName" => $firstName,
        "lastName"=> $lastName,
		"address"=>	$address
    ];
	
	$_SESSION['sessionThisUser'] = urlencode(serialize($thisUser));

}
if(isset($_POST['new'])) // when click on Update button
{
$sql= "call createUser('".$_POST['txtEmail']."','" .$_POST['txtUsername']."','".$_POST['txtPassword']."','".$_POST['txtFirstName']."','".$_POST['txtLastName']."','".$_POST['txtAddress']."');" ;	
$result = $conn->query($sql);
}
if(isset($_POST['update'])) // when click on Update button
{
$email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
$sql= "call updateUser(".$userID.",'" .$_POST['txtEmail']."','" .$_POST['txtUsername']."','".$_POST['txtPassword']."','".$_POST['txtFirstName']."','".$_POST['txtLastName']."','".$_POST['txtAddress']."');";

echo "<h2>".$sql."</h2>";
$sql=htmlentities($sql);
$result = $conn->query($sql);
if($result) {
    $isSuccessful = true;
 }

}
if(isset($_POST['delete'])) // when click on Update button
{
$sql= "call deleteUser(".$userID.")";
$result = $conn->query($sql);
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * displayUser( ) - Display the projectReport
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function displayUserTable( ) {
   global $conn;
   $sql = "SELECT * FROM Newzeen.user;";
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
   $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
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
            <a href="users.php">Users</a>
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
        <h1>Admin User Interface</h1>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
			method="POST"
			name="userRegistration"
			id="userRegistration">
		<label for="user"><strong>Select Username</strong></label>

		<select name="select" id="select" onChange="this.form.submit();">
			<option value = "userSelect">Select an Username</option>
			<?PHP
				// Loop through the runner table to build the <option> list
				$sql = "SELECT 
				user.username AS 'username' ,
				user.user_id AS 'id'
				FROM Newzeen.user;";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {    
                echo "<option value=".$row['id'].">" . $row['username'] . "</option>\n";
				}
			?>
		</select> 
		<br />
		<br />
   
	<fieldset>
      <legend>User's Information</legend>
	<div class="topLabel">
        <label for="txtEmail">Email</label>
        <input type="text" name="txtEmail"   id="txtEmail"   value="<?php echo $thisUser['email']; ?>" />
  
	</div>
		<div class="topLabel">
        <label for="txtUsername">Username</label>
        <input type="text" name="txtUsername"   id="txtUsername"   value="<?php echo $thisUser['username']; ?>" />
  
	</div>
	<div class="topLabel">
        <label for="txtTotalCost">Password</label>
        <input type="text" name="txtPassword"   id="txtPassword"   value="<?php echo $thisUser['password']; ?>" />
    </div>
	
	<div class="topLabel">
        <label for="txtTotalCost">First Name</label>
        <input type="text" name="txtFirstName"   id="txtFirstName"   value="<?php echo $thisUser['firstName']; ?>" />
    </div>
	
	<div class="topLabel">
        <label for="txtTotalCost">Last Name</label>
        <input type="text" name="txtLastName"   id="txtLastName"   value="<?php echo $thisUser['lastName']; ?>" />
    </div>
	
	<div class="topLabel">
       <label for="txtAdress">Address</label>
        <input type="text" name="txtAddress"   id="txtAddress"   value="<?php echo $thisUser['address']; ?>" />
    </div>
	
	 </fieldset>

	 
	<button name="new"    
           value="new"  
           style="float:left;"
           onclick="this.form.submit();">
           Create
   </button>
   <br>      
	<br>
	<button name="update" 
           value="update" 
           style="float:left;"
           onclick="this.form.submit();">
           Update
	</button>
    <br>      
	<br>
   <button name="delete" 
           value="delete"
           style="float:left;"
           onclick="this.form.submit();">
           Delete
   </button>
    <br/>
 <br/>
   
</form>
<?php
displayUserTable();
?>
<script>
    // Populate the drop-down box with current value
    document.getElementById("select").value = "<?PHP echo $thisUser['user_id']; ?>";
    document.getElementById("txtUsername").value = "<?PHP echo $thisUser['username'] ?>";
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