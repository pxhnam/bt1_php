<?php
include_once 'config/db.php';
include_once 'classes/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Xử lý form submit để cập nhật sản phẩm
if ($_POST && isset($_POST['id'])) {
    $product->id = $_POST['id'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->warranty = $_POST['warranty'];

    if ($product->update()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Không thể cập nhật sản phẩm.</div>";
    }
}

// Giả sử bạn có một biến $id để biết sản phẩm nào sẽ được sửa
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Đọc thông tin sản phẩm hiện tại từ database
$product->readOne($id);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sửa Sản Phẩm</title>
</head>

<body>
    <h1>Sửa Sản Phẩm</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Tên sản phẩm</td>
                <td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' /></td>
            </tr>
            <tr>
                <td>Giá</td>
                <td><input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' /></td>
            </tr>
            <tr>
                <td>Bảo hành (tháng)</td>
                <td><input type='text' name='warranty' value='<?php echo $product->warranty; ?>' class='form-control' /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='hidden' name='id' value='<?php echo $id; ?>' />
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>