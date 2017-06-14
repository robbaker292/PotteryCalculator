<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/navbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/dataTables.bootstrap.min.css">    

    <script src="<?php echo asset_url(); ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/d3.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/dashboard.js"></script>
    <script src="<?php echo asset_url(); ?>js/navbar.js"></script>
    <script src="<?php echo asset_url(); ?>js/main.js"></script>

	<title><?php echo $title; ?></title>
</head>
<body>
	<header class="container">
		<div class="col-md-12">
			<h1>Pottery by Andrew Macdermott</h1>
			<nav id="nav-main">
			    <ul>
			        <li><a href="<?php echo base_url(); ?>">Home</a></li>
			        <li><a href="<?php echo base_url(); ?>">Events</a></li>
			        <li><a href="<?php echo base_url(); ?>/Product/listAll">Products</a></li>
			        <li><a href="<?php echo base_url(); ?>">Resources</a></li>
			    </ul>
			</nav>
		</div>
	</header>
	
<main class="container">
<div class="col-md-12">
	<div class="letter">