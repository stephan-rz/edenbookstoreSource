<?php

include './php/config.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/logged_user_header.css">
    <link rel="stylesheet" type="text/css" href="./css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <script src="./js/form.js" defer></script>
    <script src="./js/script.js" defer></script>

    <title>
        <?php echo $title; ?>
    </title>
</head>

<body>

    <header>
        <div class="header">
            <div class="top-container">
                <div class="logo">
                    <a href="index.php" class="brand-logo">
                        <img src="./src/logo.png" alt="logo" id="logo">
                    </a>
                </div>
                
                <div class="bottom-container">
                <nav>
                    <div class="nav-links">
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a href="aboutus.php ">About Us</a></li>
                            <li><a href="shop.php ">Shop</a></li>
                            <li><a href="faq.php ">FAQ</a></li>
                            <li><a href="contactus.php ">Contact</a></li>

                        </ul>
                    </div>
                </nav>
            </div>
                
                <div class="cart-icon">
                        <?php
                        $select_cart_number = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                        $cart_rows_number = mysqli_num_rows($select_cart_number); 
                        ?>
                        <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
                </div>

                <div class="user-box">
                    
                
                    <div class="user-button">
                        <span>
                            <img src="./src/logged_profile.svg " alt=" " style="margin-right:5px; width:30px; height:auto ">
                        </span><?php echo $_SESSION['user_name']; ?><i class="fa-solid fa-angle-down" id="user-popup-dropdown" style="margin-left:10px;"></i>

                    </div>
                    
                    <div class="user-box-popup">
                        <div class="user-list">
                            <a href="user_dashboard.php">
                                <i class="fa-solid fa-user-circle"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="logout.php">
                                <i class="fa-solid fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
                

            </div>
            
        </div>
    </header>
    