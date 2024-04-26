<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/header.css">
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

                <div class="login">
                    <a href="login.php"><button>Log In</button></a>
                    <a href="register.php "><button>
                    <span>
                        <img src="./src/profile.svg " alt=" " style="margin-right:5px; width:20px; height:auto ">
                    </span>
                    <span>Sign Up</span>
                </button></a>
                </div>

            </div>
           
        </div>
    </header>