<?php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login In | Geoffrey MDB</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<!-- Google Fonts -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<!-- Material Design Bootstrap -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <style>
           /*LOGIN*/
        body {
            background-color:#f1f1f1a9;
        }
        .login {
            max-width: 380px!important;
            margin: 0 auto!important;
            padding: 40px 40px 50px;
            border: 1 solid #f1f1f1a9;
            border-radius: 10px;
            background-color: #fff;
        }
        /*l-bg f1f1f1a9*/
		
		.justificate-page {margin: 0 auto!important; padding-top: 180px!important;}
        /*!LOGIN*/
    </style>
</head>
<body>

	<div class="justificate-page">
    <!--CONTENT -->
    <div class="login">

	  <h5 class="text-info white-text text-center py-4">
		<strong>Login Geoffrey MDB</strong>
	  </h5>

		<!--Card content-->
		<div class="card-body px-lg-5 pt-0">

			<!-- Form -->
			<form class="text-center" style="color: #757575;" action="#!">

			  <!-- Email -->
			  <div class="md-form">
				<input type="email" id="materialLoginFormEmail" class="form-control">
				<label for="materialLoginFormEmail">E-mail</label>
			  </div>

			  <!-- Password -->
			  <div class="md-form">
				<input type="password" id="materialLoginFormPassword" class="form-control">
				<label for="materialLoginFormPassword">Password</label>
			  </div>
			  
			  <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">LOGIN<i class="fa fa-paper-plane mx-2"></i></button>
		  
			</form>
		</div>   
		<!-- END CONTENT -->
	</div>
    </div>  
    <div class="text-center"><small> <a href="https://linkedin.com/in/geoffreylgv">Make and disign by geoffrey</small> with love <i class="fa fa-heart text-danger"></i></a></div> 
</body>
</html>