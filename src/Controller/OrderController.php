<?php 
    namespace App\Controller;

    require_once("vendor/autoload.php");
    use App\Database\DB;
    use PDO;
class OrderController{
    private $db;
    public function __construct() {
        $db = new DB();
        $this->db = $db->connect();
    }
    public function order()
    {
        view("order.php");
    }
    public function getProducts()
    {
        $statement = $this->db->query("SELECT `id`,`product_name` FROM `products` WHERE `stock` > 0");
        $products = $statement->fetchAll(PDO::FETCH_OBJ);
        function option($products){
            $options = "<option value=''>Select a product</option>";
            foreach($products as $product){
                $options .= "<option id=`$product->id` value='$product->product_name'>$product->product_name</option>";
            }
            return $options;
        };
        $tr = "<tr>
        <td  class='text-secondary pe-3 order-count'>1</td>
        <td class='text-secondary pe-3'>
            <select style='width:200px' class='form-select' name='product_name[]' id='product_name'>
        ".
            option($products)
            ."</select>
        </td>
        <td  class='text-secondary pe-3'>
            <input disabled style='width:170px' class='form-control' type='number' name='t_quentity' id='t_quentity' >
        </td>
        <td class='text-secondary pe-3'>
            <input  style='width:170px' class='form-control' type='number' name='quentity[]' id='quentity' min=1>
        </td>
        <td class='text-secondary pe-3'>
            <input readonly style='background:#ebedeb;'  style='width:170px' class='form-control' type='number' name='price[]' id='price' >
        </td>
        <td id='t_price' class='text-secondary pe-3 total'>0</td>
    </tr>";

    echo $tr;
    }

