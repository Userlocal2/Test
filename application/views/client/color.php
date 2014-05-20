<section id="content">

	<?php require_once '_box_callback.php'; ?>
	
	<div class="crumbs">
		<a href="/">Main</a>
		/
		<?php if($color):?>
		<a href="<?=base_url(); ?>/color">подбор фотообоев по цвету</a>
		/
		<span><?=$colors[$color];?></span>
		<?php else:?>
		<span>подбор фотообоев по цвету</span>
		<?php endif;?>
	</div>
	
	
	<h1 class="title"><?=$name?>  <?=count($gallery) != 0 ? ' - "'.$colors[$color].'" <span class="_color c_'.$color.'"></span>' : ''?></h1>
	
	<?php if(count($gallery)):?>
	<div class="sort">
		<form action="" method="post">
			<div style="float:left;">
				Выводить по:
				<select class="graph" onchange="this.form.submit()" name="view_count">
				<?php foreach($view_count as $k=>$v):?>
					<?php if($_SESSION['view_count'] == $k):?>
					<option value="<?=$k?>" selected><?=$v?></option>
					<?php else:?>
					<option value="<?=$k?>"><?=$v?></option>
					<?php endif;?>
				<?php endforeach;?>
				</select>
			</div>
			
			<div style="float:left;margin-left:20px;">
				<a id="gor" help="1_t" class="gorizont <?=$_SESSION['hor'] == 2 ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val(2);$('form').submit()">O</a>
				<a id="ver" help="2_t" class="gorizont <?=$_SESSION['hor'] == 1 ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val(1);$('form').submit()">P</a>
				<a id="g_v" help="3_t" class="gorizont <?=$_SESSION['hor'] == 0 ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val(0);$('form').submit()">Y</a>
				<input id="sel_hor" type="hidden" value="" name="hor">
			</div>
		</form>
		<div style="clear:both;"></div>
	</div>
	
	
	<div class="pagin">
		<?=$pagin?>
	</div>

	
	<div id="gallery_box">
		<?php foreach($gallery as $k):?>
		<div class="gallery_item">
			<div class="item_img">
				<a class="preview" rel="no-follow" name="<?=base_url(); ?>/img/gallery/<?=$k->id_cat?>/thumbs/thumb_l_<?=$k->articul?>.jpg" desc="<?=$k->alt;?>">
					<img alt="<?=$k->alt?>" src="<?=base_url(); ?>/img/gallery/<?=$k->id_cat?>/thumbs/thumb_m_<?=$k->articul?>.jpg">
				</a>
			</div>
			<div>
				<div class="item_articul"><?=$k->articul?></div>
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
	
	<?php else:?>
	
	<style>
	.box_item_color{
		margin:10px 0;
		padding:10px 0;
		border:1px solid #ccc;
		border-radius:3px;
		text-align:center;
		font-size:0;
	}
	.box_item_color a{
		display:inline-block;
		width:60px;
		height:60px;
		border:1px solid #ccc;
		opacity:0.8;
	}
	.box_item_color a:hover{
		opacity:1;
	}
	</style>
	
	<div style="background:#F2F2DE;padding:5px;">
	
		<p><?=$text?></p>
		
		<div class="box_item_color">
			<a style="background:#CC0000;" href="/color/red.html"></a>
			<a style="background:#FB940B;" href="/color/orange.html"></a>
			<a style="background:#FFFF00;" href="/color/yellow.html"></a>
			<a style="background:#00CC00;" href="/color/green.html"></a>
			<a style="background:#03C0C6;" href="/color/azure.html"></a>
			<a style="background:#0000FF;" href="/color/blue.html"></a>
			<a style="background:#762CA7;" href="/color/violet.html"></a>
			<a style="background:#FF98BF;" href="/color/pink.html"></a>
			<a style="background:#FFFFFF;" href="/color/white.html"></a>
			<a style="background:#999999;" href="/color/grey.html"></a>
			<a style="background:#000000;" href="/color/black.html"></a>
			<a style="background:#885418;" href="/color/brown.html"></a>
		</div>
	</div>
	
	<?php endif;?>
	
</section>