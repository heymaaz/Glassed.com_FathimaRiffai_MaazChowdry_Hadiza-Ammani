<?php
    session_start();
    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //Displaying the product details from the database
    $collection = $db->Product;//Product is the collection name
    $list = $collection->find(
      ['type' => "RayBan"], ['sort' => ['product_price' => 1]] //finds the product with the pid
    );
    //$options = ['sort' => ['product_price' => 1]];
  ?>
<!DOCTYPE html>
<html>
<head>
  <!-- The title of the website, displayed in the browser tab -->
  <title>Rayban</title>
  <!-- This line links the aboutUs.css stylesheet to the HTML document -->
  <link rel="stylesheet" type="text/css" href="../css/rayban.css">
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
    <li><a href="rayban.php"class="active">Rayban</a></li>
    <li><a href="chanel.php">Chanel</a></li>
    <li><a href="AbousUs.html">About Us</a></li>
    <li><a href="basket.php">Basket</a></li>
  </ul>
  <ul class="nav-left">
    <form id="search-form">
      <input type="text" id="search-input" placeholder="Search for products">
      <button type="submit" id="search-button" onclick="search(); return false;"><i class="fa fa-search"></i></button>
    </form>
    <a href="../pages/editProfile.html">Profile</a>
    <a href="login.html">Login</a>
    <a href="register.html">Register</a>
  </ul>
</nav>
</header>
<body>
  <h2>Rayban</h2>
  <!-- HTML for the dropdown list -->
<label for="sort-options">Sort by:</label>
<select id="sort-options" onchange="sortSunglasses()">
  <option value="Low to High">Low to High</option>
  <option value="High to Low">High to Low</option>
  <option value="Name A-Z">Name A-Z</option>
</select>
  <ul id="ulP">
  <?php
    foreach ($list as $document) {
      echo "<li id='liP'>";
      echo "<a href='1PagePid.php?Pid=".$document["pid"]."'><h3>".$document["product_name"]."</h3>";
      echo "<img id= 'productImg' src='../imgs/".$document["img_src"][0]."' alt='".$document["product_name"]."'></a>";
      echo "<p>AED ".$document["product_price"]."</p>";
      echo "<button onclick='addToCart(".$document['pid'].");  return false;'>Add to Cart</button>";
      //onclick="search(); return false;
      //echo "<button>Add to Cart</button>";
      echo "</li>";
    }
  ?>
  </ul>
  <
</body>

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


<script>
  
//search button function
function search() {//function to search
    var searchInput = document.getElementById("search-input");//gets the search input
    var searchValue = searchInput.value;//gets the value of the search input
    if (searchValue == "") {//if the search input is empty
      alert("Please enter a search term");//alert message
    } 
    else {//if the search input is not empty
      window.location.href = "search.php?q=" + searchValue;//redirects to the search page
    }
  }
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
  
  function sortSunglasses() {//function to sort the sunglasses
    var sortOptions = document.getElementById("sort-options");//gets the dropdown list
    var selectedOption = sortOptions.options[sortOptions.selectedIndex].value;//gets the selected option
    var ulP = document.getElementById("ulP");//gets the unordered list
    var liP = ulP.getElementsByTagName("li");//gets the list items
    liP = Array.prototype.slice.call(liP, 0);//converts the list items to an array
    
    
    var i, j, temp, min_idx;//variables
    if (selectedOption == "Low to High") {//if statement
      for (i = 0; i < liP.length-1; i++) {//for loop
        min_idx = i;//min index
        for (j = i+1; j < liP.length; j++) {//for loop
          if (parseFloat(liP[j].getElementsByTagName("p")[0].innerHTML.substring(4,6)) < parseFloat(liP[min_idx].getElementsByTagName("p")[0].innerHTML.substring(4,6)))
          {
            min_idx = j;//min index
          }
          
        }
        temp = liP[min_idx];//temp variable
        liP[min_idx] = liP[i];//swaps the list items
        liP[i] = temp;//swaps the list items
      }
      for (i = 0; i < liP.length; i++) {
        ulP.appendChild(liP[i]);//appends the list items
      }
    }
    else if (selectedOption == "High to Low"){
      for (i = 0; i < liP.length-1; i++) {//for loop
        min_idx = i;//min index
        for (j = i+1; j < liP.length; j++) {//for loop
          if (parseFloat(liP[j].getElementsByTagName("p")[0].innerHTML.substring(4,6)) > parseFloat(liP[min_idx].getElementsByTagName("p")[0].innerHTML.substring(4,6)))
          {
            min_idx = j;//min index
          }
          
        }
        temp = liP[min_idx];//temp variable
        liP[min_idx] = liP[i];//swaps the list items
        liP[i] = temp;//swaps the list items
      }
      for (i = 0; i < liP.length; i++) {
        ulP.appendChild(liP[i]);//appends the list items
      }
    }
    else if (selectedOption == "Name A-Z") {//if statement
      for (i = 0; i < liP.length-1; i++) {//for loop
        min_idx = i;//min index
        for (j = i+1; j < liP.length; j++) {//for loop
          if (-1===(liP[j].getElementsByTagName("h3")[0].innerHTML).toString().localeCompare((liP[min_idx].getElementsByTagName("h3")[0].innerHTML).toString()))
          {
            min_idx = j;//min index
          }
          
          
        }
        temp = liP[min_idx];//temp variable
        liP[min_idx] = liP[i];//swaps the list items
        liP[i] = temp;//swaps the list items
      }
      for (i = 0; i < liP.length; i++) {
        ulP.appendChild(liP[i]);//appends the list items
      }
    }
  }
</script>
</html>