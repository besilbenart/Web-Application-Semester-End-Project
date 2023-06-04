<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST('phone')
$personaladdress = $_POST['personaladdress'];
$businesslocation = $_POST['businesslocation'];
$businessname = $_POST['businessname'];
$startdate = $_POST['startdate'];
$finishdate = $_POST['finishdate'];

if (!empty($name) || !empty($email) || !empty($phone) || !empty($personaladdress) || !empty($businesslocation)
     || !empty($businessname) || !empty($startdate) || !empty($finishdate))
{ 
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "registration_db";

    //Create a connection
    $conn = new mysqli($name, $email, $phone, $personaladdress, $businesslocation, $businessname,$startdate, $finishdate);

    if(mysqli_connect_error()){
        die('Connect error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }else{
        $SELECT = "SELECT email From register_form Where email =? Limit 1";
        $INSERT = "INSERT into register_form (name, email, phone, personaladdress, businesslocation, businessname, startdate, finishdate) Values (?,?,?,?,?,?,?,?)";


        //Preapre statement
        $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("s" , $email);
        $stmt ->execute();
        $stmt ->bind_results($email);
        $stmt ->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0){
            $stmt ->close();
            $stmt = $conn ->prepare($INSERT);
            $stmt -> bind_param("ssssii",$name, $email, $phone, $personaladdress, $businesslocation, $businessname,$startdate, $finishdate);
            $stmt->execute();

            echo"New record Inserted successfully";
        }else{
            echo "Someone has already registered using this Email";
        }
        $stmt->close();
        $conn->close();
    }
}else{
    echo "All fields are required";
    die();
}
?>