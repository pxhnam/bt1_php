<?php
class Product
{
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $price;
    public $warranty;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Đọc tất cả sản phẩm
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readOne($id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->price = $row['price'];
                $this->warranty = $row['warranty'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // Tạo sản phẩm mới
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price, warranty=:warranty";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->warranty = htmlspecialchars(strip_tags($this->warranty));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":warranty", $this->warranty);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật sản phẩm
    // Phương thức update() sẽ tương tự như create(), nhưng sử dụng câu lệnh SQL UPDATE

    // Cập nhật sản phẩm
    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
              SET
                name = :name,
                price = :price,
                warranty = :warranty
              WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->warranty = htmlspecialchars(strip_tags($this->warranty));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':warranty', $this->warranty);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    // Xóa sản phẩm
    // Phương thức delete() sẽ sử dụng câu lệnh SQL DELETE
    public function delete()
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
