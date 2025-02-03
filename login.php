<?php
// Params
define('_WEBROOT_PATH_', './');
define('_LOG_NAME_', 'access');

// Setup
require _WEBROOT_PATH_ . 'components/setup.php';
require _WEBROOT_PATH_ . 'components/verify.php';

// Logger
$logger->info('View Login', ["page" => "login"]);

$csrf_token = generate_csrf_token();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require _WEBROOT_PATH_ . 'components/head.php'; ?>
    <?php require _WEBROOT_PATH_ . 'components/script.php'; ?>
    <script src="<?php echo _WEBROOT_PATH_ ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
</head>

<body class="p-0 m-0 d-flex flex-column bg-dark">
    <!--begin::Theme mode setup on page load-->
    <script>
        document.documentElement.setAttribute("data-bs-theme", "light");
    </script>
    <div class="container d-flex flex-center flex-column-fluid">
        <div class="card min-w-350px rounded-4 shadow-sm">
            <div class="card-body d-flex flex-column gap-3">
                <img class="h-100px object-fit-contain" src="<?php echo _WEBROOT_PATH_ ?>assets/medias/logos/android-chrome-192x192.png" alt="">
                <h2 class="text-center">เข้าสู่ระบบ</h2>
                <form id="loginForm" method="POST" class="d-flex flex-column gap-4">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
                        <label for="floatingInput">อีเมล์ / Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" />
                        <label for="floatingPassword">รหัสผ่าน / Password</label>
                    </div>
                    <div class="d-flex flex-row flex-nowrap gap-2 justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember_me" />
                            <label class="form-check-label" for="remember_me">
                                จดจำการเข้าสู่ระบบ
                            </label>
                        </div>
                        <a class="link-primary" href="">ลืมรหัสผ่าน</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="d-flex flex-center w-100 mt-3">
                        <a class="link-primary" href="">สมัครสมาชิก</a>
                    </div>
                </form>
                <div class="separator my-2"></div>
                <div class="w-100 d-flex flex-row flex-center gap-3">
                    <a href="" class="btn btn-icon btn-google rounded-circle" id="googleLogin">
                        <i class="fa-brands fa-google fs-2"></i>
                    </a>
                    <a href="" class="btn btn-icon btn-facebook rounded-circle" id="facebookLogin">
                        <i class="fa-brands fa-facebook fs-2"></i>
                    </a>
                    <a href="<?php echo lineLoginURL() ?>" class="btn btn-icon btn-success rounded-circle" id="lineLogin">
                        <i class="fa-brands fa-line fs-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php require _WEBROOT_PATH_ . 'components/footer.php'; ?>

    <script src="./js/custom.js"></script>

    <script>
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            var email = $('#floatingInput').val();
            var password = $('#floatingPassword').val();
            if (email === '' || password === '') {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                return false;
            }
            this.submit();
        });
        
    </script>

</body>
<!--end::Body-->

</html>