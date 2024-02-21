$(document).ready(function () {


$("#print-form").hide();
function netTotal(){
    let subTotal = 0;

    $(".total").each(function(data){
        subTotal += parseInt($(this).text());
    })
    let tax = parseInt(subTotal * 0.05);
    let total = subTotal + tax;
    return total;
}

function getTotal(){
    let subTotal = 0;
    $(".total").each(function(data){
        subTotal += parseInt($(this).text());
    })
    let tax = parseInt(subTotal * 0.05);
    let total = subTotal + tax;
    $("#tax").val(tax);
    $("#sub_total").val(subTotal);
    $("#net_total").val(total);
    $("#due").val(total);
    $("#discount").val(0);
    $("#paid").val(0);
}

function showInputs(){
    $.ajax({
        url: "/order/getproduct",
        method: "POST",
        success: function(data){
        $('#t-body').append(data);
        let n = 0;
        $(".order-count").each(function(){
            $(this).text(++n);
        });
        }
    })
}


//to delete product after ordered
function deleteProducts(products){
    $.ajax({
        url: "/order/product/delete",
        method:"POST",
        data: {products : products},
    })
}

$("#discount").on("keyup",function(e){
    let discount = $("#discount").val();  
    let total = netTotal();
    if(total + 1 <= discount){
        $("#discount").val("");
        $("#net_total").val(total) 
    }else{
        $("#net_total").val(total - discount);
        $("#due").val(total - discount);
    }
})

$("#paid").on("keyup",function(e){
    let paid = parseInt($("#paid").val());
    let total = parseInt($("#net_total").val());
    $("#change").val(paid - total > 0 ? paid - total : 0 );
    if(paid  >= total + 1){
        $("#due").val(0);
    }else if(paid > 0){
        $("#due").val(total - paid);
    }
})

$("#plus-input").click(function (e) {
    showInputs();
});

$("#minus-input").click(function (e) {
    $("#t-body").children().last().remove();
    getTotal();       


});

$(document).on("change","#product_name",function(e){
    let name = e.target.value;
    $.ajax({
        url: "/order/get_single_product",
        method: "POST",
        data: {name : name},
        success: function(data){
            let product = JSON.parse(data);
            let tr = $(e.target).parent().parent();
            tr.find("#price").val(product['price']);
            tr.find("#quentity").val(1);
            tr.find("#t_quentity").val(product['stock']);
            tr.find("#t_price").text( tr.find("#quentity").val() * tr.find("#price").val());
            getTotal();
        }
    })
})


$(document).on("keyup","#quentity",function(e){
    let quentity = parseInt(e.target.value);
    let tr = $(this).parent().parent();
    if(quentity > parseInt(tr.find("#t_quentity").val())){
        tr.find("#quentity").val(tr.find("#t_quentity").val());
        tr.find("#t_price").text( tr.find("#quentity").val() * tr.find("#price").val());
    }else{
    tr.find("#t_price").text( tr.find("#quentity").val() * tr.find("#price").val());
    }
    getTotal();
   
})

$("#order-form").on('submit',function(e){
    e.preventDefault();
        let customer_name = $("#customer_name").val();
        let paid = $("#paid").val();
        let subTotal = $("#sub_total").val();
        let due = $("#due").val();
        
        $("#invoice_number").val(parseInt(Math.random() * 1000000));
        if(customer_name == ""){
            Swal.fire("Please enter a customer name!");
        }else if(subTotal == ""){
            Swal.fire("Please select a product!");

        }else if(paid == 0 || paid == ""){
            Swal.fire("Please enter paid amount!");
        }else if(due !== "0"){
            Swal.fire("Paid amount must be equal to total amount!");
        }else{
        let productArr = [];
          let products  =  JSON.parse(JSON.stringify($('#order-form').serializeArray())).filter(product => product.name == "product_name[]");
          
          let quentity  =  JSON.parse(JSON.stringify($('#order-form').serializeArray())).filter(product => product.name == "quentity[]");
          for(let i = 0; i < products.length; i++){
            let obj = {product: products[i].value, quentity: quentity[i].value};
            productArr.push(obj);
          }
         
            $.ajax({
                url:"/order/create",
                method: "POST",
                data: $("#order-form").serialize(),
                success: function(data){
                    if(data == "success"){
                        //to delete product after ordered
                        deleteProducts(productArr);
                        $("#invoice_number_input").val($("#invoice_number").val());
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Ordered Successfully",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        $('#order-form').trigger('reset');  
                        $('#t-body').empty();
                        $("#submit-btn-container").hide();
                        $("#print-form").show();
                    }else if(data == "fail"){
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Ordered Failed",
                            showConfirmButton: false,
                            timer: 1500
                          });
                    }
                }
            })
        }
})



$("#cancel-btn").on('click',function(){
    $("#print-form").hide();
    $("#submit-btn-container").show();

})

$("#print-form").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        url: "/order/print",
        method: "GET",
        data : {invoice_num : $("#invoice_number_input").val()},
        success: function(data){
            window.location.href = `/order/print?invoice_num=${$("#invoice_number_input").val()}`;
            $("#submit-btn-container").show();
            $("#print-form").hide();
        }
    })
})
});


