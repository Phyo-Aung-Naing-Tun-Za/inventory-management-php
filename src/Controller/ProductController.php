<?php
namespace App\Controller;

require_once("vendor/autoload.php");
use App\Database\DB;
use PDO;


class ProductController
{
    private $db;
    public function __construct()
    {
        $con = new DB();
        $this->db = $con->connect();
    }

    public function createCtg()
    {
        $data = $_POST;
        $statement = $this->db->prepare("INSERT INTO `categories` (`parent_cat`,`category_name`) VALUES (:parent_cat, :category_name)");
        $statement->bindParam(":parent_cat", $data['parent_cat']);
        $statement->bindParam(":category_name", $data['category_name']);
        if ($statement->execute()) {
            echo "Category Created Successfully";
        } else {
            echo "fail";
        }

    }

    public function getMainCtgs()
    {
        if (isset($_GET['parentId'])) {
            $parentId = $_GET['parentId'];
        }
        $statement = $this->db->query("SELECT * FROM `categories` WHERE `parent_cat` = 0");
        $cats = $statement->fetchAll(PDO::FETCH_OBJ);
        if ($cats) {
            if ($parentId == "Root") {
                echo "<option selected value=0>Root</option>";
            } else {
                echo "<option value=0>Root</option>";
            }
            foreach ($cats as $cat) {
                if ($cat->category_name == $parentId) {
                    echo "<option selected value='$cat->id'>$cat->category_name</option>";
                } else {
                    echo "<option value='$cat->id'>$cat->category_name</option>";
                }
            }
        } else {
            echo "Something Wrong";
        }
    }

    public function getSubCtgs()
    {    
        $statement = $this->db->query("SELECT * FROM `categories` WHERE `parent_cat` != 0");
        $cats = $statement->fetchAll(PDO::FETCH_OBJ);
        if ($cats) {
            echo "<option selected value=''>Select Category</option>";
            foreach ($cats as $cat) {
                echo "<option value='$cat->id'>$cat->category_name</option>";
            }
        } else {
            echo "Something Wrong";
        }
    }

    public function getAllCtg()
    {
        $page = $_POST["page"];

        if ($page > 1) {
            $page = ($page * 10) - 10;
        } elseif ($page == 1) {
            $page = 0;
        }
        $statement = $this->db->query("select p.id,c.category_name as parent,p.category_name as category,p.status from categories p left join  categories c on c.id = p.parent_cat LIMIT $page,10");
        $categories = $statement->fetchAll(PDO::FETCH_OBJ);
        $jCata = json_encode($categories);
        echo $jCata;
    }

    public function manageCtg()
    {
        view("categories-manage.php");
    }

    public function updateCtg()
    {
        if (isset($_POST['category_name'])) {
            $category = $_POST;
            $statement = $this->db->prepare("UPDATE `categories` SET `category_name` = :category_name, `parent_cat` = :parent_cat WHERE `id` = :id");
            $statement->bindParam(":category_name", $category['category_name']);
            $statement->bindParam(":parent_cat", $category['parent_cat']);
            $statement->bindParam(":id", $category['id']);
            if ($statement->execute() == true) {
                echo "Successfully updated";
            } else {
                echo "Fail to update";
            }
            ;

        } elseif (isset($_POST['status'])) {
            $data = $_POST;
            $statement = $this->db->prepare("UPDATE `categories` SET `status` = :status WHERE `id` = :id");
            if ($data['status'] == 0) {
                $statement->bindParam(":status", $data["status"]);
            } elseif ($data['status'] == 1) {
                $statement->bindParam(":status", $data["status"]);
            }
            $statement->bindParam(":id", $data['id']);
            if ($statement->execute() == true) {
                echo "success";
            } else {
                echo "fail";
            }


        } else {
            echo "No Category";
        }
    }

    public function deleteCtg()
    {
        $id = $_POST['id'];
        $statement = $this->db->prepare("DELETE FROM `categories` WHERE `id` = :id");
        $statement->bindParam(":id", $id);
        if ($statement->execute()) {
            echo "Delete Successfully";
        } else {
            echo "Delete Fail";
        }

    }

    public function getLength()
    {
        $table = $_GET['table'];
        $statement = $this->db->query("SELECT COUNT(*) FROM `$table`");
        $count = $statement->fetch();
        echo $count[0];
    }


    public function manageBrand()
    {

        view("brand-manage.php");
    }

