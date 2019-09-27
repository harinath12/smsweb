<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MySkoo App</title>	
	<?php include "head-guest.php"; ?>
</head>
<body>	
<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form action="dologin.php" method="post">
						<div class="panel panel-body login-form">							
							<div class="text-center mb-20">
								<div class="icon-object border-slate-300 text-slate-300"><i class="fa fa-user"></i></div>
								<h5 class="content-group">Login to your account <small class="display-block">Please put your credentials</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" placeholder="Username" name="username" required="required">
								<div class="form-control-feedback">
									<i class="fa fa-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" placeholder="Password" name="password" required="required">
								<div class="form-control-feedback">
									<i class="fa fa-lock text-muted"></i>
								</div>
							</div>

							<div class="login-options">
								<div class="row">
									<div class="col-sm-6">
										<div class="checkbox ml-5">
											<label>
												<input type="checkbox" class="styled" checked="checked">
												Remember me
											</label>
										</div>
									</div>

									<div class="col-sm-6 text-right mt-10">
										<a href="http://localhost/templates/bird/theme/login_password_recover.html">Forgot password?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="button" name="login" class="btn btn-info btn-lg btn-labeled btn-labeled-right btn-block"><b><i class="fa fa-sign-in"></i></b> Sign in</button>
							</div>						
						</div>
						
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2016 Bird - Admin theme by <a href="http://followtechnique.com" target="_blank">FollowTechnique</a>&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;Version - 1.0.0
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
<script>
$(function() {
	$(".styled, .multiselect-container input").uniform({
		radioClass: 'choice'
	});
});
</script>
</body>
</html>