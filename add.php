<?php

include('config/db_connect.php');


$title = '';
$email = '';
$ingredients = '';

$errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');


if(isset($_POST['submit'])) {    //checks if the submit has a value 
 
    /*htmlspecailchars() takes data being inputed in the form and turns them into
     html entities, which are safe strings, protects from attacks */


    //check email 
    if(empty($_POST['email'])){
         $errors['email'] = "Email is required <br/>";
    } else {
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] =  "A valid email is required";
        }
    }

    
//check title 
    if (empty($_POST['title'])){
         $errors['title'] = "A title is required <br/>";
    } else {
          $title = $_POST['title'];
          if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {     //regular expression 
             $errors['title'] = "Title must contain letters and spaces only";
          }
    }



//check ingredients 
    if (empty($_POST['ingredients'])) {
         $errors['ingredients'] = "At least one ingredient is required <br/>";
    } else {
        
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
             $errors['ingredients'] = "Ingredients must be only letter and be seperated by commas";
        }

    }
// end of POST check 

    //check if there is not any errors in the form - - if no errors, redirect to homepage

    if(array_filter($errors)){   //if this returns false, there are not any errors. If it returns true, there are errors 

      //  echo 'Errors in the form';
     } else {

        $email = mysqli_real_escape_string($conn, $_POST['email'] );
         $title = mysqli_real_escape_string($conn, $_POST['title'] );
          $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients'] );


    // create sql 

    $sql = "INSERT INTO pizza(title,email,ingredients) VALUES('$title', '$email', '$ingredients')";


    //save to db and check 

    if(mysqli_query($conn, $sql)){
        //sucsss
        header('Location: index.php');
    } else {
        //error
        echo 'query error:' . mysqli_error($conn);
    }


  
     }

}  



?>

<!DOCTYPE html>
<html lang="en">

    <?php include 'templates/header.php' ?>

    <section class="container grey-text">
        <h4 class="center">Create Your Pizza</h4>
        <form action="add.php " class="white" method="POST">

            <label for="">Your Email:</label>
            <input type="text" name="email" value="<?php echo $email ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>
            <label for="">Pizza Ttile:</label>
            <input type="text" name="title" value="<?php echo $title ?>">
             <div class="red-text"><?php echo $errors['title']; ?></div>
            <label for="">Ingredients (comma seperated):</label>
            <input type="text" name="ingredients" value="<?php echo $ingredients ?>">
             <div class="red-text"><?php echo $errors['ingredients']; ?></div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn submit brand z-depth-0">
            </div>

        </form>
    </section>


     <?php include 'templates/footer.php' ?>

</html>