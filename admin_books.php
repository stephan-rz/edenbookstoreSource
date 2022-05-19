<?php

$title = 'Book Add';
include './templates/header.php';
include './php/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_POST['addBook'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = './src/uploads/'.$image;
   

    $select_books = mysqli_query($con, "SELECT * FROM books WHERE title = '$title'") or die('query failed');

    if(mysqli_num_rows($select_books) > 0){
        echo '<script>alert("Book already added!")</script>';
    }else {
        $sql = "INSERT INTO books (title, author, publisher, price, qty, category_id , description, image) VALUES ('$title', '$author', '$publisher', '$price', '$quantity', '$category', '$description', '$image')";
        $result = mysqli_query($con, $sql); 

        if($result){
            move_uploaded_file($image_tmp, $image_folder);
            echo '<script>alert("Book Added Successfully!"); 
            window.location.href="admin_books.php";</script>';  
        } else {
            echo '<script>alert("Book not added!")</script>';
        }
        
    }
    
    
}




?>

<div class="main-container">
    <div class="container">
        <div class="form-container">
            <h2>Add Book</h2>
            <form action="" method="post">

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="text" name="title" id="title" placeholder="Title" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="text" name="author" id="author" placeholder="Author" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="text" name="publisher" id="publisher" placeholder="Publisher" required>
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
                                <option value=" " disable selected>- Select Country -</option>
                                <option value="1">Action</option>
                                <option value="2">Adventure</option>
                                <option value="3">Comedy</option>
                                <option value="4">Crime</option>
                            </select>
                </div>

                <div class="input-field description-field">
                        <textarea name="description" id="description" cols="30" rows="15" placeholder="Description"></textarea>
                </div>

                <div class="input-field">
                    <i class="fas fa-book"></i>
                    <input type="file" accept="image/jpg, image/jpeg, image/png" name="image" id="image" placeholder="Image" required>
                </div>

                <input type="submit" name="addBook" value="Add Book" class="submit-btn btn">

</div>


<?php

include './templates/footer.php';
?>