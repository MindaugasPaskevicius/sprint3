<?php

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM " . $table_name . " WHERE id = " . $id;
    $stmt = $conn->prepare($sql_delete);
    $stmt->execute();
    
    $_SESSION['message'] = "Record has been deleted";
    $_SESSION['msg_type'] = "danger";

    $stmt->close();
    mysqli_close($conn);
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '&'));
    exit;
}