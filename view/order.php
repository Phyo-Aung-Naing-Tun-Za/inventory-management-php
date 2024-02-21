<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="public/js/order.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="public/css/app.css">
</head>
<body > 

    <?php require_once("templates/header.php")  ?>

     <div class="container">
        <div class="row">
            <div class="col-11 mx-auto">
                <div class="mt-3 mb-5 shadow rounded overflow-hidden">

                    <h5 style="background:#ebedeb;" class=" p-3">New Order</h5>
                    
                    <!-- this form is for creating orders -->
                    <form id="order-form" class="px-4" action="/order/create" method="POST">
                        <div style="width:70%;" class="mx-auto">
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="date">Order Date</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;"  value="<?php echo date("Y-m-d"); ?>" class="form-control" type="date" id="date" name="order_date">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="customer_name">Customer Name</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" id="customer_name" name="customer_name">
                                <small class=" text-danger" id = "e_customer_name"></small>
                                </div>
                            </div>
                        </div>
                        <div class="shadow mb-5 px-3 py-4">
                            <h5 class="mb-3 text-secondary">Make order lists</h5>
                            <table class="ms-2" >
                                <thead>
                                    <tr >
                                        <th class="text-secondary pe-3">#</th>
                                        <th class="text-secondary pe-3">Item Name</th>
                                        <th class="text-secondary pe-3">Total Quantity</th>
                                        <th class="text-secondary pe-3">Quantity</th>
                                        <th class="text-secondary pe-3">Price</th>
                                        <th class="text-secondary pe-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="t-body">
                                    <!-- .... table  -->
                                </tbody>                               
                            </table>
                            <div class="d-flex justify-content-center mt-3 gap-2">
                                <button id="plus-input" type="button" style="width:100px;" class="btn btn-primary">Add</button>
                                <button id="minus-input" type="button" style="width:100px;" class="btn btn-danger">Remove</button>
                            </div>

                        </div>
                        <div style="width:70%;" class="mx-auto">
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="sub_total">Sub Total</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;" class="form-control" type="number" id="sub_total" name="sub_total">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="tax">Tax 5%</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;" class="form-control" type="number" id="tax" name="tax">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="discount">Discount</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="number" id="discount" name="discount">
                                </div>
                                <input value="" type="hidden" name="invoice_number" id="invoice_number">
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="net_total">Net Total</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;" class="form-control" type="number" id="net_total" name="net_total">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="paid">Paid</label>
                                </div>
                                <div class="col">
                                    <input  class="form-control" type="number" id="paid" name="paid">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="change">Change</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;"  class="form-control" type="number" id="change" name="changes">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="due">Due</label>
                                </div>
                                <div class="col">
                                    <input readonly style="background:#ebedeb;" class="form-control" type="number" id="due" name="due">
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="text-secondary" for="pay_method">Payment Method</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="pay_method" id="pay_method">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="mobile_banking">Mobile Banking</option>
                                        <option value="kbz_pay">KBZ Pay</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="submit-btn-container" class="text-center pt-4 mb-4">
                            <button id="submit-btn" type="submit" style="width:100px;" class="btn btn-primary">Order</button>
                            <a id="back-btn" href="/dashboard" class="btn btn-secondary">Back</a>                           
                        </div>
                    </form>

                    <!-- this form is for printing invoice; -->
                    <form class="text-center  mb-5" action="/order/print" method="POST" id="print-form">
                        <input type="hidden" id="invoice_number_input">
                        <button type="submit" id="print-btn" type="button" style="width:200px;" class="btn btn-success">Print invoice</button>
                        <button type="button" id="cancel-btn" type="button" style="width:100px;" class="btn btn-secondary">Cancel</button>
                    </form>                           
                    
                </div>
            </div>
        </div>
     </div>
</body>
</html>