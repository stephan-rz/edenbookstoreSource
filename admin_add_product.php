<?php

$title = 'Add Product';
include './php/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_POST['addProduct'])){

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $category = $_POST['category'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = './src/uploads/'.$image;

    $select_products = mysqli_query($con, "SELECT * FROM products WHERE title = '$title'") or die('query failed');

    if(mysqli_num_rows($select_products) > 0){
        echo '<script>alert("Product already added!")</script>';
    }else {
        $sql = "INSERT INTO products (title, price, qty, category_id , description, image) VALUES ('$title', '$price', '$quantity', '$category', '$description', '$image')";
        $result = mysqli_query($con, $sql);

        if($result){
            move_uploaded_file($image_tmp, $image_folder);
            echo '<script>alert("Product Added Successfully!"); 
            window.location.href="admin_product_list.php";</script>';  
            
        } else {
            echo '<script>alert("Product not added!")</script>';
        }
    }
}

include './templates/admin_header.php';
?>


<div class="main-container b-main">
    
<?php include './templates/admin_navigation.php' ?>

    <div class="container">
        <div class="form-container">
            <h2>Add Product</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="text" name="title" id="title" placeholder="Title" required>
                </div>


                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="number" min="0" name="price" id="price" placeholder="Price" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="text" name="qty" id="qty" placeholder="Quantity" required>
                </div>

                <div class="input-field">
                            <i class="fas fa-book"></i>
                            <select id="category" name="category" required>
                                <option value=" " disable selected>- Select Category -</option>
                                <?php
                                $select_category_names= mysqli_query($con, "SELECT * FROM categories") or die('query failed');
                                if(mysqli_num_rows($select_category_names) > 0){
                                    while($fetch_category_names = mysqli_fetch_assoc($select_category_names)){
                                ?>
                                <option value="<?php echo $fetch_category_names['id'];?>"><?php echo $fetch_category_names['name']; ?></option>
                                <?php
                                    }
                                } else {
                                    echo '<p class="empty">No categories found!</p>';
                                }
                                ?>
                            </select>
                </div>

                <div class="input-field description-field">
                    <textarea name="description" id="description" cols="30" rows="15" placeholder="Description"></textarea>
                </div>

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" name="image" id="image" placeholder="Image" required>
                </div>

                <input type="submit" name="addProduct" value="Add Product" class="submit-btn btn">
            </form>
        </div>
    </div>
</div>


<?php

include './templates/footer.php';
?>