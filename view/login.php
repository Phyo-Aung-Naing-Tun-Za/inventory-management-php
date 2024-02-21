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
    <script src="public/js/logins.js"></script>
    <link rel="stylesheet" href="public/css/app.css">
</head>
<body>

    <?php require_once("templates/header.php") ?>

    <div class="container mt-3 ">
        <!-- Alert about registeration -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Registered Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        
        <!-- Alert about login -->
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                Login Fail!Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card mx-auto" style="width: 22rem;">

            <img class="card-img-top" src="public/images/login.png" alt="Card image cap">

            <div class="card-body">
                <form id="login_form" action="" method="POST">

                    <div class="form-group">
                        <label class="form-label" for="exampleInputEmail1">Email address</label>
                        <input id="email" name="email" type="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter email">
                        <small class=" text-danger" id="e_email"></small>
                    </div>

                    <div class="form-group my-1">
                        <label class="form-label" for="exampleInputPassword1">Password</label>
                        <input id="password" name="password" type="password" class="form-control "
                            id="exampleInputPassword1" placeholder="Password">
                        <small class=" text-danger" id="e_password"></small>
                    </div>
                    <small class="text-secondary">
                        Create a new account.
                        <a class="  mt-3 " href="/register">Register</a>
                    </small>
                    <br>

                    <button type="submit" class="btn btn-primary mt-3">Login</button>
                </form>
            </div>

            <div class="card-footer">
                <small><a href="#">Forget Password?</a></small>
            </div>

        </div>
    </div>
    
</body>
</html>