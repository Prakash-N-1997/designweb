<?php
//POST
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

//not empty
if(!empty($firstname) || !empty($lastname) || !empty($email) || !empty($password) || !empty($cpassword))
{

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "design";


    //Create Connectiom

    $conn = new mysqli ($host,$dbusername,$dbpassword,$dbname);

    if(mysqli_connect_error()){
        die('Connect Error 
        ('.mysqli_connect_errno().')'
        .mysqli_connect_error);
    }
    else{
        $SELECT = "SELECT email From signup where email = ? Limit 1";
        $INSERT = "INSERT into signup (firstname,lastname,email,password,cpassword) values (?,?,?,?,?)";


        //Prepare statement
        $stmt = $conn->prepare ($SELECT);
        $stmt ->bind_param("s",$email);
        $stmt ->execute();
        $stmt ->bind_result($email);
        $stmt ->store_result();
        $rnum = $stmt->num_rows;

        //checking username
        if($rnum==0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssss",$firstname,$lastname,$email,$password,$cpassword);
            $stmt->execute();
            echo "New record inserted successfully";
        } else{
            echo"Someone already register using this email";
        }
        $stmt->close();
        
    }
} else{
    echo "All field are required";
    die();
}

?>