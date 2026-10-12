<?php
require_once 'ketnoi.php';

$ds_khu_vuc = $conn->query("SELECT * FROM zone")->fetchAll(PDO::FETCH_ASSOC);

$thong_bao_loi = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_may = trim($_POST['computer_name']);
    $zone_id = $_POST['zone_id'];
    $cau_hinh = trim($_POST['specs']);
    $gia_tien = $_POST['hourly_price'];
    $ghi_chu = trim($_POST['note']);

    if ($ten_may == "" || $gia_tien == "") {
        $thong_bao_loi = "Vui lòng nhập tên máy và giá tiền!";
    } else {
        $sql = "INSERT INTO may (computer_name, zone_id, specs, hourly_price, status, note) VALUES (?, ?, ?, ?, 'offline', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ten_may, $zone_id, $cau_hinh, $gia_tien, $ghi_chu]);

        header("Location: ds_may.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Máy Tính</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">THÊM MÁY TÍNH MỚI</h3>

                <?php if ($thong_bao_loi != ""): ?>
                    <div class="alert alert-danger"><?= $thong_bao_loi ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên máy:</label>
                        <input type="text" name="computer_name" class="form-control" placeholder="Ví dụ: MAY-04" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Khu vực:</label>
                        <select name="zone_id" class="form-select">
                            <?php foreach ($ds_khu_vuc as $kv): ?>
                                <option value="<?= $kv['id'] ?>"><?= $kv['zone_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cấu hình máy:</label>
                        <textarea name="specs" class="form-control" rows="2" placeholder="CPU, RAM, VGA..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá tiền / giờ (VNĐ):</label>
                        <input type="number" name="hourly_price" class="form-control" value="8000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú:</label>
                    <input type="text" name="note" class="form-control" placeholder="Tình trạng máy...">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="ds_may.php" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
