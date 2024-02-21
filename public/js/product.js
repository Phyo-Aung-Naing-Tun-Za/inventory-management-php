$(document).ready(function(){
    function clearErrors(){
        $("#e_p_name").empty();
        $("#e_price").empty();
        $("#e_category").empty();
        $("#e_brand").empty();
        $("#e_img").empty();
        
        $("#product_name").removeClass("border");
        $("#product_name").removeClass("border-danger");
        $("#price").removeClass("border");
        $("#price").removeClass("border-danger");

    }

    function getCategories(){
        $("#cate").empty();
        $.ajax({
            url: "/product/sub_category",
            mehtod: "POST",
            success:function(data){
                $("#cate").html(data);
            }
        })
    }

    function getBrands(){
        $("#brand").empty();
        $.ajax({
            url: "/product/brand?m=true",
            mehtod: "POST",
            success:function(data){
                $("#brand").html(data);
            }
        })
    }

    $("#add_product").click(function(){
        getBrands();
        getCategories();

    });
    
    getCategories();
    getBrands();

    $("#product-form").on("submit",function(e){
        e.preventDefault();
        clearErrors(); 
        let p_name =   $("#product_name").val();
        let price = $("#price").val();
        let category = $("#cate").val();
        let brand = $("#brand").val();
        let img = $("#img").val();
        if(p_name == "") {
            $("#product_name").addClass('border');
            $("#product_name").addClass('border-danger');
            $("#e_p_name").html("<span>Please enter a brand name.</span>");
        }else if(price == "") {
            $("#price").addClass('border');
            $("#price").addClass('border-danger');
            $("#e_price").html("<span>Please enter a price.</span>");
        }else if(category == ""){
            $("#e_category").html("<span>Please select a category.</span>");
        }else if(brand == ""){
            $("#e_brand").html("<span>Please select a brand.</span>");
        }else if(img == ""){
            $("#e_img").html("<span>Please select a image.</span>");
        }else{
            clearErrors();
            var fd = new FormData($('#product-form')[0]);
            $.ajax({
                url: '/product/create',
                method: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data){
                   if(data == "success"){
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Successfully created",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    $("#product_name").val("");
                    $("#price").val(0);
                    $("#stock").val(0);
                    $("#img").val('');
                    $("#cate").val("");
                    $("#brand").val("");                 
                   }else if(data == "Fail to upload Image"){
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Fail to upload Image",
                        showConfirmButton: false,
                        timer: 1500
                      });
                   }else if(data == "Fail to creat product"){
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Fail to creat product",
                        showConfirmButton: false,
                        timer: 1500
                      });
                   }
                }
            })
        }

    })
})