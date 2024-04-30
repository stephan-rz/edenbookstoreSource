<?php

$title = 'Add Product Category';
include './php/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}


if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id = '$id'";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<script>alert("Product Category Deleted Successfully!"); 
        window.location.href="admin_category.php";</script>';  
    } else {
        echo '<script>alert("Product Category not deleted!")</script>';
    }
}


if(isset($_POST['update'])){

    $update_id = $_POST['update_id'];
    $update_cat_name = mysqli_real_escape_string($con, $_POST['update_name']);

    $update_sql = mysqli_query($con, "UPDATE categories SET name = '$update_cat_name' WHERE id = '$update_id'") or die('query failed');

    header('location:admin_category.php');

}


if(isset($_POST['addCategory'])){

    $category = mysqli_real_escape_string($con, $_POST['category']);


    $select_product_category = mysqli_query($con, "SELECT * FROM categories WHERE name = '$category'") or die('query failed');

    if(mysqli_num_rows($select_product_category) > 0){
        echo '<script>alert("Product Category already added!")</script>';
    }else {
        $sql = "INSERT INTO categories (name) VALUES ('$category')";
        $result = mysqli_query($con, $sql);

        if($result){
            echo '<script>alert("Product Category Added Successfully!"); 
            window.location.href="admin_category.php";</script>';  
            
        } else {
            echo '<script>alert("Product Category not added!")</script>';
        }
    }
}

include './templates/admin_header.php';

?>

<link rel="stylesheet" href="./css/admin_category_add.css">

<div class="main-container b-main">
    
    <?php include './templates/admin_navigation.php' ?>

    <div class="category-container">
        <div class="category-list">
            <h2>Our Product Categories</h2><br>
            <ul>
                <?php
                    $select_product_category = mysqli_query($con, "SELECT * FROM categories") or die('query failed');

                    if(mysqli_num_rows($select_product_category) > 0){
                        while($fetch_product_category = mysqli_fetch_assoc($select_product_category)){
                ?>
                    <li><i class="fas fa-book"></i><span><?php echo $fetch_product_category['name']; ?></span> - 
                    <a href="admin_category.php?delete=<?php echo $fetch_product_category['id']; ?>" onclick="return confirm('Delete this product category?')">Delete</a>/ 
                    <a href="admin_category.php?update=<?php echo $fetch_product_category['id']; ?>">Edit</a></li>

                    
                    <?php
                 }

                 
                } else {
                    echo '<p class="empty">No product categories found!</p>';
                }
            ?>          
            </ul>  
            
            <?php
            if(isset($_GET['update'])){
                $id = $_GET['update'];
                $update_query = mysqli_query($con, "SELECT * FROM categories WHERE id = '$id'") or die('query failed');
                
                if(mysqli_num_rows($update_query) > 0){
                    while($fetch_update = mysqli_fetch_assoc($update_query)){
        ?>
            <form action="" method="post" id="cat-change-form">
                <label for="update_name">Edit Category Name :</label>
                <div class="input-field cat-input-field">
                        <input type="hidden" name="update_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="text" name="update_name" id="update_name" placeholder="Title" value="<?php echo $fetch_update['name']; ?>" required>
                    </div>
                    <div class="card-btns">
                        <input type="submit" name="update" value="Update" class="btn update-btn">
                        <input type="reset" name="cancel" value="Close" id="close-cat-update" class="btn">
                </div>       

            </form>
            

                <?php
            }
        
        }
        
        }else{
            echo '<script>document.querySelector("#cat-change-form").style.display = "none";</script>';
        }
    

        ?>

        </div>
        <div class="container">
            <div class="form-container">
                <h2>Add Product Category</h2>
                <form action="" method="post">

                    <div class="input-field">
                        <i class="fas fa-book"></i>
                        <input type="text" name="category" id="category" placeholder="category" required>
                    </div>


                    <input type="submit" name="addCategory" value="Add Product Category" class="submit-btn btn">
                </form>
            </div>
        </div>

    </div>
    
</div>

<script>
    document.querySelector('#close-cat-update').onclick = () => {

document.querySelector('#cat-change-form').style.display = 'none';
}
</script>

<?php

include './templates/footer.php';
?>