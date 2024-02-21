<?php
use App\Controller\ProductController;
use App\Controller\OrderController;
use App\Controller\UserController;


//using return is to assign this routes in router file as routes;
return [
    // Routes for userController
    '/index' => [UserController::class,'index'],
    '/register' => [UserController::class,'register'],
    '/store' => [UserController::class,'store'],
    '/login' => [UserController::class,'login'],
    '/update' => [UserController::class,'update'],
    '/password/update' => [UserController::class,'updatePassword'],
    '/dashboard' => [UserController::class,'dashboard'],

    // Routes for category in productController
    '/product/category/create' => [ProductController::class, 'createCtg'],
    '/product/category/manage' => [ProductController::class, 'manageCtg'],
    '/product/category' => [ProductController::class, 'getAllCtg'],
    '/product/category/delete' => [ProductController::class, 'deleteCtg'],
    '/product/category/update' => [ProductController::class, 'updateCtg'],
    '/product/main_category' => [ProductController::class, 'getMainCtgs'],
    '/product/sub_category' => [ProductController::class, 'getSubCtgs'],
    '/product/category/search' => [ProductController::class, 'searchItems'],

    // Routes for brand in productController
    '/product/brand' => [ProductController::class, 'getBrands'],
    '/product/brand/create' => [ProductController::class, 'createBrand'],
    '/product/brand/manage' => [ProductController::class, 'manageBrand'],
    '/product/create' => [ProductController::class, 'createProduct'],
    '/product/brand/update' => [ProductController::class, 'updateBrand'],
    '/product/brand/delete' => [ProductController::class, 'deleteBrand'],
    '/product/brand/search' => [ProductController::class, 'searchBrands'],

    // Routes for product in productController;
    '/product' => [ProductController::class, 'getAllProducts'],
    '/product/manage' => [ProductController::class, 'manageProduct'],
    '/product/edit' => [ProductController::class, 'editProduct'],
    '/product/update' => [ProductController::class, 'updateProduct'],
    '/product/update_img' => [ProductController::class, 'updateImg'],
    '/product/search' => [ProductController::class, 'searchProducts'],
    '/product/delete' => [ProductController::class, 'deleteProduct'],
    '/get_length' => [ProductController::class, 'getLength'],

    // Routes for orderController;
    '/order' => [OrderController::class, 'order'],
    '/order/getproduct' => [OrderController::class, 'getProducts'],
    '/order/get_single_product' => [OrderController::class, 'getSingleProduct'],
    '/order/create' => [OrderController::class, 'orderCreate'],
    '/order/print' => [OrderController::class, 'orderPrint'],
    '/order/product/delete' => [OrderController::class, 'deleteProducts'],
    '/order/manage' => [OrderController::class, 'manageOrder'],
    '/order/invoices' => [OrderController::class, 'getAllOrders'],
    '/order/invoices/delete' => [OrderController::class, 'deleteOrder'],
    '/order/invoices/details' => [OrderController::class, 'orderDetails'],
    '/order/invoices/search' => [OrderController::class, 'searchInvoice'],

];