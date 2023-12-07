<?php
    session_start();
    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //Displaying the order details from the database
    $collection = $db->Order;//Order is the collection name
    $findCriteria = [
      "customer_id" => (string)$_SESSION['loggedInUserId']
    ];
    $list = $collection->find(
      $findCriteria, ['sort' => ['order_total' => 1]] //finds the product with the pid
    );
?>
<!DOCTYPE html>
<html>
<head>
  <!-- The title of the website, displayed in the browser tab -->
  <title>Previous Orders</title>
  <!-- This line links the aboutUs.css stylesheet to the HTML document -->
  <link rel="stylesheet" type="text/css" href="../css/editProfile.css">
     <!-- This line links the font awesome for social icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<header>
    <!--NAVIGATION BAR-->
<nav>
  <div class="logo">
    <img src="../imgs/Glassed_Logo 4.png" alt="logo">
  </div>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="rayban.php">Rayban</a></li>
    <li><a href="chanel.php">Chanel</a></li>
    <li><a href="AbousUs.html">About Us</a></li>
    <li><a href="basket.php">Basket</a></li>
  </ul>
  <ul class="nav-left">
    <a href="editProfile.html">Edit Profile</a>
  </ul>
</nav>
</header>


<body>
    <div class="container">
      
        <br>
        <br>
        <h1>Previous Orders</h1>
        <table>
          <tr>
            <th>Order ID</th>
            <th>Total (AED)</th>
            <th>Status</th>
          </tr>
          <?php foreach ($list as $entry) {
            echo "<tr>";
            echo "<td>" . $entry['_id'] . "</td>";
            echo "<td>" . $entry['order_total'] . "</td>";
            echo "<td>Delivered</td>";
            echo "</tr>"; 
          }
          ?>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      </div>
      

</body>
<!--FOOTER-->
<footer>
  <div class="footer-container">
    <div class="footer-left">
      <h3>Quick Info</h3> <!-- Section for brief introduction -->
      <p>Glassed offers a wide selection of premium sunglasses from top brands like Rayban and Chanel. Glassed ensures
        100% authenticity and customer satisfaction on every purchase.
        Shop now for the latest styles and trends.</p> <!-- Introduction content -->
    </div>
    <div class="footer-right">
      <h3>Contact Us</h3> <!-- Section for contact information -->
      <p>Email: Glassed@shades.com</p> <!-- Email -->
      <p>Phone: 042-550-6789</p> <!-- Phone number -->
      <p>Address: Al Khail Street, Dubai, UAE</p> <!-- Address -->
    </div>
    <div class="footer-middle">
      <h3>Social</h3> <!-- Section for contact Social -->
      <a href="https://web.facebook.com" class="fa fa-facebook-square"></a><!-- Facebook -->
      <a href="https://twitter.com" class="fa fa-twitter-square"></a><!-- Twitter -->
      <a href="https://www.instagram.com" class="fa fa-instagram"></a><!-- Instagram -->
    </div>
    <div class="footer-copyright">
      <p>Copyright © Glassed. All rights reserved.</p> <!-- Copyright information -->
      <p>Sunglasses Like No other</p> <!-- Tagline -->
    </div>
  </div>
</footer>

</html>