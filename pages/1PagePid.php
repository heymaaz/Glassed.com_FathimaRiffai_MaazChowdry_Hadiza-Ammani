<?php
    session_start();
    $strpid = filter_input(INPUT_GET, 'Pid', FILTER_SANITIZE_STRING);
    $intPid = (int)$strpid;

    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //Create a PHP array with our search criteria
    $findCriteria = [
        "pid" => $intPid//,
        //"password" => $password
    ];
    //Find all of the products that match  this criteria
    $resultArray = $db->Product->find($findCriteria)->toArray();
    if (count($resultArray) == 0) {
      //No product was found
      echo "No product found";
      return;
    }
    if(count($resultArray) > 1) {
        //More than one product was found
        echo "More than one product found";
        return;
    }
    //Get the first (and only) product from the array
    $product = $resultArray[0];
    foreach ($resultArray as $document) {
        $product_name=$document["product_name"];//gets the product name from the database
        $product_description=$document["product_description"];//gets the product description from the database
        $product_price=$document["product_price"];//gets the product price from the database
        $type = $document["type"];//gets the product type from the database
        $array = json_decode(json_encode($document["img_src"],true), true);//gets the product images from the database
      
        if(isset($_SESSION['array'])){
          $_SESSION['array'][$intPid]++;//increments for recommended products
        }
      }
  
?>
<!DOCTYPE html>
<html>
    
      <head>
        <!-- The title of the website, displayed in the browser tab -->
        <title><?php echo $product_name?></title>
        <!-- This line links the aboutUs.css stylesheet to the HTML document -->
        <link rel="stylesheet" type="text/css" href="../css/1PagePid1.css">
        <!-- This line links the font awesome for social icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      </head>
    <header>
      <!--NAVIGATION BAR-->
    <nav>
    <div class="logo"> <!--Logo-->
      <img src="../imgs/Glassed_Logo 4.png" alt="logo">
    </div>
    <ul class="nav-links"><!--Navigation links-->
      <li><a href="index.php">Home</a></li><!--Home-->
      <li><a href="rayban.php"<?php if($type=="RayBan"){ echo "class='active'";} ?>>Rayban</a></li><!--Rayban-->
      <li><a href="chanel.php"<?php if($type=="Chanel"){ echo "class='active'";} ?>>Chanel</a></li><!--Chanel-->
      <li><a href="AbousUs.html">About Us</a></li><!--About Us-->
      <li><a href="basket.php">Basket</a></li><!--Basket-->
    </ul>
    <ul class="nav-left"><!--Navigation links-->
      <a href="editProfile.html">Profile</a><!--Profile-->
      <a href="login.html">Login</a><!--Login-->
      <a href="register.html">Register</a><!--Register-->
    </ul>
    </nav>
    </header>
    <body>
          
        <div class="product-container">
          <!--Product container-->
            <div class="product-images">
              <!--Product images-->
              <img src="<?php echo $array[0]?>" alt="Product 1" onclick="changeMainImage(this)"><!--Product image 1-->
              <img src="<?php echo $array[1]?>" alt="Product 1" onclick="changeMainImage(this)"><!--Product image 2-->
              <img src="<?php echo $array[2]?>" alt="Product 1" onclick="changeMainImage(this)"><!--Product image 3-->
              <img src="<?php echo $array[3]?>" alt="Product 1" onclick="changeMainImage(this)"><!--Product image 4-->
            </div>
            <div class="main-image-container"><!--Main image-->
              <img id="main-image" src="<?php echo $array[0]?>" alt="Product 1"><!--Main image-->
            </div>
            <div class="product-details">
              <!--Product details-->
            
            <?php
              echo "<h2>" . $product_name . "</h2>";//displays the product name
              echo "<p>" . $product_description . "</p>";//displays the product description
              echo "<p>Price: AED " . $product_price . ".00</p>";//displays the product price
              echo "<button onclick='addToCart(".$intPid.");  return false;'>Add to Cart</button>";
            ?>
            </div>
          </div>
          <script>//to change the main image
            function changeMainImage(img) {
                document.getElementById("main-image").src = img.src;
            }
          </script>
    
    </body>
    
    <script>
      // add to cart button function
      function addToCart(pid) {//function to add to cart
    <?php
      if (!isset($_SESSION['cart']))
        echo 'alert("Please Log in");';
      else
      {
    ?>
    var xhttp = new XMLHttpRequest();//ajax request to add to cart
    xhttp.onreadystatechange = function() {//function to check if the request is successful
      if (this.readyState == 4 && this.status == 200) {
        //alert(this.responseText);
      }
    };
    xhttp.open("POST", "addToCart.php", true);//opens the request
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("pid="+pid);//sends the request
    alert("Added to Cart");
    <?php
      }
    ?>
  }
      
    </script>
    
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
    
</html>