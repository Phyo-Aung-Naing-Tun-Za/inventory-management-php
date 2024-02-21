$(document).ready(function(){

    function getMainCtgs(){
        $("#cat_select").html("");
        $.ajax({
            url: "/product/main_category",
            mehtod: "POST",
            success:function(data){
                $("#cat_select").html(data);
            }
        })
    }

    $("#main_cat").click(function(){
        $("#main_cat_form").show();
        $("#sub_cat_form").addClass("d-none");
    })

    $("#sub_cat").click(function(){
        $("#main_cat_form").hide();
        $("#sub_cat_form").removeClass("d-none");
        getMainCtgs();
    })

    $("#main_cat_form").on("submit",function(e){
        e.preventDefault();
        let cat_name = $("#name").val();
        if(cat_name == "") {
            $("#name").addClass('border');
            $("#name").addClass('border-danger');
            $("#e_name").html("<span>Please enter a category name.</span>")
        }else{
            $.ajax({
                url: '/product/category/create',
                method: 'POST',
                data: $("#main_cat_form").serialize(),
                success: function(data){
                    if(data == "Category Created Successfully"){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Successful",
                            showConfirmButton: false,
                            timer: 1500
                          })
                        $('#name').val(""); 
                        $("#sub_cat").click();
                        getMainCtgs();
                    }else(
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Already Existed",
                            showConfirmButton: false,
                            timer: 1500
                          })
                    )
                }
            })
        }
    })

    $("#sub_cat_form").on("submit",function(e){
        e.preventDefault();
        let name =   $("#sub_cat_form #name").val();
        if(name == "") {
            $("#sub_cat_form #name").addClass('border');
            $("#sub_cat_form #name").addClass('border-danger');
            $("#sub_cat_form #e_name").html("<span>Please enter a sub category name.</span>");
        }else{
            $.ajax({
                url: '/product/category/create',
                method: 'POST',
                data: $("#sub_cat_form").serialize(),
                success: function(data){
                    if(data == "Category Created Successfully"){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Successfully Created Category",
                            showConfirmButton: false,
                            timer: 1500
                          });
                          
                        $('#sub_cat_form #name').val(""); 
                        $('#sub_cat_form #name').removeClass("border");
                        $('#sub_cat_form #name').removeClass("border-danger");
                        $("#sub_cat_form #e_name").empty();
                    }else(
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Failed To Create Category",
                            showConfirmButton: false,
                            timer: 1500
                          })
                          
                    )
                }
            })
        }

    })

    
})