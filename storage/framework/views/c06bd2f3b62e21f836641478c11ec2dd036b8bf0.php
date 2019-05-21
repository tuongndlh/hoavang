<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="linkhouse">
    <meta name="author" content="linkhouse">
    <meta name="keyword" content="linkhouse">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>LHMT</title>

    <!-- Icons -->
    <link href="<?php echo e(asset('public/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/simple-line-icons.css')); ?>" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="<?php echo e(asset('public/css/style.css')); ?>" rel="stylesheet">

    <!-- Styles required by this views -->
    <link href="<?php echo e(asset('public/css/custom.css')); ?>" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Đăng nhập</h1>
                        <p class="text-muted">Đăng nhập vào tài khoản</p>
                        <form method="POST" action="<?php echo e(route('login')); ?>">

                            <?php echo e(csrf_field()); ?>

                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                <input type="text" name="email" value="<?php echo e(old('email')); ?>" class="form-control" required
                                       autofocus placeholder="email">
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-4">Đăng nhập</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-link px-0">Quên mật khẩu?</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2>Đăng ký</h2>
                            <p>Đăng ký tài khoản BizApp.</p>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary active mt-3">Đăng ký ngay!</a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and necessary plugins -->
<script src="<?php echo e(asset('public/js/vendor/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/vendor/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/vendor/bootstrap.min.js')); ?>"></script>

</body>
</html>
