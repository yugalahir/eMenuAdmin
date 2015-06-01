<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="TABEER AHMAD RIZAVI, KUL BHUSHAN GUPTA">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/header.png">

    <title><?php echo $page_title; ?></title>

    <!--Core CSS -->
   
	 <link href="<?php echo base_url();?>assets/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

    
</head>
<body>
<section id="container" >
