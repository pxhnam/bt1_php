<?php
include_once 'config/db.php';
include_once 'classes/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Khi form được submit
if ($_POST) {
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->warranty = $_POST['warranty'];

    if ($product->create()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div>Có lỗi khi thêm sản phẩm.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm</title>
</head>

<body>
    <h1>Thêm Sản Phẩm Mới</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Tên sản phẩm: <input type="text" name="name" required><br>
        Giá sản phẩm: <input type="text" name="price" required><br>
        Bảo hành (tháng): <input type="number" name="warranty" required><br>
        <input type="submit" value="Thêm Sản Phẩm">
    </form>

    <h2>Danh sách sản phẩm</h2>
    <?php
    $stmt = $product->read();
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tên</th>";
        echo "<th>Giá</th>";
        echo "<th>Bảo hành (tháng)</th>";
        echo "<th>Ngày tạo</th>";
        echo "<th>Hành động</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$name</td>";
            echo "<td>$price</td>";
            echo "<td>$warranty</td>";
            echo "<td>$created_at</td>";
            echo "<td><a href='edit_product.php?id=$id'>Sửa</a> |
             <a href='delete_product.php?id=$id'>Xóa</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div>Không có sản phẩm nào.</div>";
    }
    ?>
</body>

</html>