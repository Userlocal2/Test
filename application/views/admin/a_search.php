<section>	<h1 class="title"><?=$info?></h1>		<?php if(!$search):?>			найдено 0			<?php else:?>		<div id="gallery_box">		<?php if(count($search)):?>			<table id="gb">				<tr class="gb_f">					<td class="td_c1" style="width:1%;">№</td>					<td class="td_c1" style="width:1%;">						<input type="checkbox" onclick="allSelect(this)" value="" name="">					</td>					<td class="td_c1" style="width:1%;"></td>					<td class="td_c1" style="width:1%;">Артикул</td>					<td class="td_c1" style="width:1%;">категория</td>					<td class="td_c1" style="width:1%;">подкатегория</td>					<td class="td_c1">title</td>					<td class="td_c1">title(UA)</td>					<td style="text-align:center;">alt</td>					<td style="text-align:center;">alt(UA)</td>					<td class="td_c1" style="width:1%;">ширина<br>см.</td>					<td class="td_c1" style="width:1%;">высота<br>см.</td>					<td class="td_c1" style="width:1%;">hits</td>					<td class="td_c1" style="width:1%;">page<br>hits</td>					<td class="td_c1" style="width:1%;">visible</td>					<td class="td_c1" style="width:1%;"></td>					<td class="td_c1" style="width:1%;"></td>				</tr>							<?php $i=1; foreach($search as $k):?>				<tr>					<td class="td_c1"><?=$i?></td>					<td class="td_c1"><input class="ch_imgs" type="checkbox" value="<?=$k->id?>" name="g_img[]" onclick="selCountChechBox()"></td>					<td class="td_c1" style="line-height:0;">						<a class="preview" name="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_l_<?=$k->articul?>.jpg">							<img src="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_sb_<?=$k->articul?>.jpg">						</a>					</td>					<td class="td_c1"><?=$k->articul?></td>					<td class="td_c1"><a href="<?=base_url(); ?>/administrator/gallery/?id_cat=<?=$k->id_cat?>"><?=$k->cat_name?></a></td>					<td class="td_c1">						<select name="subcategory" onchange="selSubcategory($(this),<?=$k->id?>)">							<option value="0">-</option>							<?php foreach($subcategory as $jj):?>								<option value="<?=$jj->id?>" <?=$k->id_subcat == $jj->id ? 'selected' : '';?>><?=$jj->name?></option>							<?php endforeach;?>						</select>					</td>					<td td-click="gallery" column="title_image" i="<?=$k->id?>" class="td_c1"><?=$k->title_image?></td>					<td td-click="gallery" column="title_image_ua" i="<?=$k->id?>" class="td_c1"><?=$k->title_image_ua?></td>					<td td-click="gallery" column="alt" i="<?=$k->id?>"><?=$k->alt?></td>					<td td-click="gallery" column="ua_alt" i="<?=$k->id?>"><?=$k->ua_alt?></td>					<td class="td_c1"><?=$k->width_cm?></td>					<td class="td_c1"><?=$k->height_cm?></td>					<td class="td_c1" td-click="gallery" column="hits" i="<?=$k->id?>"><?=$k->hits?></td>					<td class="td_c1" td-click="gallery" column="hits2" i="<?=$k->id?>"><?=$k->hits2?></td>					<td class="td_c1"><a id="vis_<?=$k->id?>" class="<?=$k->visibility == 1 ? 'visible' : 'hidden'?>" onclick="visible(<?=$k->id?>, <?=$k->visibility?>, 'gallery')"></a></td>					<td class="td_c1"><a class="link_edit" href="<?=base_url(); ?>/administrator/gallery/?update=<?=$k->id?>" title="редактировать"></a></td>					<td class="td_c1"><a class="link_del" onclick="del(<?=$k->id?>, 'gallery_img', '<?=$k->articul?>')" title="удалить"></a></td>				</tr>			<?php $i++; endforeach;?>			</table>		<?php endif;?>	</div><script>function selSubcategory(_this, id){	var text = _this.find('option:selected').val();	var div = $('<div>').css({position:'fixed',zIndex:10000,top:0,bottom:0,left:0,right:0,background:'#fff',opacity:0.3});	$('body').append(div);	$.post('/administrator/edit_column',{table:'gallery', column:'id_subcat', id:id, text:text},function(){		div.remove();	});}</script>		<?php endif;?>		</section><!--CENTER-->