<?php

$title = 'Dashboard';
include './php/config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

include './templates/user_header.php';

if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    $sql = "DELETE FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<script>alert("Account Deleted Successfully!"); 
        window.location.href="register.php";</script>';  
    } else {
        echo '<script>alert("Account not deleted!")</script>';
    }
}


if(isset($_POST['update-btn'])){

    $update_id = $_POST['update_id'];
    $update_firstName = mysqli_real_escape_string($con, $_POST['update_firstName']);
    $update_lastName = mysqli_real_escape_string($con, $_POST['update_lastName']);
    $update_email = mysqli_real_escape_string($con, $_POST['update_email']);
    $update_phone = mysqli_real_escape_string($con, $_POST['update_phone']);
    $update_address = mysqli_real_escape_string($con, $_POST['update_address']);
    $update_city = mysqli_real_escape_string($con, $_POST['update_city']);
    $update_state = mysqli_real_escape_string($con, $_POST['update_state']);
    $update_zipCode = mysqli_real_escape_string($con, $_POST['update_zipCode']);
    $update_country = mysqli_real_escape_string($con, $_POST['update_country']);


    $update_sql = mysqli_query($con, "UPDATE users SET firstName = '$update_firstName', lastName = '$update_lastName', email = '$update_email', phone = '$update_phone', address = '$update_address', city = '$update_city', state = '$update_state', zipCode = '$update_zipCode', country = '$update_country' WHERE id = '$update_id'") or die('query failed');


}



?>

<link rel="stylesheet" href="./user_dashboard.css">

<div class="main-container product-main">

<?php include './templates/user_navigation.php' 
?>


        <div class="form-container" style="margin-bottom:80px">
            <h3>Your Account Details</h3>
            <?php
                $select_user = mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id'") or die('query failed');

                if(mysqli_num_rows($select_user) > 0){
                    while($fetch_user = mysqli_fetch_assoc($select_user)) {
                ?>

                <form action="" method="POST">
                    <input type="hidden" name="update_id" value="<?php echo $fetch_user['id']; ?>">
                    <div class="half-container">
                        <div >
                        <label for="firstName">First Name</label>
                        <div class="input-field half-column">
                            <i class="fas fa-user"></i>
                            <input type="text" name="update_firstName" id="firstName" value="<?php echo $fetch_user['firstName']; ?>" required>
                        </div>
                        </div>
                        <div>
                        <label for="lastName">Last Name</label>
                        <div class="input-field half-column">
                        
                            <i class="fas fa-user"></i>
                            <input type="text" name="update_lastName" id="lastName" value="<?php echo $fetch_user['lastName']; ?>" required>
                        </div>

                        </div>
                        

                    </div>
                    <div class="full-width">
                        <label for="email">Email</label>   
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="update_email" id="email" value="<?php echo $fetch_user['email']; ?>" required>
                    </div>
                    </div>

                    <div class="full-width">
                        <label for="phone">Phone Number</label> 
                    <div class="input-field ">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="update_phone" id="phone" value="<?php echo $fetch_user['phone']; ?>" required>
                    </div>
                    </div>

                    <div class="full-width">
                        <label for="phone">Street Address</label> 
                    <div class="input-field ">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="update_address" id="address" value="<?php echo $fetch_user['address']; ?>" required>
                    </div>
                    </div>

                    <div class="half-container">
                    <div class="full-width">
                        <label for="phone">City</label> 
                        <div class="input-field half-column">
                            <i class="fa-solid fa-city "></i>
                            <input type="text " name="update_city" id="city" value="<?php echo $fetch_user['city']; ?>" required>
                        </div>
                        </div>
                    <div class="full-width">
                        <label for="phone">State/ Province</label> 
                        <div class="input-field half-column">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <input type="text" name="update_state" id="state" value="<?php echo $fetch_user['state']; ?>" required>
                        </div>
                        </div>
                    </div>

                    <div class="half-container">
                    <div class="full-width">
                    <label for="phone">Postal/ Zip Code</label> 
                        <div class="input-field half-column">
                            <i class="fa-brands fa-usps"></i>
                            <input type="text" name="update_zipCode" id="zipCode" value="<?php echo $fetch_user['zipCode']; ?>" required>
                        </div>
                    </div>
                    <div class="full-width">
                    <label for="phone">Country</label> 
                        <div class="input-field half-column">
                            <i class="fa-solid fa-earth-africa"></i>
                            <select id="country" name="update_country" required>
                                <option value="<?php echo $fetch_user['country']; ?>" disable selected><?php echo $fetch_user['country']; ?></option>
                                <option value="australia">Sri Lanka</option>
                                <option value="australia">Australia</option>
                                <option value="canada">Canada</option>
                                <option value="usa">USA</option>
                            </select>
                        </div>
                    </div>

                    </div>
                        <div class="form-btn-div">
                        <input type="submit" value="Update Details" name="update-btn" class="btn" id="update-btn">
                        <a href="user_dashboard.php?delete=<?php echo $fetch_user['id']; ?>" onclick="return confirm('Do you want to delete this account ?'"><input type="submit" value="Delete Account" name="delete" class="btn delete-btn" id="delete-btn"></a>      

                        </div>
                </form>
                <?php
                    }
                    } else {
                        echo '<h1>User not found</h1>';
                    }
                ?>        
                
        </div>







</div>







<?php

include './templates/footer.php';

?>