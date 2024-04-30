<?php
$title = 'Orders';
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


?>

<link rel="stylesheet" href="./css/orders.css">

   
<div class="main-container book-main">

    <?php include './templates/user_navigation.php' 

    ?>
   
    <div class="orders-container">
        
            <?php
                $order_query = mysqli_query($con, "SELECT * FROM orders WHERE user_id = $user_id") or die('query failed');
                
                if(mysqli_num_rows($order_query) > 0){
                    while($fetch_orders = mysqli_fetch_assoc($order_query)){

            ?>

            <div class="order-box">
                <p> placed on : <span><?php echo $fetch_orders['placed_date']; ?></span> </p>
                <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                <p> number : <span><?php echo $fetch_orders['phone']; ?></span> </p>
                <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                <p> payment method : <span><?php echo $fetch_orders['payment_method']; ?></span> </p>
                <p> your orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                <p> total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                <p> payment status : <span style="color:<?php if($fetch_orders['order_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['order_status']; ?></span> </p>     

            </div>

            <?php
            }
            }else{
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
            
        
                
    </div>

        
        
</div>

<?php

    include './templates/footer.php';

?>
