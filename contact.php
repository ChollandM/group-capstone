<?php session_start();?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>About</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://kit.fontawesome.com/d688da91fc.js" crossorigin="anonymous"></script>
     <script src="chatbot/scripts/chatbot.js"></script>
    <script src="chatbot/scripts/botResponse.js"></script>
    <script src="chatbot/scripts/strings.js"></script>
    <link rel="stylesheet" href="chatbot/css/chatbot.css">
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
      <section id="blank-space">
      </section>
	   <h1>Contact Info</h1>
      <div class="form">
         <form action = "blank.php" method="POST" id="contact-form">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"> <br>
    
			<label for="email">Email:</label><br>
			<input type="email" id="email" name="email"><br>
			
			 <label for="message">Message:</label><br>
            <textarea name="message" rows="10" cols="50">
           
            </textarea><br>
			 <input type="submit" name="submit" value="Submit">
         </form>
      </div>
      <br>
      <section id="misc">
         <p>----------</p>
      </section>
      <div class="chat-block">
         <div class="collapse-bar">
             <button id="chat-button" type="button" class="collapsible" onclick="changeView()">Chatbot</button>
         </div>
         <div class="full-chat-box" id="full-chat-box">
             <!-- Messages container -->
             <div class="outer-container">
                 <div class="chat-container">
                     <!-- Messages -->
                     <div id="chatbox">
                         <h5 id="chat-timestamp"></h5>
                         <p id="botStarterMessage" class="botText"><span>Welcome to Newzeen!</span></p>
                     </div>
                     <!-- User Input -->
                     <div class="chat-bar-input-block">
                         <div id="userInput">
                             <input type="text" id="textInput" class="input-box" name="msg" placeholder="Press 'enter' to send a message">
                             <p></p>
                         </div>
                         <div class="chat-bar-buttons">
                             <button id="sendButton" type="button" onclick="sendButton()">Send</button>
                         </div>
                         <div id="input-block-bottom">
                             <p></p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
      <footer>
         <p>&copy; hollandc@csp.edu 2022</p>
         <p>All images used with permission from https://www.pexels.com/
      </footer>
   </body>
</html>


