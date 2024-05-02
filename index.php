<?php
$title = 'Home';
include './php/config.php';
session_start();


if(isset($_SESSION['admin_id'])){
        $user_id = $_SESSION['admin_id'];
        include './templates/admin_header.php';
    } elseif(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        include './templates/user_header.php';
}   else
        include './templates/header.php';


if(isset($_POST['add_to_cart'])){

    if (!isset($user_id)){
        echo '<script>alert("Please login to add products to cart!");
        window.location.href="login.php";</script>';
    }else {

    $product_id = $_POST['product_id'];
    $product_title = $_POST['product_title'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $sql = "SELECT * FROM cart WHERE title = '$product_id' AND user_id = '$user_id'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<script>alert("Product already added to cart!")</script>';
    } else {
        $sql = "INSERT INTO cart (user_id, title, price, quantity, image) VALUES ('$user_id', '$product_title', '$product_price', '$product_quantity', '$product_image')";
        $result = mysqli_query($con, $sql);

        if($result){
            echo '<script>alert("Product Added to Cart Successfully!"); 
            window.location.href="cart.php";</script>';  
        } else {
            echo '<script>alert("Product not added to cart!")</script>';
        }
    }
}
}   
 
?>    
        <link rel="stylesheet" href="./css/index.css">
        <link rel="stylesheet" href="./css/shop.css">

        
        <div class="main-container" style="display:flex;align-items: flex-start; padding-bottom:80px; flex-direction:row;">
            <div style="flex:1;">
                <h1 >Discover Best Deals <br>With Us</h1>
                <p style="text-align:left; margin-top:10px; margin-bottom:30px">Shop a wide range of products and enjoy exclusive promotions.</p>
                <button>Shop Now</button>
            </div>

            <div  style="flex:1;"> 
                <img class="image" src="./src/hero-image.png" alt="" style="width:90%;">
            </div>
        </div>
        

        <h1 style="text-align:center; margin-bottom:40px;">Welcome to Online Shop</h1>
        <div class="row">
            <div class="col-1">
                    <img src="./src/qickdelivery.png">
                     <p class="banner1">Quick Delivery</p>
            
            </div>
            <div class="col-1">
                    <img src="./src/securepayment.png">
                    <p class="banner1">Secure Payment</p>
        
            </div>
            <div class="col-1">
                <img src="./src/bestquality.png">
                <p class="banner1">Best Quality</p>
    
            </div>
        </div>
        <!--featured categories-->
        <div class="main-container" style="display:block;align-items: flex-start; padding-bottom:80px;">
            <h1 style="text-align:center;">Featured Products</h1>
            <div class="product-container" style="margin:30px 0;">
                <?php
                $select_products = mysqli_query($con, "SELECT * FROM products") or die('query failed');
                $select_category= mysqli_query($con, "SELECT name FROM categories INNER JOIN products ON categories.id = products.category_id") or die('query failed');

                if(mysqli_num_rows($select_products) > 0){
                    while(($fetch_products = mysqli_fetch_assoc($select_products)) AND ($fetch_category = mysqli_fetch_assoc($select_category))){
        
                ?>
                <div class="product-card">
                    <form action="" method="post" class="cart-box">
                        <img class="image" src="./src/uploads/<?php echo $fetch_products['image'] ?>" alt="">
                        <div class="info">
                            <h3><?php echo $fetch_products['title'] ?></h3>
                            <p><?php echo $fetch_category['name'] ?></p>
                            <div class="price-qty">
                                <span>$<?php echo $fetch_products['price'] ?></span>
                                <input type="number" name="product_quantity" value="1" min="1" id="product_quantity" class="qty">
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo 
                            $fetch_products['id'] ?>">
                            <input type="hidden" name="product_title" value="<?php echo 
                            $fetch_products['title'] ?>">
                            <input type="hidden" name="product_price" value="<?php echo 
                            $fetch_products['price'] ?>">
                            <input type="hidden" name="product_image" value="<?php echo 
                            $fetch_products['image'] ?>">

                            <?php 

                                echo '<div class="btn-1">
                                <button type="submit" value="Add to cart" name="add_to_cart" class="btn"><img src="./src/cart.svg" alt="" style="width:25px; margin-right:10px;"> Add to cart</button>
                                </div>';
                            
                            ?>
                            
                        </div>
                    </form>
                </div>        
                <?php
                    }
                    } else {
                        echo '<p class="empty">No products added yet!</p>';
                    }
                ?>

        </div>
    </div>
    
    
</body>

<?php
   
    include './templates/footer.php';
?>


    