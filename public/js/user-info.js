$(document).ready(function(){
    
    //to show the current info before edit
    let name = $("#name-session").text();
    let email = $("#email-session").text();
    $("#user-name").val(name);
    $("#email").val(email);



    function clearErrorAlert(){
        $("#e_user_name").empty();
        $("#e_user_email").empty();
        $("#e_c_password").empty();
        $("#e_u_password").empty();
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    // for updating user name and email
    $("#user-edit").on("submit",function(e){
        e.preventDefault();
        clearErrorAlert();
        if($("#user-name").val() == ""){
            $("#e_user_name").text("User name can't be empty");
        }else if($("#email").val() == "" || !isEmail($("#email").val())){
            $("#e_user_email").text("Email can't be empty");
        }else{
            $.ajax({
                url: "/update",
                method: "POST",
                data: {data: [['name', $("#user-name").val()],
                    ['email', $("#email").val()]]},
                success: function(data){
                    if(data == 2){
                        Swal.fire({
                            title: "Success!",
                            text: "Successfully Updated User Info!",
                            icon: "success",
                          });
                        //   to login again
                        setTimeout(function(){
                            location.href = "../actions/logout.php"
                          },1000)
                    }
                }
            })
        }

    })

    // for updating password
    $("#user-password-edit").on("submit",function(e){
        e.preventDefault();
        clearErrorAlert();
        if($("#current-password").val() == ""){
            $("#e_c_password").text("Current password can't be empty");
        }else if($("#update-password").val() == "" || $("#update-password").val().length <= 4){
            $("#e_u_password").text("Password of no less than 4 character is required");
        }else{
            $.ajax({
                url : "/password/update",
                method : "POST",
                data : $("#user-password-edit").serialize(),
                success: function(data){
                    if(data == "notsame"){
                        Swal.fire({
                            title: "Failed!",
                            text: "Current password is not correct!",
                            icon: "error",
                          });                       
                    }else if(data == "success"){
                        Swal.fire({
                            title: "Success!",
                            text: "Successfully Updated Password!",
                            icon: "success",
                          });
                        //   to login again
                          setTimeout(function(){
                            location.href = "../actions/logout.php"
                          },1000)
                    }
                }
            })
        }
    })
})
