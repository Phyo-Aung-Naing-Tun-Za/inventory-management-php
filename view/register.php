<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="public/js/register.js"></script>
    <link rel="stylesheet" href="public/css/app.css">
</head>

<body>
    <?php require_once("templates/header.php") ?>
    
    <div class="container mt-3 ">
        <div class="card mx-auto overflow-hidden" style="width: 25rem;">
            <div style="background-color:#edeef0;" class="cart-title text-primary fs-3 pb-1 ps-3">
                Register
            </div>
            <div class="card-body">
                <form id="register_form" action="" method="POST" class="d-flex flex-column gap-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp"
                            placeholder="Enter Name">
                        <small class=" text-danger" id="e_name"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
                            placeholder="Enter email">
                        <small class=" text-danger" id="e_email"></small>
                    </div>
                    <div class="form-group ">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="Password">
                        <small class=" text-danger" id="e_password"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input name="password_confirmation" type="password" class="form-control"
                            id="password_confirmation" aria-describedby="emailHelp" placeholder="Enter password"
                            id="password_confirmation">
                        <small class=" text-danger" id="e_c_password"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="role">User Type</label>
                        <select class="form-select" name="role" id="role">
                            <!-- <option value="Admin">Admin</option> -->
                            <option selected value="Other">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary ">Register</button>
                </form>
            </div>
            <div class="card-footer">
                <small class="text-secondary">
                    Already had an account.
                    <a class="  mt-3 " href="/index">Login</a>
                </small>
            </div>
        </div>
    </div>
</body>

</html>