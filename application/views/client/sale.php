<section>

	<?php require_once '_box_callback.php'; ?>
	
	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<a itemprop="url" href="/"><span itemprop="title">Main</span></a>
		/
		<?php if($parent_url):?>
		<a href="/<?=$parent_url?>.html"><?=$parent_name?></a>
		/
		<?php endif;?>
		<span itemprop="title"><?=$name ?></span>
	</div>
	
		<?php if($name_as_h1 == 1):?>
			<h1 class="title"><?=$name?></h1>
		<?php endif;?>
		<article>
			<?=$text?>
		</article>
                <?php foreach ($images as $val):?>
                    <div class="lot_for_sale">
                        <div class="lot_for_sale_div_left">
                            <img alt="<?= $val->alt; ?>" title="<?= $val->alt; ?>" src="/img/sale/<?=$val->article;?>.jpg" >
                        </div>
                        <div class="lot_for_sale_div_right">
                            <span>№ <?=$val->article;?></span><br>
                            <span><strong>Размер</strong> - <?=$val->width;?> мм(шир)х<?=$val->height;?> мм(выс).</span><br>
                            <span><strong>Текстура</strong> - <?= $val->texture; ?>.</span><br>
                            <span>Старая цена</span><br>
                            <span style=" font-weight: bold; text-decoration: line-through;"><?=$val->old_price;?> р.</span><br>
                            <span>Новая цена</span>
                            <span style="font-size: medium; color: red"><strong><?=$val->new_price?> р.</strong></span>
                        </div>
                    </div>        
                <?php endforeach;?>
		
		<div style="text-align:center;padding:10px 0;">
			<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
			<div class="yashare-auto-init" data-yashareL10n="ru"data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,odnoklassniki,gplus"></div> 
		</div>
		
</section>
				
				
			


