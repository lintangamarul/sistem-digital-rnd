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
<div class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20">
		<div class="pd-10">
			<div class="error-page-wrap text-center">
				<h1>404</h1>
				<h3>ANDA MENGAKSES WEB TRIAL</h3> 
				<p>Untuk Mengakses Program LKH silahkan akses URL di http://192.168.10.8/daily_report/public/</p>
                <!-- <div class="pt-20 mx-auto max-width-200">
					<a href="http://192.168.10.8/daily_report/public/" class="btn btn-primary btn-block btn-lg">Buka URL</a>
				</div> -->
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
