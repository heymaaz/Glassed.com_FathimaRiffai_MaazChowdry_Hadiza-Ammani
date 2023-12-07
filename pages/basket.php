<?php
  session_start();
  if(isset($_SESSION['cart'])){
  foreach ($_SESSION['cart'] as $document)
  {
    //echo $document;
    
  }
  $stack = array();
  for($i=0;$i<count($_SESSION['cart']);$i++){
    if($_SESSION['cart'][$i] != 0){
      array_push($stack, $i);
      //echo "<br>hello";
    }
  }
  if(count($stack) == 0){
    echo '<script> alert("Your cart is empty");</script>';
  }
  else{
  $or = array();
  for($i=0;$i<count($stack);$i++){
    $or[$i] = array("pid" => $stack[$i]);
  }
  $findCriteria = array('$or' => $or);
  
  
  require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
  $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
      
  // selecting database
  $db = $m->Glassed;//Glassed is the database name
  //Displaying the product details from the database
  $collection = $db->Product;//Product is the collection name
  if(isset($_SESSION['cart'])){
  $list = $collection->find($findCriteria);
  }
}
  }
  else{
    echo '<script> alert("Please Log in");</script>';
  }


?>
<!DOCTYPE html>
<html>
<head>
  <!-- The title of the website, displayed in the browser tab -->
  <title>Basket</title>
  <!-- This line links the aboutUs.css stylesheet to the HTML document -->
  <link rel="stylesheet" type="text/css" href="../css/basket.css">
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
    <li><a href="basket.php"class="active">Basket</a></li>
  </ul>
  <ul class="nav-left">
    <a href="../pages/editProfile.html">Profile</a>
    <a href="login.html">Login</a>
    <a href="register.html">Register</a>
  </ul>
</nav>
</header>

<body>
  <div class="basket-container">
    <h1>Shopping Basket</h1>
    <table>
      <thead>
        <tr><!--table headings-->
          <th>Product Image</th>
          <th>Product</th> 
          <th>Product ID</th> 
          <th>Quantity</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $total=0;
          if(isset($_SESSION['cart'])&&isset($list)){
          foreach ($list as $document)
          {
            $val=$_SESSION['cart'][$document['pid']]*$document['product_price'];
            $total+=$val;
            echo "<tr>";
            //echo "<a href='product.php?pid=".$document['pid']."'>";
            echo "<td><img src='".$document['img_src'][0]."' alt='".$document['product_name']."' class='basket_img'></td>";
            echo "<td><a href='1PagePid.php?Pid=".$document['pid']."'>".$document['product_name']."</a></td>";
            echo "<td>".$document['pid']."</td>";
            echo "<td>".$_SESSION['cart'][$document['pid']]."</td>";
            echo "<td>".($val)."</td>";
            echo "</tr>";
          }
        }
        ?>
        
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td colspan="3">Total:</td>
          <td><?php echo $total ?></td>
        </tr>
      </tfoot>
    </table>
    <br><!--button when clicked it will post the order to the database and empty cart-->
    <button onclick="orderConfirm()">Checkout</button>
      <br>
  </div>
  
</body>
<br>
<br>
<script>
  //confirming the order
  function orderConfirm() {
    //posting the order to the database
    var rows = document.getElementsByTagName("table")[0].rows;
    var last = rows[rows.length - 1];
    var cell = last.cells[0];
    var customer_id = "<?php echo $_SESSION['loggedInUserId']; ?>";
    var order_total = rows[rows.length - 1].cells[2].innerHTML;
    //alert("Customer id: "+customer_id);
    //alert("Order Total: "+order_total);
    var product_id_qty = [];
    for (var i=0; i<rows.length-2; i++) {
      product_id_qty[i] = [];
    }
    //alert("Order Total: "+order_total);

    for(var i=0;i<rows.length-2;i++){
      product_id_qty[i][0] = rows[i+1].cells[2].innerHTML;
      product_id_qty[i][1] = rows[i+1].cells[3].innerHTML;
    }
    for(var i=0;i<rows.length-2;i++){
      //alert("Product id: "+product_id_qty[i][0]+" with qty: "+product_id_qty[i][1]);
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        location.href = "orderConfirm.html";
        //alert(this.responseText);
      }
    };
    xhttp.open("POST", "order.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer_id="+customer_id+"&order_total="+order_total+"&product_id_qty="+JSON.stringify(product_id_qty));
    //emptying the cart
    
  }
</script>
<!-- Footer div for contact information -->
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