    public function deleteProducts()
    {
        for($i = 0; $i < count($_POST['products']); $i++ ){
            $p_name =  $_POST['products'][$i]['product'];
            $p_quentity = $_POST['products'][$i]['quentity'];
            $statement = $this->db->prepare("SELECT `stock` FROM `products` WHERE `product_name` LIKE '%$p_name%'");
            if($statement->execute()){
                $quentity = $statement->fetch(PDO::FETCH_OBJ);
                $update_qty = $quentity->stock - $p_quentity;
                $statement = $this->db->prepare("UPDATE `products` SET `stock` = $update_qty WHERE `product_name` LIKE '%$p_name%'");
                $statement->execute();
            }
        }
    }
    public function getSingleProduct()
    {
        $name = $_POST['name'];
        $statement = $this->db->prepare("SELECT * FROM `products` WHERE `product_name` = :product_name");
        $statement->bindParam(":product_name",$name);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_OBJ);
        $jproduct = json_encode($product);
        echo $jproduct;
    }

    public function orderCreate()
    {
        $statement = $this->db->prepare("INSERT INTO `invoice` ( `invoice_no`, `customer_name`, `order_date`, `sub_total`, `tax`, `discount`, `net_total`, `paid`, `due`, `payment_type`, `changes`) VALUES ( :invoice_no, :customer_name, :order_date, :sub_total, :tax, :discount, :net_total, :paid, :due, :payment_type, :changes)");
        $statement->bindParam(":customer_name", $_POST["customer_name"]);
        $statement->bindParam(":order_date", $_POST["order_date"]);
        $statement->bindParam(":sub_total", $_POST["sub_total"]);
        $statement->bindParam(":tax", $_POST["tax"]);
        $statement->bindParam(":discount", $_POST["discount"]);
        $statement->bindParam(":net_total", $_POST["net_total"]);
        $statement->bindParam(":paid", $_POST["paid"]);
        $statement->bindParam(":due", $_POST["due"]);
        $statement->bindParam(":payment_type", $_POST["pay_method"]);
        $statement->bindParam(":invoice_no", $_POST["invoice_number"]);
        $statement->bindParam(":changes", $_POST["changes"]);
        if($statement->execute()){
            $statement1 = $this->db->prepare("INSERT INTO `invoice_details` (`invoice_no`, `product_name`, `price`, `qty` ) VALUES (:invoice_no, :product_name, :price, :qty )");
            for($i = 0; $i < count($_POST["quentity"]); $i++){
                $statement1->bindParam(":invoice_no", $_POST["invoice_number"]);
                $statement1->bindParam(":product_name", $_POST["product_name"][$i]);
                $statement1->bindParam(":price", $_POST["price"][$i]);
                $statement1->bindParam(":qty", $_POST["quentity"][$i]);
                $statement1->execute();                   
            }
            echo "success";
            
        }else{
            echo "fail";
        }
    }

    public function orderPrint()
    {
        $statement = $this->db->prepare("SELECT 
        invoice.order_date, 
        invoice.invoice_no, 
        invoice.customer_name, 
        invoice.sub_total, 
        invoice_details.product_name, 
        invoice_details.qty, 
        invoice.tax, 
        invoice.paid,
        invoice_details.price,
        invoice.net_total,
        invoice.due,
        invoice.discount,
        invoice.payment_type,
        invoice.changes
    FROM 
        invoice_details
    RIGHT JOIN 
        invoice 
    ON 
        invoice_details.invoice_no = invoice.invoice_no
    WHERE 
        invoice.invoice_no = :invoice_no");

    $statement->bindParam(":invoice_no", $_GET["invoice_num"]);
    $statement->execute();
    if($statement->execute()){
        $invoices = $statement->fetchAll(PDO::FETCH_OBJ);
        // dd($invoices);
        view("print-invoice.php",['invoices' => $invoices]);
    }else{
        echo "fail";
    }
   
    }

    public function manageOrder()
    {
        view("order-manage.php");
    }

    public function getAllOrders()
    {
        $page = $_POST["page"];

        if ($page > 1) {
            $page = ($page * 10) - 10;
        } elseif ($page == 1) {
            $page = 0;
        }
        $statement = $this->db->query("SELECT * FROM invoice ORDER BY `order_date` DESC LIMIT $page,10");
        $categories = $statement->fetchAll(PDO::FETCH_OBJ);
        $jCata = json_encode($categories);
        echo $jCata;        
    }

    public function deleteOrder()
    {
        if(isset($_POST['invoice_no'])){
            $statement = $this->db->prepare("DELETE FROM `invoice` WHERE `invoice_no` = :invoice_no");
            $statement->bindParam(":invoice_no", $_POST["invoice_no"]);
            if($statement->execute() == true){
                $statement = $this->db->prepare("DELETE FROM `invoice_details` WHERE `invoice_no` = :invoice_no");
                $statement->bindParam(":invoice_no", $_POST["invoice_no"]);
                if($statement->execute() == true){
                    echo "success";
                }
            }else{
                echo "fail";
            }
        }else{
            echo "fail";
        }
    }

    public function getLength()
    {
        $table = $_GET['table'];
        $statement = $this->db->query("SELECT COUNT(*) FROM `$table`");
        $count = $statement->fetch();
        echo $count[0];
    }

    public function orderDetails()
    {
        if(isset($_POST["invoice_no"])){
            $statement = $this->db->prepare("select * from `invoice` right join `invoice_details` on invoice_details.invoice_no = invoice.invoice_no WHERE invoice.invoice_no = :invoice_no;");
            $statement->bindParam(":invoice_no", $_POST["invoice_no"]);
            if($statement->execute()){
               $order =  $statement->fetchAll(PDO::FETCH_OBJ);
               $jorder = json_encode($order);
                echo $jorder;
            }else{
                echo "fail";
            }
        }else{
            echo "fail";
        }
    }

    public function searchInvoice()
    {   
            $columnName = $_GET["by"];
            $value = $_POST['value'];
            $statement = $this->db->prepare("SELECT * FROM invoice WHERE `$columnName` LIKE '%$value%'");
            $statement->execute();
            $invoices = $statement->fetchAll(PDO::FETCH_OBJ);
            $jinvoices = json_encode($invoices);
            echo $jinvoices;
     
    }
}    


