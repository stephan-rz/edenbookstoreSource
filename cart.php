<?php
$title = 'Shooping Cart';
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

if(isset($_POST['update_cart'])){

    $cart_id = $_POST['cart_id'];
    $cart_qty = $_POST['quantity'];

    mysqli_query($con, "UPDATE cart SET quantity = '$cart_qty' WHERE id = '$cart_id'") or die('query failed');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
}

if(isset($_GET['clear'])){
    mysqli_query($con, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    header('location:shop.php');
}

?>

<link rel="stylesheet" href="./css/cart.css">

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
<div class="main-container" style="align-items: flex-start; padding-bottom:80px;">
        
        <div class="cart-container">
            <div class="basket">
            <div class="basket-labels">
                <ul>
                <li class="item item-heading">Item</li>
                <li class="price">Price</li>
                <li class="quantity">Quantity</li>
                <li class="subtotal">Subtotal</li>
                </ul>
            </div>
            <div class="basket-product" style="margin-bottom:20px;">

            <?php
                $total = 0;
                $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE user_id = $user_id") or die('query failed');
                
                if(mysqli_num_rows($select_cart) > 0){
                    while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            ?>

        <main>
    
            <div class="item">
                <div class="product-image">
                    <img src="src/uploads/<?php echo $fetch_cart['image']; ?>" alt="Placholder Image 2" class="product-frame">
                </div>
                <div class="product-details">
                    <h1><strong><?php echo  $fetch_cart['title']; ?></strong></h1>
                </div>
            </div>
            <div class="price">$ <?php echo $fetch_cart['price']; ?>
            </div>
            <div class="quantity">
                <form action="" method="post">
                <input type="number" name="quantity" value="<?php echo $fetch_cart['quantity']; ?>" min="1" class="quantity-field">
            </div>
            <div class="subtotal">$ <?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']) ?>
            </div>
            <div class="remove">
                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id'] ?>">
                <input type="submit" name="update_cart" value="Update" class="btn update-btn">
                </form>
                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Delete this from cart?')"><button>Remove</button></a>
            </div>   
                
                <?php $total += $sub_total;?>
            </main> 
    
                     
                <?php
                    
                    
                    }
                    } else {
                        echo '<p class="empty" style="margin-bottom:20px!important;">Your cart is empty!</p>';
                        echo '<a href="shop.php" ><button>Go to Shop</button></a>
                        ';
                    }
                ?>
                </div>
                <?php  if(isset($total)){
                    echo '<div class="clear-cart-btn">
                        <a href="cart.php?clear=true" onclick="return confirm("Delete all from cart?")"><button>Clear Cart</button></a>
                    </div>';
                }
                ?>
            
            </div>
                <aside>
                    <div class="summary">
                        <div class="summary-total-items"><span class="total-items"></span> Cart Summary</div>

                        
                        <div class="summary-total">
                        <div class="total-title">Total</div>
                        <div class="total-value final-value" id="basket-total">$<?php if(isset($total)){
                            echo $total;
                        } else echo '0';  ?></div>
                        </div>
                    
                        <div class="summary-checkout">
                           <a href="checkout.php" class="btn <?php if(isset($total)){echo '';}else echo 'disable'; ?>">Checkout</a>
                        </div>
                        
                    </div>
                </aside>
</div>

        
        
        
</div>

<?php
    include './templates/footer.php';

?>
