<section>
<script type="text/javascript">

</script>
	
	<?php require_once '_box_callback.php'; ?>
	
	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<!--<a itemprop="url"  href="<?=$lang?>/"><span itemprop="title"><?=$lang == '/ua' ? 'Головна' : 'Main' ?></span></a>
		/-->
		
		<a itemprop="url"  href="<?php echo base_url(); ?>">
        <!--<span itemprop="title"><?=$lang == '/ua' ? 'Головна' : 'Main' ?>
        </span>-->
        </a>
		
	<!--	<span itemprop="title"><?=$lang == '/ua' ? 'фреска' : 'фреска'?></span>-->
	</div>
	
	
<style>
	
</style>
	
	
	<h1 class="title"><?=$lang == '/ua' ? 'Текстури і ціни на фрески' : 'Текстуры и цены на фрески'?></h1>
	
	
	<div class="all-textures">
		<?php foreach($textures as $key=>$values):?>
			<div class="some-texture">
				<h3><?= $lang == '/ua' ? $values->name_ua : $values->name ?></h3>
				<div class="img-textures">
					<img src="<?=base_url(); ?>/img/mural/thumb_l_<?= $values->id; ?>.jpg" class="clear-texture" alt="<?=$lang=='/ua' ? $values->alt_ua : $values->alt;?>">
					<img src="<?=base_url(); ?>/img/mural/example|<?= $values->id; ?>.jpg" class="example-texture" alt="<?=$lang=='/ua' ? $values->alt_example_ua : $values->alt_example;?>">
				</div>
				<div class="price-textures">
					<p><?= $lang == '/ua' ? 'Ціна: ' : 'Цена: ' ?><?= $values->price; ?> грн. м кв.</p>
				</div>
				<div class="description-texture">
					<p><?= $lang == '/ua' ? $values->text_ua :  $values->text ?></p>
				</div>
			</div>
		<?php endforeach;?>
	</div>
	<article>
ky-ky    
    
		<?=$text?>
	</article>
	
</section>
