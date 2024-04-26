<?php
$title = 'Shop';
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
        echo '<script>alert("Please login to add books to cart!");
        window.location.href="login.php";</script>';
    }else {

    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $book_price = $_POST['book_price'];
    $book_image = $_POST['book_image'];
    $book_quantity = $_POST['book_quantity'];

    $sql = "SELECT * FROM cart WHERE title = '$book_id' AND user_id = '$user_id'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<script>alert("Book already added to cart!")</script>';
    } else {
        $sql = "INSERT INTO cart (user_id, name, price, quantity, image) VALUES ('$user_id', '$book_title', '$book_price', '$book_quantity', '$book_image')";
        $result = mysqli_query($con, $sql);

        if($result){
            echo '<script>alert("Book Added to Cart Successfully!"); 
            window.location.href="shop.php";</script>';  
        } else {
            echo '<script>alert("Book not added to cart!")</script>';
        }
    }
}
}   
 
?>    
        <link rel="stylesheet" href="./css/index.css">
        <link rel="stylesheet" href="./css/shop.css">

        
            
        <div id="slider">
        <figure><a href="shop.php">
        <img src="./src/banner.jpg">
        <img src="./src/banner2.jpg">
        <img src="./src/banner3.jpg">
        <img src="./src/banner4.jpg">
        </a></figure>
        </div>

        <p class="maintitle">Welcome to Eden BookStore</p>
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
        <div class="main-container" style="display:block;align-items: flex-start;">
        <h1 style="text-align:center;">Featured Products</h1>
        <div class="book-container" style="margin:30px 0;">
            <?php
                $select_books = mysqli_query($con, "SELECT * FROM products") or die('query failed');
                $select_category= mysqli_query($con, "SELECT name FROM categories INNER JOIN products ON categories.id = products.category_id") or die('query failed');

                if(mysqli_num_rows($select_books) > 0){
                    while(($fetch_books = mysqli_fetch_assoc($select_books)) AND ($fetch_category = mysqli_fetch_assoc($select_category))){
        
            ?>
            <div class="book-card">
                    <form action="" method="post" class="cart-box">
                        <img class="image" src="./src/uploads/<?php echo $fetch_books['image'] ?>" alt="">
                        <div class="info">
                            <h3><?php echo $fetch_books['title'] ?></h3>
                            <p><?php echo $fetch_category['name'] ?></p>
                            <div class="price-qty">
                                <span>$<?php echo $fetch_books['price'] ?></span>
                                <input type="number" name="book_quantity" value="1" min="1" id="book_quantity" class="qty">
                            </div>
                            <input type="hidden" name="book_id" value="<?php echo 
                            $fetch_books['id'] ?>">
                            <input type="hidden" name="book_title" value="<?php echo 
                            $fetch_books['title'] ?>">
                            <input type="hidden" name="book_price" value="<?php echo 
                            $fetch_books['price'] ?>">
                            <input type="hidden" name="book_image" value="<?php echo 
                            $fetch_books['image'] ?>">

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
                        echo '<p class="empty">No books added yet!</p>';
                    }
                ?>

        </div>
    
    
</body>

<?php
   
    include './templates/footer.php';
?>


    