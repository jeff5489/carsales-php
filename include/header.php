<?php
	// session_start();
?>

<!DOCTYPE html>
	<html>
		<head>
			<title>Used Cars</title>

			<meta charset="utf-8">
    		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
			<link rel="stylesheet" href="../main.css" >

			<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>			<link rel="stylesheet" href="../main.css">
			<style>
				.bigImage {
					position: relative;
					text-align: center;
					color: white;
				}

				#imageText{
					/* background-color: white; */
					color: black;
				}
				.centered {
					position: absolute;
					top: 25%;
					left: 50%;
					transform: translate(-50%, -50%);
				}
				#imageText h1 {
					font-size: 75px;
				}
			</style>
		</head>
	<body class="bg-dark">

		<div class="container ">
			<div class="row  d-flex justify-content-center">
				<div class="col-9">
					<div class="bigImage ">
						<img src="./images/road1.jpg" style="width:100%;">
						<div id="imageText" class="centered ">
							<h1 class="">Used Car Sales</h1>  
						</div>
					</div>
				</div>
			</div>
		</div>

		<header class="text-center" name="home">
			<div class="intro-text centered">
				<h1 class="blackText"><strong class="blackText">Car Sales</strong></h1>
			</div>
		</header>
