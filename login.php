<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheetLogin.css">
<head>
<title>Log in</title>
<?php

// Define Constants
define("SERVER_NAME", "novio-dev-1.cptgeqlvlgbo.us-east-1.rds.amazonaws.com");
define("DBF_USER_NAME", "cspuser");
define("DBF_PASSWORD", "admin.csp1");
define("DATABASE_NAME", "Newzeen");

createConnection();

// Login user
if (isset($_POST["loginButton"])){
    $username = $_POST["txtUsername"];
    $password = $_POST["txtPassword"];

    require_once "newZeenLib.php";

    if (emptyLoginField($username, $password) !== false){
        header("location: login.php?error=emptyfield");
        exit();
    }
    loginUser($conn, $username, $password);
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
            <!-- Display username on left sidebar if user is logged in-->
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

<!-- Log in form-->
<section id="entryBlock">
<div id="loginBlock">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" 
      method="POST" 
      name="login" 
      id="login">

    <!-- SIGN IN ERROR MESSAGES -->

    <?php
        if (isset($_GET["error"])){
            if ($_GET["error"] == "emptyfield"){
                echo "<h3 class='errorMessage'>One or more fields were left blank</h3>";
            }
            else if ($_GET["error"] == "incorrectlogin"){
                echo "<h3 class='errorMessage'>The entered username or password was incorrect</h3>";
            }
        }
    ?>
    <!-- Sign in entry-->
    <fieldset id="createBlock">
        <legend>Sign in</legend>
        <h3 class="errorMessage"><h3>
        <div class="entryLabel">
            <label for="txtUsername">Username</label><br/><br/>
            <input type="text" name="txtUsername" id="txtUsername" value=""/>
        </div>
        <br/>
        <div class="entryLabel">
            <label for="txtPassword">Password</label><br/><br/>
            <input type="password" name="txtPassword" id="txtPassword" value=""/>
        </div>
        <br/><br/>
        
    <button name="loginButton" 
            value="loginButton"
            id="loginButton"
            onclick="this.form.submit()">
            Sign In
    </button>
    </fieldset>

</form>
<div class="formUnder">
    <h3>Don't have an account?</h3>
    <a href="createAccount.php">Create an account</a>
</div>
</div>
</section>
</body>
</html>
