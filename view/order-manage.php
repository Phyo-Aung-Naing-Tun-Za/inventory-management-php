<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    <script src="../../public/js/order-manage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../public/css/app.css">
</head>

<body class="position-relative">

    <?php require_once("templates/header.php") ?>

    <!-- Modal box for seeing order  detail-->
    <div id="dropdown" style="width:100vw;height:100vh;z-index:4;" class="position-absolute bg-black opacity-50"></div>
    <div id="edit-container" style="top:13%;left :20%;z-index:5;" class="position-absolute shadow bg-white">
        <div class="px-3 py-4 shadow overflow-scroll" style="width:800px;max-height:600px">
            <h4 class="mb-2 text-primary text-center fw-semibold ">Order Details</h4>
            <hr>
            <p style='font-size:15px;' class="text-secondary">Date<span class="fw-semibold" style="margin:0 0 0 84px;"
                    id="date"></span></p>
            <p style='font-size:15px;' class="text-secondary">Invoice Number <span class="ms-2 fw-semibold"
                    id="invoice_no"></span></p>
            <p style='font-size:15px;' class="text-secondary">Customer Name <span class="ms-1 fw-semibold"
                    id="customer_name"></span></p>

            <table class="table  table-sm table-hover table-bordered">
                <tr class="table-primary">
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
                <tbody id="t_body">

                </tbody>
            </table>
            <div class="text-secondary">
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Sub Total
                </span><span style="font-size:14px" class="ms-3 fw-semibold" id="sub_total"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Tax </span><span
                    style="font-size:14px" class="ms-3 fw-semibold" id="tax"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Discount
                </span><span style="font-size:14px" class="ms-3 fw-semibold" id="discount"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Due </span><span
                    style="font-size:14px" class="ms-3 fw-semibold" id="due"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Change </span><span
                    style="font-size:14px" class="ms-3 fw-semibold" id="change"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Paid </span><span
                    style="font-size:14px" class="ms-3 fw-semibold" id="paid"></span><br>
                <span style='font-size:15px; width:70px' class="d-inline-block mb-1 text-secondary">Net Total
                </span><span style="font-size:14px" class="ms-3 fw-semibold" id="net_total"></span><br>
            </div>
            <hr>
            <button id="close-btn" class='btn btn-secondary '>Close</button>
            <button id="" class='btn btn-success print-btn '>Print</button>
        </div>
    </div>

    <!-- for search -->
    <div id="close-btn-container" class="mt-3 px-4 text-end ">
        <!-- for opening search box -->
        <button id="open-search-form" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>


    <div id="search-container" class="mt-3 px-4  d-flex justify-content-end gap-3">
        <div style="width:200px;">
            <input id="name" ,type="text" class="form-control" placeholder="Customer Name">
        </div>
        <div style="width:200px;">
            <input id="invoice" type="number" class="form-control" placeholder="Invoice Number">
        </div>
        <div style="width:200px;">
            <select class="form-select" name="payment" id="payment">
                <option value="" selected>All</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="mobile_banking">Mobile Banking</option>
                <option value="kbz_pay">KBZ Pay</option>
            </select>
        </div>
        <div style="width:200px;">
            <input type="date" id="search-date" name="date" class="form-control">
        </div>
        <div>
            <button id="reset-search-form" class="btn btn-primary">Clear Search</button>
            <!-- for closing search box -->
            <button style="font-size:24px" id="close-search-form" class="btn p-0 px-2 btn-danger">
                <i class="fa-regular  fa-circle-xmark"></i>
            </button>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="mt-3">
                <table class="table table-sm  table-bordered table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th>NO</th>
                            <th>Date</th>
                            <th>Invoice Number</th>
                            <th>Customer</th>
                            <th>Sub Total</th>
                            <th>Tax</th>
                            <th>Discount</th>
                            <th>Due</th>
                            <th>Paid</th>
                            <th>Total</th>
                            <th>Change</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    </tbody>
                </table>
            </div>
            <div class="col mx-auto ">
                <div class="d-flex justify-content-between align-items-start">
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