<?php

//checking whether the user is login or not
session_start();
if (!isset($_SESSION['user'])) {
    header("location: /index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="public/js/category.js"></script>
    <script src="public/js/product.js"></script>
    <script src="public/js/brand.js"></script>
    <script src="public/js/user-info.js"></script>
    <link rel="stylesheet" href="public/css/app.css">
</head>

<body>
    <?php
        require_once('vendor/autoload.php');
        require_once("templates/header.php");
        require_once("templates/category.php");
        require_once("templates/product.php");
        require_once("templates/brand.php");
        require_once("templates/user_info.php");   
    ?>

    <div class="container" style="padding:0px 70px;">
        <div class="row mt-3">
            <div class="col-4">
                <div>
                    <!-- This Card is to show user info  -->
                    <div class="card">
                        <img style="height:150px;object-fit:contain;" class="card-img-top" src="public/images/user.png"
                            alt="Card image cap">
                            
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="text-secondary mb-2"><i class="me-1 fa fa-user"></i><span id="name-session"><?= $_SESSION['user']->name ?>
                                </span></p>
                            <p class="text-secondary mb-2"><i class="me-1 fa fa-user"></i><span id="email-session">
                                    <?= $_SESSION['user']->email ?>
                                </span></p>
                            <p class="text-secondary mb-2"><i class="me-1 fa fa-user"></i>
                                <?= $_SESSION['user']->role ?>
                            </p>
                            <p class="text-secondary mb-2"><i class="me-1 fa fa-clock"></i> Last time login in
                                <?= $_SESSION['user']->last_login ?>
                            </p>
                            <button id="add_product" data-bs-toggle="modal" data-bs-target="#userModal"
                                class="btn mt-2 btn-primary">
                                <i class="fa-regular fa-pen-to-square me-1"></i>Edit Profile
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col ">
                <!-- This column is for order -->
                <div class=" overflow-hidden p-4 d-flex align-items-center "
                    style="background-color:#edeef0;height:386px;border-radius:6px ">
                    <div class="col">
                        <div>
                            <h2>Welcome Admin,</h2>
                            <span class="">Have a nice day.</span>
                            <br>
                            <iframe class="mt-3"
                                src="https://free.timeanddate.com/clock/i98dup3t/n208/szw160/szh160/hoc000/hbw2/hfceee/cf100/hncccc/fdi76/mqc000/mql10/mqw4/mqd98/mhc000/mhl10/mhw4/mhd98/mmc000/mml10/mmw1/mmd98"
                                frameborder="0" width="160" height="160"></iframe>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white p-3 overflow-hidden" style="border-radius:6px;">
                            <h4>Orders</h4>
                            <p>Here you can make a new order and print invoices</p>
                            <a href="/order" class=" btn btn-primary"><i class="fa fa-plus me-2"></i>New Order</a>
                            <a href="/order/manage" class="btn btn-secondary"><i
                                    class="fa-regular fa-pen-to-square me-1"></i> Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-4 ">
                <!-- This column is for category -->
                <div class="border rounded-md rounded p-3">
                    <h4>Category</h4>
                    <p>Here you can add and manage categories.</p>
                    <button data-bs-toggle="modal" data-bs-target="#categoryModal" class="btn btn-primary"><i
                            class="fa fa-plus"></i> Add</button>
                    <a href="/product/category/manage" class="btn btn-secondary"><i
                            class="fa-regular fa-pen-to-square me-1"></i> Manage</a>
                </div>
            </div>
            <div class="col">
                <!-- This column is for brand -->
                <div class="border rounded-md rounded p-3">
                    <h4>Brands</h4>
                    <p>Here you can add and manage brands as you wish.</p>
                    <button data-bs-toggle="modal" data-bs-target="#brandModal" class="btn btn-primary"><i
                            class="fa fa-plus"></i> Add</button>
                    <a href="/product/brand/manage" class="btn btn-secondary"><i
                            class="fa-regular fa-pen-to-square me-1"></i> Manage</a>
                </div>
            </div>
            <div class="col-4">
                <!-- This column is for product -->
                <div class="border rounded-md rounded p-3">
                    <h4>Prodcuts</h4>
                    <p>Here you can add and manage products.</p>
                    <button id="add_product" data-bs-toggle="modal" data-bs-target="#productModal"
                        class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
                    <a href="/product/manage" class="btn btn-secondary"><i class="fa-regular fa-pen-to-square me-1"></i>
                        Manage</a>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</body>

</html>