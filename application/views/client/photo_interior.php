<section>	<?php require_once '_box_callback.php'; ?>		<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">		<a itemprop="url" href="/"><span itemprop="title">Main</span></a>		/		<span itemprop="title"><?=$name?></span>	</div>		<?php if($name_as_h1 == 1):?>		<h1 class="title"><?=$name?></h1>	<?php endif;?>		<article>		<?=$text?>	</article>		<div style="background:#F2F2DE;padding:5px;text-align:center;">		<?php foreach($type_interior as $k):?>		<a class="filter <?=@$_SESSION['type_interior'] ==  $k->id ? 'checked' :''?>" href="<?=base_url(); ?>/photooboi-interior.html?type=<?=$k->id?>"><?=$k->name?></a>		<?php endforeach;?>		<a class="filter <?=@$_SESSION['type_interior'] == 0 ? 'checked' : '';?>" href="<?=base_url(); ?>/photooboi-interior.html?type=0">все</a>	</div>		<div class="pagin"><?=$pagin?></div>		<div id="gallery_box" style="margin:10px 0 0 0;overflow:hidden;">		<?php foreach($interior as $k):?>				<div class="interior_item">			<a class="preview_interior" parent="<?=$k->articul_parent?>" name="<?=base_url(); ?>/img/interior/thumb_l_<?=$k->id?>.jpg">				<img src="<?=base_url(); ?>/img/interior/thumb_m_<?=$k->id?>.jpg" alt="<?=$k->alt?>">			</a>						<div style="font-size:11px;text-align:left;padding:10px 0 0 0;text-align:justify;">				<?=$k->text?>			</div>						<div style="position:absolute;bottom:10px;width:100%;">				<a class="butt_" style="padding:0 15px;" href="<?=base_url(); ?>/crop-image?title=<?=$k->articul_parent?>">order</a>			</div>		</div>				<?php endforeach;?>	</div>		<div class="pagin"><?=$pagin?></div>	</section>											