<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url(); ?>/assets/bootstrap-5.2.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>/assets/bootstrap-icons-1.10.2/bootstrap-icons.css" rel="stylesheet">
	<link href="<?= base_url(); ?>/assets/css/login.css" rel="stylesheet">
	<!-- for global color css -->
	<link href="<?= base_url(); ?>/assets/css/global.css" rel="stylesheet">
</head>

<body class="text-center">

	<main class="form-signin">
		<?= form_open('I2r0J2r2RjW1sJ0r2L9m', ['id' => 'login_form']) ?>
		<!-- <i class="bi-emoji-sunglasses" style="font-size: 2rem; color: cornflowerblue;"></i> <span>Login System</span> -->
		<img class="mb-5" src="<?= base_url(); ?>/assets/images/avatar.png" width="80" height="80" alt="logo">
		<!-- <h1 class="h3 mb-3 fw-normal">WELCOME</h1> -->

		<div class="form-floating mb-3">
			<input id="username" class="form-control" type="text" name="username" value="<?= set_value('username') ?>" placeholder="Username">
			<i class="bi bi-person-fill"></i>
			<label for="username">Username</label>
		</div>

		<div class="form-floating mb-3">

			<input id="password" class="form-control" type="password" name="password" value="<?= set_value('password') ?>" placeholder="Password">
			<i class="bi bi-shield-lock"></i>
			<label for="password">Password</label>
		</div>
		<div class="form-floating mb-3">
			<input id="gsecret" class="form-control" type="text" name="gsecret" value="<?= set_value('gsecret') ?>" placeholder="123456">
			<i class="bi bi-qr-code"></i>
			<label for="gsecret">Google Auth Key</label>
		</div>
		<div id="form_errors" class="alert alert-danger mb-3 d-none" role="alert">
			<i class="bi-exclamation-triangle"></i>
			Login failed!
		</div>
		<div class="form-submit mb-3">
			<div class="login-spinner spinner-border d-none" role="status">
				<span class="sr-only"></span>
			</div>
			<input type="submit" class="w-100 btn btn-lg" value="Login" id="login_btn">
		</div>


		<?= form_close() ?>
	</main>

</body>
<!-- jquery -->
<script src="<?= base_url(); ?>/assets/jquery-3.6.1/jquery-3.6.1.min.js"></script>
<!-- custom js -->
<script src="<?= base_url(); ?>/assets/js/login.js"></script>

</html>