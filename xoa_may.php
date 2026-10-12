<?php
require_once 'ketnoi.php';

if (isset($_GET['id'])) {
    $id_may = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM may WHERE id = ?");
    $stmt->execute([$id_may]);
    
}

header("Location: ds_may.php");
exit();
?>
