<?php
include_once 'config/db.php';
include_once 'classes/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Xử lý form submit để xóa sản phẩm
if ($_POST && isset($_POST['id'])) {
    $product->id = $_POST['id'];

    if ($product->delete()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Không thể xóa sản phẩm.</div>";
    }
}

// Giả sử bạn có một biến $id để biết sản phẩm nào sẽ được xóa
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Đọc thông tin sản phẩm hiện tại từ database
$product->readOne($id);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Xóa Sản Phẩm</title>
</head>

<body>
    <h1>Xóa Sản Phẩm</h1>

    <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
    <p>Tên sản phẩm: <?php echo $product->name; ?></p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
        <input type='hidden' name='id' value='<?php echo $id; ?>' />
        <button type="submit" class="btn btn-danger">Xóa</button>
        <a href="index.php" class="btn btn-default">Hủy</a>
    </form>

</body>

</html>