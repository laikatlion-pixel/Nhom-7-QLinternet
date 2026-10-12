<?php
require_once 'ketnoi.php';

$tu_khoa = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($tu_khoa != "") {
    $sql = "SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id WHERE may.computer_name LIKE ? OR zone.zone_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$tu_khoa%", "%$tu_khoa%"]);
} else {
    $sql = "SELECT may.*, zone.zone_name FROM may JOIN zone ON may.zone_id = zone.id";
    $stmt = $conn->query($sql);
}
$danh_sach = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Máy Tính Phòng Net</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h2 class="text-center mb-4">QUẢN LÝ DANH SÁCH MÁY TÍNH</h2>

        <!-- Thanh tìm kiếm và nút thêm mới -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm tên máy hoặc khu vực..." value="<?= htmlspecialchars($tu_khoa) ?>">
                    <button type="submit" class="btn btn-primary">Tìm</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="them_may.php" class="btn btn-success">+ Thêm máy mới</a>
            </div>
        </div>

        <!-- Bảng hiển thị -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên máy</th>
                            <th>Khu vực</th>
                            <th>Cấu hình</th>
                            <th>Giá/giờ</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($danh_sach) > 0): ?>
                            <?php foreach ($danh_sach as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><b><?= $row['computer_name'] ?></b></td>
                                <td><?= $row['zone_name'] ?></td>
                                <td><?= $row['specs'] ?></td>
                                <td><?= number_format($row['hourly_price']) ?> đ</td>
                                <td>
                                    <?php if($row['status'] == 'online'): ?>
                                        <span class="badge bg-success">Online</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Offline</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="sua_may.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="xoa_may.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa máy này không?');">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không tìm thấy máy nào trong hệ thống.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
