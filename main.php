<?php
function getUUID($conn) {
    $result = $conn->query("SELECT uuid() as ID;");
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            return $row["ID"];
        }
    } else {
        return "";
    }
}

?>