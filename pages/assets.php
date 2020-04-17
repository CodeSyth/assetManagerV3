<?php
include './../main.php';
        
    //Asset Search
    if (isset($_POST['isSearch'])) {
            
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        $sql = "SELECT * FROM am_asset A LEFT OUTER JOIN am_company C on C.company_id = A.owning_company_id ";
        $isFirst = true;

        if (!empty($_POST['assetName'])){
            if ($isFirst) {
                $sql = $sql . sprintf(" WHERE a_name LIKE '%s'", $_POST['assetName']); 
                $isFirst = false;   
            }
        } 

        if (!empty($_POST['code'])){
            if ($isFirst) {
                $sql = $sql . sprintf("  WHERE code LIKE '%s'", $_POST['code']);    
                $isFirst = false;   
            } else {
                $sql = $sql . sprintf("  AND code LIKE '%s'", $_POST['code']);    
            }
        } 

        if (!empty($_POST['status'])){
            if ($isFirst) {
                $sql = $sql . sprintf("  WHERE status LIKE '%s'", $_POST['status']);    
                $isFirst = false;   
            } else {
                $sql = $sql . sprintf("  AND status LIKE '%s'", $_POST['status']);    
            }
        } 

        if (!empty($_POST['type'])){
            if ($isFirst) {
                $sql = $sql . sprintf("  WHERE a_type LIKE '%s'", $_POST['type']);    
                $isFirst = false;   
            } else {
                $sql = $sql . sprintf("  AND a_type LIKE '%s'", $_POST['type']);    
            }
        } 
        
        $sql = $sql . sprintf(";");
        // echo $sql . "\n";    
        $result = $conn->query($sql);


        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        echo json_encode($rows);
        $conn->close();
        exit;
    }

    //Load Company
    if (isset($_POST['isLoadCompany'])){
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        $result =$conn->query("SELECT * FROM am_company");

        $rows = array();
        while($row = $result->fetch_assoc()) {
            //General Primary Company Info
            $rows[] = $row;
        }
       
        echo json_encode($rows);
        $conn->close();
        exit;
    }

    //Save Asset
    if (isset($_POST['isSave'])){
        $errors_array = array();

        if (empty($_POST['name'])) {
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

        if (empty($_POST['assetID'])){
            //Insert
            $assetID = getUUID($conn);
            $sql = sprintf("INSERT INTO am_asset(asset_id, a_name, a_desc, a_type, code, status, purchase_date, purchase_price, qty, serial_num, owning_company_id) "
                       .   "VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')"
                , $assetID
                , $_POST['name']
                , $_POST['desc']
                , $_POST['type']
                , $_POST['code']
                , $_POST['status']
                , $_POST['pdate']
                , $_POST['price']
                , $_POST['qty']
                , $_POST['serialNum']
                , $_POST['owningCompany']
                );
        } else {
            //Edit
            $assetID = $_POST['assetID'];
            $sql = sprintf("UPDATE am_asset SET a_name='%s',a_desc='%s',a_type='%s',code='%s',status='%s',purchase_date='%s',purchase_price='%s',qty='%s',serial_num='%s',owning_company_id='%s' WHERE asset_id = '%s';"
                    , $_POST['name']
                    , $_POST['desc']
                    , $_POST['type']
                    , $_POST['code']
                    , $_POST['status']
                    , $_POST['pdate']
                    , $_POST['price']
                    , $_POST['qty']
                    , $_POST['serialNum']
                    , $_POST['owningCompany']
                    , $assetID
                );
        }

        $errors_array[] = array("status" => "DATA", "assetID" => $assetID);

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Asset Saved!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }

    //Delete Asset
    if (isset($_POST['isDelete'])){
        $errors_array = array();

        if (empty($_POST['assetID'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "No asset is selected for delete.");
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
        $companyID = $_POST['assetID'];
        $sql = sprintf("DELETE FROM am_asset WHERE asset_id = '%s';"
            , $companyID
            );

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Asset Deleted!");
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
