<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/dataTables.bootstrap.min.css">    

    <script src="<?php echo asset_url(); ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootstrap-select.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/bootbox.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/d3.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/main.js"></script>
    <script src="<?php echo asset_url(); ?>js/saveData.js"></script>

    <?php
    if(strtolower($this->uri->segment(1)) == 'dashboard' || ($this->uri->segment(1) === null)) { ?>
    <script src="<?php echo asset_url(); ?>js/dashboard.js"></script>
    <?php } ?>

    <?php if(strtolower($this->uri->segment(1)) == 'sale' ) { ?>
    <script src="<?php echo asset_url(); ?>js/sale.js"></script>
    <?php } ?>

	<title><?php echo $title; ?></title>
</head>
<body>
	<header class="container">
		<div class="col-md-12">
			<h1>Pottery by Andrew Macdermott</h1>

            <div class="btn-group btn-group-justified">
                <a href="<?php echo base_url(); ?>Dashboard" class="btn btn-primary"><h4 class="panel-title"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;Dashboard</h4></a>
                <a href="<?php echo base_url(); ?>Event/listAll" class="btn btn-primary"><h4 class="panel-title"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;Events</h4></a>
                <a href="<?php echo base_url(); ?>Product/listAll" class="btn btn-primary"><h4 class="panel-title"><i class="fa fa-coffee" aria-hidden="true"></i>&nbsp;&nbsp;Products</h4></a>
                <a href="<?php echo base_url(); ?>Resource/listAll" class="btn btn-primary"><h4 class="panel-title"><i class="fa fa-cubes" aria-hidden="true"></i>&nbsp;&nbsp;Resources</h4></a>
                <a href="<?php echo base_url(); ?>Settings/listAll" class="btn btn-primary"><h4 class="panel-title"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Settings</h4></a>
                <a href="<?php echo base_url(); ?>sale/edit/-1" class="btn btn-success"><h4 class="panel-title"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add Sale</h4></a>
            </div>
            <!--
			<nav id="nav-main">
			    <ul>
			        <li><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
			        <li><a href="<?php echo base_url(); ?>Event/listAll">Events</a></li>
			        <li><a href="<?php echo base_url(); ?>Product/listAll">Products</a></li>
			        <li><a href="<?php echo base_url(); ?>Resource/listAll">Resources</a></li>
                    <li><a href="<?php echo base_url(); ?>sale/edit/-1">Add Sale</a></li>
			    </ul>
			</nav>
        -->
		</div>
	</header>
	
<main class="container">
<div class="col-md-12">
	<div class="letter">