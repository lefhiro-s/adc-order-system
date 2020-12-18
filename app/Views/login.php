<!DOCTYPE html>
<html lang="en">
<head>
	<title>PEL 2.0 | <?=$title?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?= $this->section('head') ?>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/css/util.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/login/css/main.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/css/bootstrap3.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/lib/css/font-awesome.min.css')?>">

	<?= $this->endSection() ?>

	<?= $this->include('layouts/head') ?>
	<!-- js -->

	<!-- initGui js -->
	<script>$(document).ready(function(){ window.initGUI()}); </script>
	<!-- /initGui js -->

</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form validate-form">
					<span class="login100-form-title p-b-43">
						Bienvenid@
					</span>
					<div id="alert-email-incorrect" class="alert-danger-field inactive-display">
						<span></span>
					</div>									
					<div class="wrap-input100 validate-input" 
						 data-validate = "Se requiere un correo electrónico válido: example@example.com">
						<input class="input100 input100-email" type="text" name="email" value="<?= $remenber ?: '' ?>">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Se requiere una contraseña">
						<input class="input100" type="password" name="pass">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="login100-submit">
							Login
						</button>
					</div>
				</div>
				<div class="login100-more" style="background-image: url(<?=base_url('assets/login/images/bg-01.jpg');?>">
				</div>
			</div>
		</div>
	</div>

	<?= $this->include('layouts/loader') ?>

	
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/jquery/jquery-3.2.1.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/animsition/js/animsition.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/bootstrap/js/popper.js')?>"></script>
	<script src="<?=base_url('assets/login/vendor/bootstrap/js/bootstrap.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/select2/select2.min.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/daterangepicker/moment.min.js')?>"></script>
	<script src="<?=base_url('assets/login/vendor/daterangepicker/daterangepicker.js')?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('assets/login/vendor/countdowntime/countdowntime.js')?>"></script>
<!--===============================================================================================-->

</body>
</html>