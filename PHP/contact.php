<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>About</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css">
	  <script src="https://kit.fontawesome.com/d688da91fc.js" crossorigin="anonymous"></script>
   </head>
   <body>
      <?php
	include_once 'header.php';
	?>
      <!-- begin left sidebar -->
      <section id="left-side">
         <p>Welcome back!</p>
         <div class="profile">
            <img src="https://picsum.photos/100" class="profile-image">
            <h3>John Doe</h3>
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
            <a href="#"><i class="fa-solid fa-phone-slash"></i> Sign Off</a>
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
      <footer>
         <p>&copy; hollandc@csp.edu 2022</p>
         <p>All images used with permission from https://www.pexels.com/
      </footer>
   </body>
</html>
