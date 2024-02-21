<?php
    namespace App\Controller;
    require_once('vendor/autoload.php');

    use App\Database\DB;
    use PDO;
    class UserController
    {
        private $db;
       public function __construct()
       {
        $con = new DB();
        $this->db = $con->connect();
       }

        public function index(){
            
            view("login.php");
            
        }

        public function register()
        {
            view("register.php");
        }

        public function store()
        {          
            $data = $_POST;
            if($data['password'] == $data['password_confirmation']) {
                $statement = $this->db->prepare("INSERT INTO `users` (`name`, `email`, `password`, `role`, `register_at`) VALUES 
                (:name , :email, :password, :role, :register_at )");
                $password = password_hash($data["password"],PASSWORD_DEFAULT);
                $date = date('Y-m-d');
                $statement->bindParam(":name", $data["name"]);
                $statement->bindParam(":email", $data["email"]);
                $statement->bindParam(":password", $password);
                $statement->bindParam(":role", $data["role"]);
                $statement->bindParam(":register_at",$date);
                if($statement->execute()){
                    echo "Successfully Registered";
                } else {
                    $e = 'Register Fail!Try again';
                    echo $e;
                };
            } else {
                $e = 'Passwords must be same';
                echo $e;
            }
        }

        public function show($id)
        {
            $statement = $this->db->query("SELECT  * FROM `users` WHERE `id` = $id");
            if($statement->execute()){
                return $statement->fetch(PDO::FETCH_OBJ);
            }
        }

        public function login()
        {
            $data = $_POST;
            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");
            $statement->bindParam(":email", $data['email']);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_OBJ);
            if($user){
                if(password_verify($data['password'],$user->password)){
                    session_start();
                    $login_at = date('Y-m-d');
                    $id = $user->id;
                    $statement = $this->db->prepare("UPDATE `users` SET `last_login` = :last_login WHERE `id` = :id");
                    $statement->bindParam(":last_login", $login_at);
                    $statement->bindParam(":id",$id);
                    $statement->execute();
                    $_SESSION['user'] = $this->show($id);
                    echo "Login Successful";
                } else {
                    $e = "Login Fail";
                    echo $e;
                }
            } else {
                $e = "Login Fail";
                echo $e;
            };
        }

        public function dashboard()
        {
            view("dashboard.php");
        }

        public function update()
        {
            $check = 0;
            session_start();
            $id = $_SESSION['user']->id;
            $data = $_POST['data'];
            foreach($data as $datum){
                $column = $datum[0];
                $value = $datum[1];
                $statement = $this->db->prepare(" update users set $column = '$value' where id = $id");
                if($statement->execute()){
                    $check++;
                };
            }
            echo $check;           
        }
        public function updatePassword()
        {
            session_start();
            $id = $_SESSION['user']->id;
            $statement = $this->db->query("SELECT `password` FROM `users` WHERE `id` = $id");
            $data = $statement->fetch(PDO::FETCH_OBJ);
            $password = $data->password;
            if(password_verify($_POST['current_password'],$password)){
                $update_password = password_hash($_POST['update_password'],PASSWORD_DEFAULT);
                $statement = $this->db->prepare("UPDATE `users` SET `password` = :password WHERE `id` = :id");
                $statement->bindParam(":password", $update_password);
                $statement->bindParam(":id",$id);
                $statement->execute();
                echo "success";

            }else{
                echo "notsame";
            }
        }
    }
