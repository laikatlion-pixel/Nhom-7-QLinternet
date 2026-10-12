<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "may_tinh";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Lỗi kết nối cơ sở dữ liệu rồi: " . $e->getMessage();
    exit();
}
?>
