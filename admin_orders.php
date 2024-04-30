<?php
$title = 'Orders List';
include './php/config.php';
session_start();


if(isset($_SESSION['admin_id'])){
        $user_id = $_SESSION['admin_id'];
        include './templates/admin_header.php';
    } else
    header('location:login.php');

if(isset($_POST['update_order'])){

    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($con, "UPDATE `orders` SET order_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    echo '<script>alert("Order status updated successfully")</script>';
     
}
     
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
}

?>

<link rel="stylesheet" href="./css/orders.css">

   
<div class="main-container book-main">

    <?php include './templates/admin_navigation.php' 

    ?>
   
    <div class="orders-container">
        
            <?php
                $order_query = mysqli_query($con, "SELECT * FROM orders") or die('query failed');
                
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

                <form action="" method="post">
                    <div class="input-field">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <select name="update_payment">
                            <option value="" selected disabled><?php echo $fetch_orders['order_status']; ?></option>
                            <option value="completed">completed</option>
                        </select>
                    </div>
                    <div class="button-div">
                        <input type="submit" value="update" name="update_order" class="btn option-btn">
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="btn delete-btn">delete</a>
                    </div>
                </form> 
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
