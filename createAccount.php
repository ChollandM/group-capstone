<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheetLogin.css">
<head>
<title>Sign Up</title>
<?php

// Define Constants
define("SERVER_NAME", "novio-dev-1.cptgeqlvlgbo.us-east-1.rds.amazonaws.com");
define("DBF_USER_NAME", "cspuser");
define("DBF_PASSWORD", "admin.csp1");
define("DATABASE_NAME", "Newzeen");

createConnection();

if(isset($_POST['create'])) 
{

$email = $_POST['txtEmail'];
$user = $_POST['txtUsername'];
$pass = $_POST['txtPassword'];
$passRepeat = $_POST['txtPasswordRepeat'];
$first = $_POST['txtFirstName'];
$last = $_POST['txtLastName'];
$address = $_POST['txtAddress'];

require_once 'newZeenLib.php';

// Error handler functions for account creation form
if(emptyField($email, $user, $pass, $passRepeat, $first, $last, $address) !== false){
    header("location: createAccount.php?error=emptyfield");
    exit();
}
if(invalidEmail($email) !== false){
    header("location: createAccount.php?error=invalidemail");
    exit();
}
if(invalidUsername($user) !== false){
    header("location: createAccount.php?error=invalidusername");
    exit();
}
if(passwordMatch($pass, $passRepeat) !== false){
    header("location: createAccount.php?error=passwordsnotmatching");
    exit();
}
if(passwordInvalid($pass) !== false){
    header("location: createAccount.php?error=passwordweak");
    exit();
}
if(userExists($conn, $user, $email) !== false){
    header("location: createAccount.php?error=userexists");
    exit();
}

// Call to stored procedure to create user profile
$sql= "call createUser('".$_POST['txtEmail']."','" .$_POST['txtUsername']."','".$_POST['txtPassword']."','".$_POST['txtFirstName']."','".$_POST['txtLastName']."','".$_POST['txtAddress']."');" ;	
$result = $conn->query($sql);
header("location: index.php");
exit();
}

function createConnection(){
    global $conn;
    // Create connection object
    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);
    // Check connection
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    // Select the database
    $conn->select_db(DATABASE_NAME);    
}
?>
</head>
<body>

<header>
         <!-- begin nav menu -->
         <div class="navbar">
            <a style="float: right"><input type="text" placeholder="Search..."></a>
            <a href="index.php">Home</a>
            <a href="store.php">Store</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <!-- Account page link if user logged in. Sign in button if not-->
            <?php
                if (isset($_SESSION["username"])){
                    echo "<a href='account.php'>Account</a>";
                }
                else{
                    echo "<a href='login.php'>Sign In</a>";
                }
            ?>
            <a style="float: left" id="title">NewZeen</a>
            <!-- end nav menu -->
         </div>
</header>

    <!-- begin left sidebar -->
    <section id="left-side">
         <p>Welcome back!</p>
         <div class="profile">
            <img src="https://picsum.photos/100" class="profile-image">
            <?php
                if (isset($_SESSION["username"])){
                    echo "<h3>" . $_SESSION["username"] . "</h3>";
                }
                else {
                    echo "<h3>John Doe</h3>";
                }
            ?>
            <p>Member since Jan. 2022</p>
         </div>
         <div class="left-menu">
            <a href="#"><i class="fa-solid fa-book-journal-whills"></i> My Orders</a>
            <br><br>
            <a href="#"><i class="fas fa-heart"></i> Wishlists</a>
            <br><br>
            <a href="#"><i class="fa-solid fa-business-time"></i> Settings</a>
            <br><br>
            <a href="#"><i class="fa-solid fa-user"></i> Reviews</a>
            <br><br>
            <a href="logout.php"><i class="fa-solid fa-phone-slash"></i> Sign Off</a>
         </div>
      </section>
      <!-- end left sidebar -->

      <!-- begin right sidebar -->
      <aside>
         <div class="widget">
            <h4>Returns....</h4>
            <h4>Shipping....</h4>
            <p>
               <script>document.write(new Date().toLocaleDateString()); </script>
            </p>
            <!-- todays date script -->
            <p>ect...</p>
         </div>
         <!-- end top right sidebar -->
         <div class="widget socials">
            <h4>New Items</h4>
            <img src="images/basket.jpeg" alt="Wicker basket image" class="hot-image">
            <img src="images/flower.jpeg" alt="Photo of flowers in a basket" class="hot-image">
            <img src="images/chair.jpeg" alt="Photo of a dark blue chair" class="hot-image">
         </div>
      </aside>
      <!-- end bottom right sidebar -->

<!-- Account creation form-->
<section id="entryBlock">
<div id="signUpSheet">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" 
      method="POST" 
      name="accountCreation" 
      id="accountCreation">
    <fieldset id="createBlock">
        <legend>Create your account</legend>
        <!-- Error Messages-->
        <?php
    if (isset($_GET["error"])){
        if ($_GET["error"] == "emptyfield"){
            echo "<h3 class='errorMessage'>One or more fields were left blank<h3>";
        }
        else if ($_GET["error"] == "invalidemail"){
            echo "<h3 class='errorMessage'>Please enter a valid email address<h3>";
        }
        else if ($_GET["error"] == "invalidusername"){
            echo "<h3 class='errorMessage'>Entered username is invalid. Please only use letters and numbers</h3>";
        }
        else if ($_GET["error"] == "passwordsnotmatching"){
            echo "<h3 class='errorMessage'>Passwords do not match</h3>";
        }
        else if ($_GET["error"] == "userexists"){
            echo "<h3 class='errorMessage'>An account with entered username or email already exists</h3>";
        }
        else if ($_GET["error"] == "passwordweak"){
            echo "<h3 class='errorMessage'>Password too weak</h3>";
            echo "<p>Password must contain 8 or more characters</p>";
            echo "<p>Password must have at least one uppercase letter</p>";
            echo "<p>Password must have at least one lowercase letter</p>";
            echo "<p>Password must have at least one special character</p>";
        }
        else if ($_GET["error"] == "none"){
            echo "<h3 class='successMessage'>Account created successfully</h3>";
        }
    }
        ?>
        <!-- Account information entry-->
        <div class="entryLabel">
            <label for="txtUsername">Username</label><br/>
            <input type="text" name="txtUsername" id="txtUsername" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtEmail">Email</label><br/>
            <input type="text" name="txtEmail" id="txtEmail" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtPassword">Password</label><br/>
            <input type="password" name="txtPassword" id="txtPassword" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtPassword">Retype Password</label><br/>
            <input type="password" name="txtPasswordRepeat" id="txtPasswordRepeat" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtFirstName">First Name</label><br/>
            <input type="text" name="txtFirstName" id="txtFirstName" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtLastName">Last Name</label><br/>
            <input type="text" name="txtLastName" id="txtLastName" value=""/>
        </div>
        <div class="entryLabel">
            <label for="txtAddress">Address</label><br/>
            <input type="text" name="txtAddress" id="txtAddress" value=""/>
        </div>
        <br/>
    <button name="create" 
            value="create"
            id="createButton"
            onclick="this.form.submit()">
            Create
    </button>
    </fieldset>
</form>
<div class="formUnder">
    <h3>Already have an account?</h3>
    <a href="login.php">Sign in</a>
</div>
</div>
</section>
</body>
</html>