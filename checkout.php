<?php
$title = 'Checkout';
include './php/config.php';
session_start();


if(isset($_SESSION['admin_id'])){
        $user_id = $_SESSION['admin_id'];
        include './templates/admin_header.php';
    } elseif(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        include './templates/user_header.php';
        
}   else
    header('location:login.php');

if(isset($_POST['order-btn'])){

    $name = mysqli_real_escape_string($con, $_POST['firstName'] . ' ' .$_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = $_POST['phone'];
    $address = mysqli_real_escape_string($con, $_POST['address'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ', ' . $_POST['zipCode']);
    $payment_method = $_POST['payment_method'];
    $date = date('Y-m-d');
    
    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($con, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($cart_query) > 0){
        while($cart_row = mysqli_fetch_assoc($cart_query)){
            $cart_total += $cart_row['price'];
            $cart_products[] = $cart_row['title'] . ' (' .$cart_row['quantity'].')';
            $sub_total = ($cart_row['price'] * $cart_row['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);
    $order_query = mysqli_query($con, "SELECT * FROM orders WHERE name = '$name' AND phone = '$phone' AND email = '$email' AND payment_method = '$payment_method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
    
if($cart_total == 0){
    echo '<script>alert("Your cart is empty!");
     window.location.href="shop.php";</script>';
    
} else {
    if(mysqli_num_rows($order_query) > 0){
        echo '<script>alert("Order already placed!")</script>';
    } else {
        mysqli_query($con, "INSERT INTO orders (user_id, name, phone, email, payment_method, address , total_products, total_price, placed_date) 
        VALUES ('$user_id', '$name', '$phone', '$email', '$payment_method', '$address' , '$total_products', '$cart_total', '$date')") or die('query failed');
    }
    $delete_cart = mysqli_query($con, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    echo '<script>alert("Order placed successfully!");
    window.location.href="orders.php";</script>';
    
}

}

?>

<link rel="stylesheet" href="./css/contactus.css">
<link rel="stylesheet" href="./css/checkout.css">
    <div class="title-section">
        <div class="title-section-container">
            <h1><?php echo $title ?></h1>
            <br>
            <ul class="breadcrump">
                <li><i class="fa-solid fa-house"></i> Home</li>
                <li>&gt; <?php echo $title ?></li>
            </ul>
        </div>
    </div>

    <div class="main-container" style="align-items: flex-start; margin-bottom:80px;">

        <div class="display-order">
            <?php 
                $final_total = 0;
                $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select_cart) > 0){
                    while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                        $total_price = ($fetch_cart['quantity'] * $fetch_cart['price']);
                        $final_total += $total_price;
            ?>            
            
            <div class="checkout-order-display">
        
                <div class="checkout-order-display-details">
                    <p><i class="fa-solid fa-book" style="margin-right:10px; color:var(--color-secondary);"></i><?php echo $fetch_cart['title']; ?> <span> - <?php echo '$' . $fetch_cart['price'].' ('.$fetch_cart['quantity']; ?>Qty)</span></p>
                </div>
            </div>


            <?php            
                    }
                } else {
                    echo '<h1>Your cart is empty</h1>';
                }
            ?>
            <div class="final-total"><span>Total - $ <?php echo $final_total; ?></span></div>
        </div>

        


        <div class="checkout">
            <div class="form-container">
            <?php
                $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
                $select_user= mysqli_query($con, "SELECT * FROM users INNER JOIN cart ON users.id = cart.user_id") or die('query failed');


                if(mysqli_num_rows($select_cart) > 0){
                    while(($fetch_cart = mysqli_fetch_assoc($select_cart)) AND ($fetch_user = mysqli_fetch_assoc($select_user))) {
                ?>

                <form action="" method="POST">
                    <h3>Place your order</h3>
                    <div class="half-container">
                        <div class="input-field half-column">
                            <i class="fas fa-user"></i>
                            <input type="text" name="firstName" id="firstName" placeholder="First Name" value="<?php echo $fetch_user['firstName']; ?>" required>
                        </div>

                        <div class="input-field half-column">
                            <i class="fas fa-user"></i>
                            <input type="text" name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $fetch_user['lastName']; ?>" required>
                        </div>

                    </div>

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $fetch_user['email']; ?>" required>
                    </div>

                    <div class="input-field ">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="phone" id="phone" placeholder="Phone Number" value="<?php echo $fetch_user['phone']; ?>" required>
                    </div>

                    <div class="input-field ">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="address" id="address" placeholder="Street Address" value="<?php echo $fetch_user['address']; ?>" required>
                    </div>


                    <div class="half-container">
                        <div class="input-field half-column">
                            <i class="fa-solid fa-city "></i>
                            <input type="text " name="city" id="city" placeholder="City" value="<?php echo $fetch_user['city']; ?>" required>
                        </div>

                        <div class="input-field half-column">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <input type="text" name="state" id="state" placeholder="State/ Province" value="<?php echo $fetch_user['state']; ?>" required>
                        </div>
                    </div>

                    <div class="half-container">

                        <div class="input-field half-column">
                            <i class="fa-brands fa-usps"></i>
                            <input type="text" name="zipCode" id="zipCode" placeholder="Postal/ Zip Code" value="<?php echo $fetch_user['zipCode']; ?>" required>
                        </div>

                        <div class="input-field half-column">
                            <i class="fa-solid fa-earth-africa"></i>
                            <select id="country" name="country" required>
                                <option value="<?php echo $fetch_user['country']; ?>" disable selected><?php echo $fetch_user['country']; ?></option>
                                <option value="australia">Sri Lanka</option>
                                <option value="australia">Australia</option>
                                <option value="canada">Canada</option>
                                <option value="usa">USA</option>
                            </select>
                        </div>

                        <div class="input-field">
                        <i class="fa-solid fa-credit-card"></i>
                            <select id="country" name="payment_method" required>
                                <option value=" " disable selected>- Select Payment Method -</option>
                                <option value="Cash on delivery">Cash on delivery</option>
                                <option value="Bank Deposit">Bank Deposit</option>
                            </select>
                        </div>


                    </div>

                    <input type="submit" value="Place Order" name="order-btn" class="btn" id="order-btn">


                </form>
                <?php
                    }
                    } else {
                        echo '<h1>Your cart is empty</h1>';
                    }
                ?>        
                
            </div>
        </div>
    </div>

<?php
include './templates/footer.php';

?>