<section>
	
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?> <a title="добавить" class="link_add" href="<?=base_url(); ?>/administrator/mural/?add"></a></h1>
	
	<div id="gallery_box">
		<table id="gb">
			<tr class="gb_f">
				<td class="td_c1" style="width:1%;">№</td>
				<td class="td_c1" style="width:1%;">фреска</td>
				<td style="text-align:center;">альт.</td>
				<td style="text-align:center;">(UA)альт.</td>
				<td class="td_c1" style="width:1%;">пример</td>
				<td style="text-align:center;">альт-пример</td>
				<td style="text-align:center;">(UA)альт-пример</td>
				<td style="text-align:center;">название</td>
				<td style="text-align:center;">(UA)название</td>
				<td class="td_c1">цена</td>
				<td class="td_c1" style="width:1%;">visible</td>
				<td class="td_c1" style="width:1%;"></td>
				<td class="td_c1" style="width:1%;"></td>
			</tr>
			
			<?php $i=1; foreach($mural as $k):?>
			<tr>
				<td class="td_c1"><?=$i?></td>
				<td class="td_c1" style="line-height:0;">
					<a class="preview" name="/img/mural/thumb_l_<?=$k->id?>.jpg">
						<img src="/img/mural/thumb_s_<?=$k->id?>.jpg">
					</a>
				</td>
				<td td-click="mural" column="alt" i="<?=$k->id?>"><?=$k->alt?></td>
				<td td-click="mural" column="alt_ua" i="<?=$k->id?>"><?=$k->alt_ua?></td>
				<td class="td_c1" style="line-height:0;">
					<a class="preview" name="/img/mural/example|<?=$k->id?>.jpg">
						<img src="/img/mural/example|s_<?=$k->id?>.jpg">
					</a>
				</td>
				<td td-click="mural" column="alt_example" i="<?=$k->id?>"><?=$k->alt_example?></td>
				<td td-click="mural" column="alt_example_ua" i="<?=$k->id?>"><?=$k->alt_example_ua?></td>
				<td td-click="mural" column="name" i="<?=$k->id?>"><?=$k->name?></td>
				<td td-click="mural" column="name_ua" i="<?=$k->id?>"><?=$k->name_ua?></td>
				<td td-click="mural" column="price" i="<?=$k->id?>" class="td_c1"><?=$k->price?> грн.</td>
				<td class="td_c1">
					<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="mural" i="<?=$k->id?>"></a>
				</td>
				<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>/administrator/mural/?update=<?=$k->id?>"></a></td>
				<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'mural', '<?=$k->name?>')"></a></td>
			</tr>
			<?php $i++; endforeach;?>
			
		</table>
	</div>
	
	<?php endif;?>
	
	
<!--ADD-->	
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form id="add_category" action="/administrator/mural" method="POST" enctype="multipart/form-data">
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						Название текстуры:
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="">
					</td>
					<td>
						Название текстуры<b>(UA)</b>:
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name_ua" value="">
					</td>
				</tr>
				<tr>
					<td>
						Цена(грн):<br>
						<input style="width:100px;" type="text" name="price" value="">
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option value="1" selected>да</option>
							<option value="0">нет</option>
						</select>
						Опубликовать
					</td>
					<td></td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						Текст:<br>
						<textarea name="text" rows="5" style="width:100%;"></textarea>
					</td>
					<td style="padding:5px 5px 5px 0;">
						Текст<b>(UA)</b>:<br>
						<textarea name="text_ua" rows="5" style="width:100%;"></textarea>
					</td>
				</tr>
				
			</table>
		</div>
		<div style="width:35%;float:right;background:#eee;padding:5px;border:1px solid #ccc;border-radius:2px;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td colspan="2"><b>Изображение фрески:</b></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="file" name="mural" value="" onchange="tmp_upload($(this))">
					</td>
				</tr>
				<tr>
					<td>
						alt:
						<br>
						<input type="text" name="alt" value="">
					</td>
					<td>
						alt<b>(UA)</b>:
						<br>
						<input type="text" name="alt_ua" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2"><b>Пример изображение:</b></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="file" name="example" value="" onchange="tmp_upload($(this))">
					</td>
				</tr>
				<tr>
					<td>
						alt для примера:
						<br>
						<input type="text" name="alt_example" value="">
					</td>
					<td>
						alt<b>(ua)</b> для примера:
						<br>
						<input type="text" name="alt_example_ua" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
			</table>
		</div>
		
		<div style="clear:both;height:1px;border-top:1px solid #ccc;"></div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="add" value="">
			<button class="butt_" type="submit">Добавить</button>
		</div>
	</form>

		
	<?php endif;?>
	
	
<!--UPDATE-->	
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form id="add_category" action="/administrator/mural" method="POST" enctype="multipart/form-data">
		
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						Название текстуры:
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="<?=$mural->name?>">
					</td>
					<td>
						Название текстуры<b>(UA)</b>:
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name_ua" value="<?=$mural->name_ua?>">
					</td>
				</tr>
				<tr>
					<td>
						Цена(грн):<br>
						<input style="width:100px;" type="text" name="price" value="<?=$mural->price?>">
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option value="1" <?=$mural->visibility == 1 ? 'selected' : ''?>>да</option>
							<option value="0" <?=$mural->visibility == 0 ? 'selected' : ''?>>нет</option>
						</select>
						Опубликовать
					</td>
					<td></td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						Текст:<br>
						<textarea name="text" rows="5" style="width:100%;"><?=$mural->text?></textarea>
					</td>
					<td style="padding:5px 5px 5px 0;">
						Текст<b>(UA)</b>:<br>
						<textarea name="text_ua" rows="5" style="width:100%;"><?=$mural->text_ua?></textarea>
					</td>
				</tr>
				
			</table>
		</div>
		<div style="width:35%;float:right;background:#eee;padding:5px;border:1px solid #ccc;border-radius:2px;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td colspan="2"><b>Изображение текстуры:</b></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="tmp_box">
							<div style="padding:5px;border:1px solid #eee;display:inline-block;margin:10px 0;">
								<img src="/img/mural/thumb_l_<?=$mural->id?>.jpg" style="width:150px;">
							</div>
						</div>
						<input type="file" name="mural" value="" onchange="tmp_upload($(this))">
					</td>
				</tr>
				<tr>
					<td>
						alt:
						<br>
						<input type="text" name="alt" value="<?=$mural->alt?>">
					</td>
					<td>
						alt<b>(UA)</b>:
						<br>
						<input type="text" name="alt_ua" value="<?=$mural->alt_ua?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2"><b>Пример изображение:</b></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="tmp_box">
							<div style="padding:5px;border:1px solid #eee;display:inline-block;margin:10px 0;">
								<img src="/img/mural/example|<?=$mural->id?>.jpg" style="width:150px;">
							</div>
						</div>
						<input type="file" name="example" value="" onchange="tmp_upload($(this))">
					</td>
				</tr>
				<tr>
					<td>
						alt для примера:
						<br>
						<input type="text" name="alt_example" value="<?=$mural->alt_example?>">
					</td>
					<td>
						alt<b>(ua)</b> для примера:
						<br>
						<input type="text" name="alt_example_ua" value="<?=$mural->alt_example_ua?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
			</table>
		</div>
		
		<div style="clear:both;height:1px;border-top:1px solid #ccc;"></div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="edit" value="">
			<input type="hidden" name="id" value="<?=$mural->id?>">
			<button class="butt_" type="submit">Редактировать</button>
		</div>
	</form>	

		
	<?php endif;?>

</section><!--CENTER-->
