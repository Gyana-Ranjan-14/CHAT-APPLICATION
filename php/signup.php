<?php
    session_start(); //Initialize session data
    include_once "config.php"; //include the config file 

    // take all the inputs 

    //mysqli_real_escape_string -> this function is used to create a legal SQL string that can be used in an SQL statement.
    //$conn ->  opens a new connection to the MySQL server
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // when all the data are inserted
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // filter_var -> Filters a variable with a specified filter
        //FILTER_VALIDATE_EMAIL -> filter validates an e-mail address
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // check the email is that already present in the database then show email already exist
            //mysqli_query ->  Performs a query on the database
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                echo "$email - This email already exist!";
            }else{

                // if file type is image
                if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    // create a temp name of the image
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    // if the uploaded img extension and our extension predefine are matched
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time(); //take the current time
                            $new_img_name = $time.$img_name; //save as new img
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){ //move that img file
                                $ran_id = rand(time(), 100000000); //create a random number
                                $status = "Active now";
                                //  md5 - > Calculate the md5 hash of a string
                                $encrypt_pass = md5($password);
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                if($insert_query){
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        //mysqli_fetch_assoc ->  Fetch a result row as an associative array
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>