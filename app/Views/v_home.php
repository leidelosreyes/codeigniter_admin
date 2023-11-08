<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pagetitle; ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url(); ?>/assets/bootstrap-5.2.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>/assets/bootstrap-icons-1.10.2/bootstrap-icons.css" rel="stylesheet">
    <!-- JQuery Confirm -->
    <link href="<?= base_url(); ?>/assets/jquery-confirm-v3.3.4/css/jquery-confirm.css" rel="stylesheet">
    <!-- datatables -->
    <link href="<?= base_url(); ?>/assets/DataTables/datatables.min.css" rel="stylesheet">
    <!-- base css -->
    <link href="<?= base_url(); ?>/assets/css/login.css" rel="stylesheet">
    <!-- color css -->
    <link href="<?= base_url(); ?>/assets/css/global.css" rel="stylesheet">
    <!-- style.css -->
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet">
    <!-- Custom Loaded CSS -->

    <?php foreach ($css as $row) : ?>
        <link href="<?= base_url(); ?><?= $row ?>" rel="stylesheet">
    <?php endforeach ?>
</head>

<body>

    <main class="form-signin">
		<form id="claim_bonus" method="post">
		
		<h1 class="h3 mb-3 fw-normal">Claim Bonus</h1>

        <div class="form-floating mb-3">
			<input id="username" class="form-control" type="text" name="username" placeholder="Username">
			<i class="bi bi-person-fill"></i>
			<label for="username">Username</label>
		</div>

		<div class="form-floating mb-3">
			<input id="phone_number" class="form-control" type="text" name="phone_number" placeholder="Username">
			<i class="bi bi-telephone-fill"></i>
			<label for="phone_number">Telephone</label>
		</div>

        <div class="form-floating mb-3 h-captcha" data-sitekey="d797c03e-767b-45ab-82cc-e4dc94161862"></div>

		<div class="form-submit mb-3">
			<input type="submit" class="w-100 btn btn-lg" value="Claim Bonus Now!" id="claim_btn">
		</div>

        </form>
    </main>

</body>
    <!-- jquery -->
    <script src="<?= base_url(); ?>/assets/jquery-3.6.1/jquery-3.6.1.min.js"></script>
    <!-- jquery confirm -->
    <script src="<?= base_url(); ?>/assets/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
    <!-- bootstrap js -->
    <script src="<?= base_url(); ?>/assets/bootstrap-5.2.2/js/bootstrap.bundle.min.js"></script>
	<!-- Custom Loaded Js -->
	<?php foreach ($js as $row): ?>
        <script src="<?= base_url(); ?><?= $row ?>"></script>
    <?php endforeach ?>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</html>