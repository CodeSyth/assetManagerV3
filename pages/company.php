<?php
include './../main.php';
    

    //Company Search
    if (isset($_POST['companyName'])) {
        
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if (!empty($_POST['companyName'])){
            $result =$conn->query("SELECT * FROM am_company WHERE company_name = "+$_POST['companyName']+";");
        } else {
            $result =$conn->query("SELECT * FROM am_company");
        }

        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
       
        echo json_encode($rows);
        $conn->close();
        exit;
    }

?>
