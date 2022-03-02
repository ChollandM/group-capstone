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
	   <table>
  <tr>
    <th>Name</th>
	  <th>Item</th>
    <th>Cost</th>
    <th>Date</th>
  </tr>
  <tr>
    <td>Chair</td>
	  <td><img src="https://picsum.photos/100/100"></td>
    <td>$50</td>
    <td>1/15/22</td>
  </tr>
  <tr>
    <td>Sweater</td>
	  <td><img src="https://picsum.photos/id/104/100/100"></td>
    <td>$25</td>
    <td>1/15/22</td>
  </tr>
  <tr>
    <td>Spoon Set</td>
	  <td><img src="https://picsum.photos/id/1035/100/100"></td>
    <td>$15</td>
    <td>1/15/22</td>
  </tr>
  <tr>
    <td>Flower Pot</td>
	  <td><img src="https://picsum.photos/id/106/100/100"></td>
    <td>$10</td>
    <td>1/15/22</td>
  </tr>
  <tr>
    <td>Milk Crate</td>
	  <td><img src="https://picsum.photos/id/206/100/100"></td>
    <td>$12</td>
    <td>2/07/22</td>
  </tr>
  <tr>
    <td>Bookcase</td>
	  <td><img src="https://picsum.photos/id/107/100/100"></td>
    <td>$35</td>
    <td>2/07/22</td>
  </tr>
</table>

      <section id="misc">
         <p>----------</p>
      </section>
      <footer>
         <p>&copy; hollandc@csp.edu 2022</p>
         <p>All images used with permission from https://www.pexels.com/
      </footer>
   </body>
</html>

