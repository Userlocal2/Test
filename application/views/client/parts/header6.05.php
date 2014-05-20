<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title><?=isset($_GET['page']) ? 'стр.№'.(int)$_GET['page'].'.' :''?><?=$title?></title>
		<meta name="description" content="<?=$metadesc?>">
		<meta name="keywords" content="<?=$metakey?>">
		<meta name="robots" content="<?=$nobots?>index, <?=$nofollow?>follow">
		<meta name="revisit-after" content="7 days">
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<?=$canonical?>
		<link rel="shortcut icon" href="<?= base_url();?>/favicon.ico" type="image/x-icon">
		<link type="text/css" rel="stylesheet" href="<?= base_url();?>/css/style.css">
        <link href="<?= base_url();?>/js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />
        
		<?=$this->uri->segment(1) == 'crop-image' ? '<link type="text/css" rel="stylesheet" href="'.base_url().'/css/crop-image.css">' : ''?>
		<?=$this->uri->segment(1) == 'crop-image' ? '<script src="'.base_url().'/js/crop-image.js" type="text/javascript"></script>' : ''?>
		<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="/css/ie6.css">
		<![endif]-->
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="/css/ie7.css">
		<![endif]-->
		<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="/css/ie8.css">
		<![endif]-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<!--<script src="<?= base_url();?>/js/jquery.1.4.js" type="text/javascript"></script>-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="<?= base_url();?>/js/functions.js" type="text/javascript"></script>
		<script src="<?= base_url();?>/js/drag.js" type="text/javascript"></script>
        <script src="<?= base_url();?>/js/jquery.bxslider/jquery.bxslider.min.js"></script>
        <script src="<?= base_url();?>js/jquery.squarecrop.js" type="text/javascript"></script>
		
	</head>
	<body>
		<div id="main">

			<header style="position:relative;">
				<div class="search_box">
					<form action="<?= base_url();?>/search" method="get" enctype="multipart/form-data">
						<div style="position:relative;">
							<input class="button_search" type="submit" value="">
                            <input class="text_search" type="text" value="" size="20" name="s" autocomplete="off" >
						</div>
</form>
				</div>

				<div class="box_logo" itemscope itemtype="http://schema.org/Organization">
					<!--<a href="/"  itemprop="url">-->
					
					<a href="<?php echo base_url()?>"  itemprop="url">
                        <img src="<?=base_url();?>img/i/logo.png" itemprop="logo" width="161">
					</a>
				</div>
				
				<nav>
					<ul class="navigation">                                                           
						<?php foreach($all_pages as $k):?>
						<?php 
                        
//print_r($k->url);
                        
                        if($k->type == 'top-menu'):?>
							<li><a href="<?=base_url().$k->url?>.html"><?=$k->name?></a></li>
						<?php endif;?>
						<?php endforeach;?>
					</ul>
				</nav>
			</header>
			<section>