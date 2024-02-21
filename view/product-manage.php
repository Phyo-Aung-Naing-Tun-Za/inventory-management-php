<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    <script src="../../public/js/product-manage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../public/css/app.css">
</head>

<body class="position-relative">
    <?php require_once("templates/header.php") ?>

    <!-- Modal For editing products -->
    <div id="dropdown" style="width:100vw;height:100vh;z-index:4;" class="position-absolute bg-black opacity-50"></div>
    <div id="edit-container" style="top:11%;left :37%;z-index:5;" class="position-absolute bg-white">
        <div class="px-3 py-4 shadow" style="width:400px">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <!-- to show edit product form -->
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-product-info"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Edit Product</button>
                    <!-- to show edit product img form -->
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-upload-img"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Update Image</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <!-- product edit form -->
                <div class="tab-pane fade show active" id="nav-product-info" role="tabpanel" aria-labelledby="nav-home-tab"
                    tabindex="0">
                    <form class="mt-4" id="product-form" method="POST" enctype="multipart/form-data" action="/product/create">
                        <div class="mb-3">
                            <label for="product_name" class="form-label text-secondary fw-semibold">Product Name</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" id="product_name" name="product_name">
                            <small class=" text-danger" id="e_p_name"></small>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label text-secondary fw-semibold">Price</label>
                            <input type="number" class="form-control" id="price" name="price">
                            <small class=" text-danger" id="e_price"></small>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label text-secondary fw-semibold">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="0">
                            <small class=" text-danger" id="e_stock"></small>
                        </div>

                        <div class="mb-4 row">
                            <div class="col">
                                <label for="cate" class="form-label text-secondary fw-semibold">Select Category</label>
                                <select name="category" id="cate" class="form-select">
                                </select>
                                <small class=" text-danger" id="e_category"></small>
                            </div>
                            <div class="col">
                                <label for="brand" class="form-label text-secondary fw-semibold">Select Brand</label>
                                <select name="brand" id="brand" class="form-select">
                                </select>
                                <small class=" text-danger" id="e_brand"></small>
                            </div>
                        </div>
                        <button type="button"  class="btn btn-secondary me-2 edit-close ">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm <i
                                class="fa fa-plus-circle ms-2"></i></button>
                    </form>
                </div>
                <!-- product img edit form -->
                <div class="tab-pane fade" id="nav-upload-img" role="tabpanel" aria-labelledby="nav-profile-tab"
                    tabindex="0">
                   <img eid="" id="current-img" class="ms-5 my-4" src="" alt="img" style="width:260px;height:250px;object-fit:cover;">
                   <form id="img-upload-form" enctype="multipart/form-data"  action="/product/update_img" method="POST">
                        <input class="form-control" type="file" name="img" id="img" >
                        <small class=" text-danger" id = "e_img"></small>
                        <br>
                        <button type="button"   class="btn btn-secondary mt-3 edit-close">Close</button>
                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                   </form>
                </div>
            </div>
        </div>
    </div>

    <!-- for search -->
    <div id="close-btn-container" class="mt-3 px-4 text-end ">
        <!-- open search box -->
        <button  id="open-search-form" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    <div id="search-container" class="mt-3 px-4  d-flex justify-content-end gap-3">
        <div style="width:200px;">
            <input id="name" type="text" class="form-control" placeholder="Product Name">
        </div>
        <div style="width:200px;">
            <input id="category" type="text" class="form-control" placeholder="Category Name">
        </div>
        <div style="width:200px;">
            <input id="brand-search" type="text" class="form-control" placeholder="Brand Name">
        </div>

        <div style="width:200px;">
            <select class="form-select" name="status" id="status-search">              
                <option value="" selected >All</option>
                <option value="1">Active</option>
                <option value="0">Suspend</option>
            </select>
        </div>

        <div>
            <button id="reset-search-form" class="btn btn-primary">Clear Search</button>
            <!-- for closing search box -->
            <button style="font-size:24px" id="close-search-form" class="btn p-0 px-2 btn-danger"><i class="fa-regular  fa-circle-xmark"></i></button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-4">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th>NO</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>
               <div class="d-flex justify-content-between align-items-start">
                <!-- this nav  is for generating pagination inside it -->
                    <nav aria-label="Page navigation ">
                        <ul class="pagination">

                        </ul>
                    </nav>
                    <a href="/dashboard" class="btn btn-secondary">Back to home</a>
               </div>
            </div>
        </div>
    </div>
</body>
</html>