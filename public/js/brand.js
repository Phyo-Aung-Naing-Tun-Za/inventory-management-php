$(document).ready(function(){
    $("#brand-form").on("submit",function(e){
        e.preventDefault(); 
        let name = $("#brand_name").val();
        if(name == "") {
            $("#brand_name").addClass('border');
            $("#brand_name").addClass('border-danger');
            $("#e_brand").html("<span>Please enter a brand name.</span>")
        }else{
            $.ajax({
                url: '/product/brand/create',
                method: 'POST',
                data: $("#brand-form").serialize(),
                success: function(data){
                    if(data == "Created brand successfully"){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Created brand successfully",
                            showConfirmButton: false,
                            timer: 1500
                          });                      
                    }else{
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Failed to create brand!",
                            showConfirmButton: false,
                            timer: 1500
                          });
                    }
                }
            })
            $("#brand_name").removeClass('border');
            $("#brand_name").removeClass('border-danger');
            $("#e_brand").empty();
            $("#brand_name").val("");
            
        }
    })
})