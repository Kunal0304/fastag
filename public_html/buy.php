<!DOCTYPE html>
<html>
<head>
<title>BIONIQE SALES LINE : Fastag..</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--jQuery(necessary for Bootstrap's JavaScript plugins)-->
<script src="js/jquery-1.11.0.min.js"></script>
<!--Custom-Theme-files-->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Luxury Watches Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<!--start-menu-->
<script src="js/simpleCart.min.js"> </script>
<link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>	
<!--dropdown-->
<script src="js/jquery.easydropdown.js"></script>	
    <script src="cities.js"></script>
		
</head>
<body> 
	<!--top-header-->
	<div class="top-header">
		<div class="container">
			<div class="top-header-main">
				<div class="col-md-6 top-header-left">
					<div class="">
						<div class="box">
								<p class="label" style="font-size:14px"><i class=" "></i>Call Us :  +91-0000000000</p>
								
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
    

<?php
include("includes/connection.php");
error_reporting(0);
		if(isset($_POST['submit']))
		{
		extract($_POST);
		$ss=mysqli_query($conn, "select max(id) mid from `shiping`") or die(mysqli_error());
		$rr=mysqli_fetch_array($ss);
		$id=$rr['mid'];
		$id=$id+1;
		
		echo $id;
		$sql = mysqli_query($conn, "INSERT INTO  `shiping` (`id`, `name`, `mobile`, `add`,`sname`, `smobile`, `sadd`, `city`, `state`, `date`, `pincode`, `vh_no`) VALUES ('$id', '$name', '$mob', '$add', '$sname', '$smob', '$sadd', '$city', '$stt', '', '$pin', '$vno');") or die(mysqli_error());
		if($sql)
		{?>
		<script type="text/javascript">
		alert("Details Added Successfully..!!");
		window.location.href="buy.php";
	</script>
	<?php
		}	
	}	
?>
	<!--top-header-->
	<!--start-logo-->
	<div class="logo">
		<a href="index.html"><h1>Bioniqe sales line</h1></a>
	</div>
	<!--start-logo-->
	<!--bottom-header-->
	<div class="header-bottom">
		<div class="container">
			<div class="header">
				<div class="col-md-9 header-left">
				<div class="top-nav">
					<ul class="memenu skyblue"><li class="active"><a href="index.php">Home</a></li>
						
						<li class="grid"><a href="about.php">About Us</a>
						</li>
						<li class="grid"><a href="contact.php">Contact</a>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
			
		</div>
	</div>
	<!--bottom-header-->
	<!--start-breadcrumbs-->
	<div class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs-main">
				<ol class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active">Personal & Shipping Details</li>
				</ol>
			</div>
		</div>
	</div>
	<!--end-breadcrumbs-->
	<!--contact-start-->
	<div class="contact">
		<div class="container">
			<div class="contact-top heading">
			</div>
				<div class="contact-text">
				<div class="col-md-3 contact-left">
						<div class="address">
							<h5>Product Details</h5>
							<p><img src="f.png" width="200"><br>
<br>

                           Unit Price- Rs 200/-</p><br>
<br>
<br>
<br>




						</div>
					</div>
                    	<form name="details" action="#" method="post">
						<h3>Personal Details</h3>

					<div class="col-md-9 contact-right">
							<input type="text" name="name" placeholder="Name">
							<input type="text" name="mob" placeholder="Phone">
						
					</div>
                  
                    <div class="col-md-9 contact-right">
							<input type="text"  name="email" placeholder="Email">
							<input type="text" name="add" placeholder="Address">
                            							<input type="text"  name="vno" placeholder="Car/Bus/Truck No">

						
				
					</div>		
						<h3>Shipping Details</h3>

					<div class="col-md-9 contact-right">
							<input type="text" name="sname" placeholder="Name">
							<input type="text" name="smob" placeholder="Phone">

						
					</div>

                

                    <div class="col-md-9 contact-right">

												<input type="text" name="pin" placeholder="Pincode">

							<input type="text" name="sadd" placeholder="Address">
						
					</div>
    <div class="col-md-9 contact-right">

					<select onchange="print_city('state', this.selectedIndex);" id="sts" name ="stt" required style="height:55px"></select>
					
                    <select id ="state" name="city" required style="height:55px"></select>
<script language="javascript">print_state("sts");</script>
							<input type="text"  name="country" readonly placeholder="INDIA" value="INDIA">
						
					</div><br>
<hr>		
								<input type="submit" name="submit" class="btn btn-danger"  value="PROCEED">

                            						</form>

					<div class="clearfix"></div>
				</div>
		</div>
	</div>
	<!--contact-end-->
	<!--map-start-->
	<br>
<br>
<hr>
	<!--information-starts-->
	<div class="information">
		<div class="container">
			<div class="infor-top">
		
				<div class="col-md-3 infor-left">
					<h3>My Account</h3>
					<ul>
						<li><a href="account.html"><p>My Account</p></a></li>
						<li><a href="#"><p>Terms & Conditions</p></a></li>
						<li><a href="#"><p>Return Policy</p></a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>Store Information</h3>
					<h4>The company name,
						<span>Lorem ipsum dolor,</span>
						Glasglow Dr 40 Fe 72.</h4>
					<h5>+955 123 4567</h5>	
					<p><a href="mailto:example@email.com">contact@example.com</a></p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--information-end-->
	<!--footer-starts-->
	<div class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="col-md-6 footer-left">
					
				</div>
				<div class="col-md-6 footer-right">					
					<p>© 2021 Bioniqe Sales Line. All Rights Reserved </p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--footer-end-->	
</body>
</html>