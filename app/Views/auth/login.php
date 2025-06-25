<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Aktivitas Harian - Login</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/apple-touch-icon.png'); ?>" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/favicon-32x32.png'); ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon-16x16.png'); ?>" />
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/styles/core.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendors/styles/icon-font.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/styles/style.css'); ?>" />
</head>

<body class="login-page">
<div class="login-header box-shadow">
    <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="brand-logo text-center col-12 col-md-auto">
            <a href="<?= base_url('login'); ?>">
                <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo" />
            </a>
        </div>
        <div class="login-menu text-center text-md-left mt-2 mt-md-0">
            <ul>
                <li><a href="#"><span style="color: red;">R&D,</span> Technical Center</a></li>
            </ul>
        </div>
    </div>
</div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="<?= base_url('assets/images/login-page-img.png'); ?>" alt="Login Image" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To Daily Report Application</h2>
                        </div>
                        <form method="POST" action="<?= base_url('login'); ?>">
                        <?= csrf_field(); ?>
                            <div class="input-group custom">
                                <input type="text" name="nik" class="form-control form-control-lg" placeholder="NIK" required />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="********" required />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
                                </div>
                            </div>
                        </form>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger mt-2"><?= session()->getFlashdata('error'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/vendors/scripts/core.js'); ?>"></script>
    <script src="<?= base_url('assets/vendors/scripts/script.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendors/scripts/process.js'); ?>"></script>
    <script src="<?= base_url('assets/vendors/scripts/layout-settings.js'); ?>"></script>
</body>
</html>
