<?php
include './../main.php';
    

    //Company Search
    if (isset($_POST['isSearch'])) {
        
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if (!empty($_POST['companyName'])){
            $t = $_POST['companyName'];
            $sql = sprintf("SELECT * FROM am_company WHERE company_name LIKE '%s';"
                , $t
                );

            $result =$conn->query($sql);
        } else {
            $result =$conn->query("SELECT * FROM am_company");
        }


        $rows = array();

        while($row = $result->fetch_assoc()) {
            //company general info

            
            //Get employees selected
            $empSQL = $sql = "SELECT *, "
            . "CASE  "
            . "	WHEN CE.company_id IS NULL THEN 'UNSEL' "
            . "    WHEN CE.company_id IS NOT NULL THEN 'SEL' "
            . "END AS Selected "
            . "FROM am_user U "
            . "	LEFT OUTER JOIN am_company_employs CE "
            . "    ON CE.user_id = U.user_id  "
            . "    AND CE.company_id = '" . $row["company_id"] . "';";

            $resultEmps =$conn->query($empSQL);
            while($r = $resultEmps->fetch_assoc()) { 
                $row['emp'][] = $r;
            }
           
            $rows[] = $row;
        }
       
        echo json_encode($rows);
        $conn->close();
        exit;
    }


    //Load Company
    if (isset($_POST['loadCompanyID'])){
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if (!empty($_POST['loadCompanyID'])){
            $t = $_POST['loadCompanyID'];
            $sql = sprintf("SELECT * FROM am_company WHERE company_id = '%s';"
                , $t
                );

            $result =$conn->query($sql);
        } else {
            $result =$conn->query("SELECT * FROM am_company");
        }

        $rows = array();
        while($row = $result->fetch_assoc()) {
            //General Primary Company Info
            $rows[] = $row;
        }
       
        echo json_encode($rows);
        $conn->close();
        exit;
    }

    //Save Company
    if (isset($_POST['isSave'])){
        $errors_array = array();

        if (empty($_POST['companyName'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Ensure all fields are entered properly.");
            echo json_encode($errors_array);
            exit;
        }

        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }

        if (empty($_POST['companyID'])){
            //Insert
            $companyID = getUUID($conn);
            $sql = sprintf("INSERT INTO am_company(company_id, company_name, company_desc) VALUES('%s','%s','%s')"
                , $companyID
                , $_POST['companyName']
                , $_POST['companyDesc']
                );
        } else {
            //Edit
            $companyID = $_POST['companyID'];
            $sql = sprintf("UPDATE am_company SET company_name='%s',company_desc='%s' WHERE company_id = '%s';"
                , $_POST['companyName']
                , $_POST['companyDesc']
                , $companyID
                );
        }

        $errors_array[] = array("status" => "DATA", "companyID" => $companyID);

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Company Saved!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }

    //Delete Company
    if (isset($_POST['isDelete'])){
        $errors_array = array();

        if (empty($_POST['companyID'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "No company is selected for delete.");
            echo json_encode($errors_array);
            exit;
        }

        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }

        //Delete
        $companyID = $_POST['companyID'];
        $sql = sprintf("DELETE FROM am_company WHERE company_id = '%s';"
            , $companyID
            );

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Company Deleted!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }

    //Delete Company User
    if (isset($_POST['isDeleteUser'])){
        $errors_array = array();

        if (empty($_POST['companyID'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "No company is selected for delete.");
            echo json_encode($errors_array);
            exit;
        }

        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }

        //Delete
        $companyID = $_POST['companyID'];
        $userID = $_POST['userID'];
        $sql = sprintf("DELETE FROM am_company_employs WHERE company_id = '%s' AND user_id = '%s';"
            , $companyID
            , $userID
            );

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Company Deleted!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }

    //Add User to Company
    if (isset($_POST['isAddUser'])){
        $errors_array = array();

        if (empty($_POST['firstName']) or empty($_POST['lastName'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Ensure all fields are entered properly.");
            echo json_encode($errors_array);
            exit;
        }

        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }

        
        //Find User
        $sql = sprintf("SELECT user_id FROM am_user WHERE first_name = '%s' and last_name = '%s';"
            , $_POST['firstName']
            , $_POST['lastName']
            );
    
        $result =$conn->query($sql);
        while($row = $result->fetch_assoc()) {
           
            $sql = sprintf("INSERT INTO am_company_employs (company_id, user_id) VALUES ('%s','%s');"
                , $_POST['companyID']
                , $row['user_id']
                );

            //Execute SQL
            if (mysqli_query($conn, $sql)) {
                //success
                $errors_array[] = array("status" => "SUCCESS", "message" => "Company Saved!");
            } else {
                $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
            }

        }
       

        $conn->close();
        echo json_encode($errors_array);
        exit;
    }




?>
