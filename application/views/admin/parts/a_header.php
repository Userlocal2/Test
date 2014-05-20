<!DOCTYPE html>
<html>
<head>
	<!--[if IE]>
	<script>
		document.createElement('header');
		document.createElement('nav');
		document.createElement('section');
		document.createElement('article');
		document.createElement('aside');
		document.createElement('footer');
	</script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?=base_url(); ?>css/admin_style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>uploadify/uploadify.css">
	<script type="text/javascript" src="<?=base_url(); ?>js/jquery.1.7.1.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>uploadify/jquery.uploadify.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>js/admin_functions.js"></script>
	<title>Администратор</title>
</head>
<body>
	<div id="main">
	
		<header>
			<div class="search_box">
				<form action="<?=base_url(); ?>administrator/search" method="get" autocomplete="off">
					<input id="search" class="text_search" type="text" value="" name="search" autocomplete="off">
				</form>
			</div>
			
			<div class="box_logo">
				<a id="logo" href="<?=base_url(); ?>administrator"></a>
			</div>
			
			<div class="logout">	
				<a href="<?=base_url(); ?>administrator/logout">выход</a>
				<a href="/" target="_blank">сайт</a>
			</div>
			
		</header>
		<section>
			<ul class="menu_admin">
				<li>
					<a class="<?=$action == 'pages'?'ch':'';?>" href="<?=base_url(); ?>/administrator/pages">Страницы</a>
				</li>
				<li>
					<a class="<?=$action == 'category'?'ch':'';?>" href="<?=base_url(); ?>/administrator/category">Категории</a>
				</li>
                                 <li>
					<a class="<?=$action == 'subcategoryManager'?'ch':'';?>" href="<?=base_url(); ?>/administrator/subcategorymanager">Подкатегории</a>
				</li>
				<li>
					<a class="<?=$action == 'gallery'?'ch':'';?>" href="<?=base_url(); ?>/administrator/gallery">Галерея</a>
				</li>
<li>
					<a class="<?=$action == 'bigstok'?'ch':'';?>" href="<?=base_url(); ?>/administrator/bigstock">Bigstok</a>
				</li>                
                
                
                

<li>
					<a class="<?=$action == 'bigstok'?'ch':'';?>" href="<?=base_url(); ?>/administrator/bigstock_edit">Bigstok_Edit</a>
				</li>


                
                
                
				<li>
					<a class="<?=$action == 'textura'?'ch':'';?>" href="<?=base_url(); ?>/administrator/textura">Текстуры</a>
				</li>
				<!--<li>
					<a class="<?=$action == 'mural'?'ch':'';?>" href="/administrator/mural">Фрески</a>
				</li>-->
				<li>
					<a class="<?=$action == 'interior'?'ch':'';?>" href="<?=base_url(); ?>/administrator/interior">Интерьеры</a>
				</li>
				<li>
					<a class="<?=$action == 'info'?'ch':'';?>" href="<?=base_url(); ?>/administrator/info">e-mail / tel</a>
				</li>
				<li>
					<a class="<?=$action == 'images'?'ch':'';?>" href="<?=base_url(); ?>/administrator/images">Изображения</a>
				</li>
                                <li>
					<a class="<?=$action == 'update_alt'?'ch':'';?>" href="<?=base_url(); ?>/administrator/updatealtimages">Обновление alt</a>
				</li>
                                <li>
                                        <a class="<?=$action == 'loading_sale_images' ? 'ch' : ''; ?>" href="<?=base_url(); ?>/administrator/loading_sale_images">Изображения распродажи</a>
                                </li>
                                 <li>
					<a class="<?=$action == 'reviews'?'ch':'';?>" href="<?=base_url(); ?>/administrator/reviews">Отзывы</a>
				</li>
                <li>
					<a class="<?=$action == 'materials'?'ch':'';?>" href="<?=base_url(); ?>/administrator/materials">Материалы</a>
				</li>
			</ul>