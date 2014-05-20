<section id="content">

	<?php require_once '_box_callback.php'; ?>

	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<a itemprop="url" href="/"><span itemprop="title">Main</span></a>
		/
		<span itemprop="title"><?=$cat_name?></span>
	</div>


	<h1 class="title">Фотообои <?= $_GET['alt'].''; ?></h1>

	<div class="pagin">
		<?=$pagin?>
	</div>

	<div id="gallery_box">
		<?php foreach($gallery as $k):?>
		<div class="gallery_item">
			<div class="item_img">
				<a class="preview" rel="no-follow" name="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_l_<?=$k->articul?>.jpg" desc="<?=$k->alt;?>">
					<img alt="<?=$k->title_image?>" src="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_m_<?=$k->articul?>.jpg">
				</a>
			</div>
			<div>
				<div class="item_articul"><a href="<?=base_url(); ?>/crop-image?title=<?=$k->articul?>"><?=$k->title_image == '' ? $k->articul : $k->title_image;?></a></div>
				<div class="item_buttons">
					<a class="add_favorit <?=in_array($k->articul, $favorit) ? ' activ': '';?>" help="4_b" folder="<?=$k->id_cat?>" i="<?=$k->articul?>" rel="nofollow">A</a>
					<a class="crop-for-size" help="5_b" href="<?=base_url(); ?>/crop-image?title=<?=$k->articul?>" rel="nofollow">B</a>
					<a class="view-interior"  help="6_b"  onclick="entryClMail('yourSelect', '<?=$k->articul?>', '/img/gallery/<?=$k->id_cat?>/thumbs/thumb_m_<?=$k->articul?>.jpg')">[</a>
					<a class="butt_ ord" href="<?=base_url(); ?>/crop-image?title=<?=$k->articul?>" rel="nofollow">Заказать</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<div class="clear"></div>
	</div>

	<div class="pagin">
		<?=$pagin?>
	</div>

	<?php if(!isset($_GET['page'])):?>

		<?=$text?>

	<?php endif;?>

</section>