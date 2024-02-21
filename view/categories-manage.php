<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    <script src="../../public/js/category-managess.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../public/css/app.css">
</head>

<body class="position-relative">
    <?php require_once("templates/header.php") ?>
    <!-- This Modal is for edit category -->
    <div id="dropdown" style="width:100vw;height:100vh;z-index:4;" class="position-absolute bg-black opacity-50"></div>

    <div id="edit-container" style="top:20%;left :37%;z-index:5;" class="position-absolute bg-white">
        <div class="px-3 py-4 shadow" style="width:350px">

            <h4 class="mb-4 text-secondary fw-semibold ">Edit Category</h4>

            <form id="edit-ctg-form" action="/product/category/update" method="POST">

                <div class="mb-3">
                    <input type="hidden" class="form-control" id="cat-id" name="id">
                    <label for="name" class="form-label text-secondary fw-semibold">Sub Category Name</label>
                    <input type="text" class="form-control" id="name" name="category_name">
                    <small class=" text-danger" id="e_c_name"></small>
                </div>

                <div class="mb-4">
                    <label for="main_cat" class="form-label text-secondary fw-semibold">Select Main Category</label>
                    <select name="parent_cat" id="main_cat" class="form-select">
                        <option value="0">Root</option>
                    </select>
                </div>

                <button type="button" type="submit" class="btn btn-secondary me-2 edit-close ">Close</button>
                <button type="submit" class="btn btn-primary">Confirm <i class="fa fa-plus-circle ms-2"></i></button>

            </form>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <!-- This column is for search box -->
                <div id="close-btn-container" class="mt-3  text-end ">
                    <!-- To open search box -->
                    <button id="open-search-form" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div id="search-container" class="mt-3   d-flex justify-content-end gap-3">
                    <div style="width:200px;">
                        <input id="sub-category" type="text" class="form-control" placeholder="Parent Category">
                    </div>
                    <div style="width:200px;">
                        <select class="form-select" name="status" id="status-search">
                            <option value="" selected>All</option>
                            <option value="1">Active</option>
                            <option value="0">Suspend</option>
                        </select>
                    </div>

                    <div>
                        <button id="reset-search-form" class="btn btn-primary">Clear Search</button>

                        <!-- To close search box -->
                        <button style="font-size:24px" id="close-search-form" class="btn p-0 px-2 btn-danger">
                        <i class="fa-regular  fa-circle-xmark"></i></button>
                    </div>
                </div>
            </div>

            <div class="col-8 mx-auto mt-4">
                <!-- This column is for generating category -->
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th>NO</th>
                            <th>Category</th>
                            <th>Parent</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-start">
                    <!-- This nav is to generate pagination inside it -->
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