    public function getBrands()
    {
        if(isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        if (isset($_GET['m'])) {
            $statement = $this->db->query("SELECT * FROM `brands`");
            $brands = $statement->fetchAll(PDO::FETCH_OBJ);
            if ($brands) {
                echo "<option  selected value=''>Select Brand</option>";
                foreach ($brands as $brand) {
                    echo "<option value='$brand->id'>$brand->b_name</option>";
                }
            } else {
                echo "Something Wrong";
            }

        } else {
            $page = $_POST["page"];
            if ($page > 1) {
                $page = ($page * 10) - 10;
            } elseif ($page == 1) {
                $page = 0;
            }
            $statement = $this->db->query("SELECT * FROM `brands` LIMIT $page,10");
            $brands = $statement->fetchAll(PDO::FETCH_OBJ);
            if ($brands) {
                $jCata = json_encode($brands);
                echo $jCata;
            } else {
                echo "Something Wrong";
            }
        }
    }


    public function createBrand()
    {
        $data = $_POST;
        $statement = $this->db->prepare('INSERT INTO `brands` (`b_name`) VALUES (:b_name)');
        $statement->bindParam(":b_name", $data['b_name']);
        if ($statement->execute()) {
            echo "Created brand successfully";
        } else {
            echo "Failed to create brand";
        }
    }

    public function updateBrand()
    {
        if (isset($_POST['b_name'])) {
            $brand = $_POST;
            $statement = $this->db->prepare("UPDATE `brands` SET `b_name` = :b_name WHERE `id` = :id");
            $statement->bindParam(":b_name", $brand['b_name']);
            $statement->bindParam(":id", $brand['id']);
            if ($statement->execute() == true) {
                echo "Successfully updated";
            } else {
                echo "Fail to update";
            }
            ;

        } elseif (isset($_POST['status'])) {
            $data = $_POST;
            $statement = $this->db->prepare("UPDATE `brands` SET `status` = :status WHERE `id` = :id");
            if ($data['status'] == 0) {
                $statement->bindParam(":status", $data["status"]);
            } elseif ($data['status'] == 1) {
                $statement->bindParam(":status", $data["status"]);
            }
            $statement->bindParam(":id", $data['id']);
            if ($statement->execute() == true) {
                echo "success";
            } else {
                echo "fail";
            }


        } else {
            echo "No Brand";
        }
    }

    public function deleteBrand()
    {
        $id = $_POST['id'];
        $statement = $this->db->prepare("DELETE FROM `brands` WHERE `id` = :id");
        $statement->bindParam(":id", $id);
        if ($statement->execute()) {
            echo "Delete Successfully";
        } else {
            echo "Delete Fail";
        }
    }

    public function createImg($file)
    {
        $name = date("d-M-Y-H:i:s") . $file["full_path"];
        $tmp_location = $file["tmp_name"];
        $error = $file["error"];
        $type = $file["type"];
        $img_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
        if (!$error && in_array($type, $img_types)) {
            if (move_uploaded_file($tmp_location, "public/images/$name")) {
                return $name;
            } else {
                return false;
            }
            ;
        } else {
            return false;
        }
    }

    public function createProduct()
    {
        $data = $_POST;
        $img = "no image";
        if (isset($_FILES['img']) && $_FILES['img']['name']) {
            $img = $this->createImg($_FILES['img']);
        }
        if ($img == false) {
            echo "Fail to upload Image";
        } else {
            if ($img == "no image") {
                $img = NULL;
            }
            $statement = $this->db->prepare("INSERT INTO `products` (`brand_id`, `category_id`, `product_name`, `price`, `stock`, `img`, `created_at`) VALUES (:brand_id, :category_id, :product_name, :price, :stock, :img, NOW())");
            $statement->bindParam(":brand_id", $data["brand"]);
            $statement->bindParam(":category_id", $data["category"]);
            $statement->bindParam(":product_name", $data["product_name"]);
            $statement->bindParam(":price", $data["price"]);
            $statement->bindParam(":stock", $data["stock"]);
            $statement->bindParam(":img", $img);
            if ($statement->execute()) {
                echo "success";
            } else {
                echo "Fail to creat product";
            }
        }
    }

    public function manageProduct()
    {
        view("product-manage.php");
    }

    public function getAllProducts()
    {
        $page = $_POST["page"];

        if ($page > 1) {
            $page = ($page * 5) - 5;
        } elseif ($page == 1) {
            $page = 0;
        }
        $statement = $this->db->query("SELECT 
        p.id,
        p.product_name,
        c.category_name,
        b.b_name,
        p.price,
        p.stock,
        p.img,
        p.created_at,
        p.updated_at,
        p.status
    FROM 
        products p 
    JOIN 
        categories c ON p.category_id = c.id 
    JOIN 
        brands b ON p.brand_id = b.id LIMIT $page,5");
        $categories = $statement->fetchAll(PDO::FETCH_OBJ);
        $jCata = json_encode($categories);
        echo $jCata;
    }

    public function updateProduct()
    {
        if (isset($_POST['product_name'])) {
            $product = $_POST;
            $statement = $this->db->prepare("UPDATE `products` SET 
            `product_name` = :product_name,
            `brand_id` = :brand_id, 
            `category_id` = :category_id, 
            `price` = :price, 
            `stock` = :stock, 
            `updated_at` = NOW() WHERE `id` = :id");
            $statement->bindParam(":id", $product['id']);
            $statement->bindParam(":product_name", $product['product_name']);
            $statement->bindParam(":brand_id", $product['brand']);
            $statement->bindParam(":category_id", $product['category']);
            $statement->bindParam(":price", $product['price']);
            $statement->bindParam(":stock", $product['stock']);
            if ($statement->execute() == true) {
                echo "Successfully updated";
            } else {
                echo "Fail to update";
            }
            ;

        } elseif (isset($_POST['status'])) {
            $data = $_POST;
            $statement = $this->db->prepare("UPDATE `products` SET `status` = :status WHERE `id` = :id");
            if ($data['status'] == 0) {
                $statement->bindParam(":status", $data["status"]);
            } elseif ($data['status'] == 1) {
                $statement->bindParam(":status", $data["status"]);
            }
            $statement->bindParam(":id", $data['id']);
            if ($statement->execute() == true) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "No Brand";
        }
    }

    public function updateImg()
    {
        $id = $_GET['id'];
        $currentImg = $_GET['img'];
        $img = "no image";
        
        if (isset($_FILES['img']) && $_FILES['img']['name']) {
            $img = $this->createImg($_FILES['img']);
        }
        if ($img == false) {
            echo "Fail to upload Image";
        }else{
            $statement = $this->db->prepare("UPDATE `products` SET `img` = :img WHERE `id` = :id");
            $statement->bindParam(":img", $img);
            $statement->bindParam(":id", $id);
            if($statement->execute() == true){
                if(file_exists("public/images/$currentImg")){
                    unlink("public/images/$currentImg");
                };
                echo 'success';
            }else{
                echo 'fail';
            }
        }
    }

    public function editProduct()
    {
        if(isset($_POST['id'])){
        $id = $_POST['id'];
        $statement = $this->db->prepare("SELECT * From `products` WHERE `id` = :id");
        $statement->bindParam(":id", $id);
        if($statement->execute()){
            $product = $statement->fetch(PDO::FETCH_ASSOC);
            $jProduct = json_encode($product);
            echo $jProduct;
        }else{
            echo "fail";
        }  
        }else{
            echo "fail";
        }
    }

    public function deleteProduct()
    {
        $id = $_POST['id'];
        $statement = $this->db->prepare("DELETE FROM `products` WHERE `id` = :id");
        $statement->bindParam(":id", $id);
        if ($statement->execute()) {
            echo "Delete Successfully";
        } else {
            echo "Delete Fail";
        }
    }

    public function searchItems()
    {   
            $columnName = $_GET["by"];
            $value = $_POST['value'];
            $statement = $this->db
            ->prepare("SELECT p.id,c.category_name as parent,p.category_name as category,p.status FROM categories p LEFT JOIN categories c on c.id = p.parent_cat WHERE p.$columnName LIKE '%$value%'");
            
            $statement->execute();
            
            $items = $statement->fetchAll(PDO::FETCH_OBJ);
            
            $jItems = json_encode($items);
            
            echo $jItems;  
    }
    public function searchProducts()
    {
            $columnName = $_GET["by"];
            $value = $_POST['value'];
            $statement = $this->db->prepare("SELECT 
            p.id,
            p.product_name,
            c.category_name,
            b.b_name,
            p.price,
            p.stock,
            p.img,
            p.created_at,
            p.updated_at,
            p.status
        FROM 
            products p 
        JOIN 
            categories c ON p.category_id = c.id 
        JOIN 
            brands b ON p.brand_id = b.id WHERE $columnName LIKE '%$value%'");
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_OBJ);
            $jProducts = json_encode($products);
            echo $jProducts;
    }

    public function searchBrands()
    {
        $columnName = $_GET["by"];
        $value = $_POST['value'];
        $statement = $this->db->prepare("SELECT * FROM `brands` WHERE `$columnName` LIKE '%$value%'");
        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_OBJ);
        $jItems = json_encode($items);
        echo $jItems;  
    }
}

