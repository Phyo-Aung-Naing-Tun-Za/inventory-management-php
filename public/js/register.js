$(document).ready(function(){
    function clearErrors(){
        $("#e_name").empty();
        $("#e_password").empty();
        $("#e_email").empty();
        $("#e_c_password").empty();
        $("#name").removeClass("border");
        $("#name").removeClass("border-danger");
        $("#email").removeClass("border");
        $("#email").removeClass("border-danger");
        $("#password").removeClass("border");
        $("#password").removeClass("border-danger");
        $("#password_confirmation").removeClass("border");
        $("#password_confirmation").removeClass("border-danger");
    }
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }

    $("#register_form").on("submit",function(e){
        e.preventDefault();
        clearErrors();
        let name = $("#name").val();
        let email = $("#email").val();
        let password = $("#password").val();
        let password_confirmation = $("#password_confirmation").val();
        if(name == "" || name.length <= 5) {
            $("#e_name").html("<span>Name can't be empty and must be more than 5.</span>");
            $("#name").addClass("border");
            $("#name").addClass("border-danger");
        } else if(email == "" || !isEmail(email)) {
            $("#e_email").html("<span>Please enter a valid email.</span>");
            $("#email").addClass("border");
            $("#email").addClass("border-danger");
        } else if(password == "" || password.length <= 4) {
            $("#e_password").html("<span>Password can't be empty and must be more than 4.</span>");
            $("#password").addClass("border");
            $("#password").addClass("border-danger");
        }else if(password !== password_confirmation) {
            $("#e_c_password").html("<span>Confirmed password  must be same with password.</span>");
            $("#password_confirmation").addClass("border");
            $("#password_confirmation").addClass("border-danger");
        } else {
            console.log($("#register_form").serialize());
            $.ajax({
                url: "/store",
                method: "POST",
                data: $("#register_form").serialize(),
                success:function(data){
                    if(data == "Successfully Registered"){
                    location.href = "/index?success=true";
                    }else{
                        location.href = "/reigster?error=true";
                    }
                }
                
            })
        }


        
      
    })
})