$(document).ready(function(){
    function clearErrors(){
        $("#e_email").empty();
        $("#e_password").empty();
        $("#email").removeClass("border");
        $("#email").removeClass("border-danger");
        $("#password").removeClass("border");
        $("#password").removeClass("border-danger");
    }
   

    $("#login_form").on("submit",function(e){
        e.preventDefault();
        clearErrors();
        let email = $("#email").val();
        let password = $("#password").val();
        let form_data = $("#login_form").serialize();
        if(email == ""){
            $("#e_email").html("<span>Please enter your email.</span>");
            $("#email").addClass("border");
            $("#email").addClass("border-danger");
        }else if(password == ""){
            $("#e_password").html("<span>Please enter your password.</span>");
            $("#password").addClass("border-danger");
            $("#password").addClass("border");
        }else{
            $.ajax({
                url: "/login",
                method: "POST",
                data: form_data,
                success: function(data){
                    if(data == "Login Successful"){
                        location.href = "/dashboard";
                    }else{
                        location.href = "/index?error=true";
                    }
                }
                        
            })
        }
    })
})