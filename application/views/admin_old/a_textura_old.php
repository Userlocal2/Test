<section>
	
	
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?> <a title="добавить" class="link_add" href="<?=base_url(); ?>/administrator/textura/?add"></a></h1>
	
	<div id="gallery_box">
		<table id="gb">
			<tr class="gb_f">
				<td class="td_c1" style="width:1%;">№</td>
				<td class="td_c1" style="width:1%;">текстура</td>
				<td style="text-align:center;">альт.</td>
				<td class="td_c1" style="width:1%;">пример</td>
				<td style="text-align:center;">альт-пример</td>
				<td style="text-align:center;">название</td>
                                <td class="td_c1" style="width:1%;">сортировка</td>
				<td class="td_c1" style="width:1%;">лак</td>
				<td class="td_c1" style="width:1%;">клей</td>
				<td class="td_c1" style="width:1%;">Экосольвент</td>
				<td class="td_c1" style="width:1%;">Латекс</td>
				<td class="td_c1" style="width:1%;">Уф</td>
				<td class="td_c1" style="width:1%;">visible</td>
				<td class="td_c1" style="width:1%;"></td>
				<td class="td_c1" style="width:1%;"></td>
			</tr>
			
			<?php $i=1; foreach($textura as $k):?>
			<tr>
				<td class="td_c1"><?=$i?></td>
				<td class="td_c1" style="line-height:0;">
					<a class="preview" name="<?=base_url(); ?>/img/textura/thumb_l_<?=$k->id?>.jpg">
						<img src="<?=base_url(); ?>/img/textura/thumb_s_<?=$k->id?>.jpg">
					</a>
				</td>
				<td td-click="textura" column="alt" i="<?=$k->id?>"><?=$k->alt?></td>
				<td class="td_c1" style="line-height:0;">
					<a class="preview" name="<?=base_url(); ?>/img/textura/example_<?=$k->id?>.jpg">
						<img src="<?=base_url(); ?>/img/textura/example_s_<?=$k->id?>.jpg">
					</a>
				</td>
				<td td-click="textura" column="alt_example" i="<?=$k->id?>"><?=$k->alt_example?></td>
				<td td-click="textura" column="name" i="<?=$k->id?>"><?=$k->name?></td>
                                <td td-click="textura" column="ordering" i="<?=$k->id?>" class="td_c1"><?php echo $k->ordering; ?></td>
				
				<td td-click="textura" column="lak" i="<?=$k->id?>" class="td_c1"><?=$k->lak?> грн.</td>
				<td td-click="textura" column="kley" i="<?=$k->id?>" class="td_c1"><?=$k->kley?> грн.</td>
				
				<td td-click="textura" column="eco" i="<?=$k->id?>" class="td_c1"><?=$k->eco?> грн.</td>
				<td td-click="textura" column="latex" i="<?=$k->id?>" class="td_c1" class="td_c1"><?=$k->latex?> грн.</td>
				<td td-click="textura" column="uf" i="<?=$k->id?>" class="td_c1" class="td_c1"><?=$k->uf?> грн.</td>
				<td class="td_c1">
					<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="textura" i="<?=$k->id?>"></a>
				</td>
				<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>/administrator/textura/?update=<?=$k->id?>"></a></td>
				<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'textura', '<?=$k->name?>')"></a></td>
			</tr>
			<?php $i++; endforeach;?>
			
		</table>
	</div>
	
	<?php endif;?>
	
	
<!--ADD-->	
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form id="add_category" action="<?=base_url(); ?>/administrator/textura" method="POST" enctype="multipart/form-data">
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название текстуры:</b>
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="">
					</td>
				</tr>
                <tr>
                    <td>
                        <b>Тип материала:</b>
                        <br>
                        <select name="id_material">
                            <option value="0">-</option>
                            <?php foreach ($material as $value):?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
				<tr>
					<td>
						<b>Цена(грн.) Экосольвент:</b>
						<br>
						<input style="width:100px;" type="text" name="eco" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Цена(грн.) Латекс:</b>
						<br>
						<input style="width:100px;" type="text" name="latex" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Цена(грн.) Уф:</b>
						<br>
						<input style="width:100px;" type="text" name="uf" value="">
					</td>
				</tr>
                                <tr>
					<td>
						<b>Ширина полосы:</b>
						<br>
						<input style="width:100px;" type="text" name="tile_size" value="">
					</td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option value="1" selected>да</option>
							<option value="0">нет</option>
						</select>
						Опубликовать
					</td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						<b>Текст:</b>
						<br>
						<textarea name="text" rows="5" style="width:100%;"></textarea>
					</td>
				</tr>
			</table>
		</div>
		
		<div style="width:35%;float:right;background:#eee;padding:5px;border:1px solid #ccc;border-radius:2px;">
		
			<fieldset>
				<legend>
				<b>Изображение текстуры:</b>
				</legend>
				<div style="padding:5px;text-align:center;">
					<input type="file" name="textura" value="" onchange="tmp_upload($(this))">
				</div>
				<div style="padding:10px 0;">
					<input type="text" name="alt" value=""> <b> - alt</b>
				</div>
			</fieldset>
			
			<fieldset>
				<legend>
				<b>Пример изображение:</b>
				</legend>
				<div style="padding:5px;text-align:center;">
					<input type="file" name="example" value="" onchange="tmp_upload($(this))">
				</div>
				<div style="padding:10px 0;">
					<input type="text" name="alt_example" value=""> <b> - alt для примера</b>
				</div>
			</fieldset>
			
		</div>
		
		<div style="clear:both;height:1px;border-top:1px solid #ccc;margin:5px 0;"></div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="add" value="">
			<button class="butt_" type="submit">Добавить</button>
		</div>
	</form>

		
	<?php endif;?>
	
	
	
<!--UPDATE-->	
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form id="add_category" action="<?=base_url(); ?>/administrator/textura" method="POST" enctype="multipart/form-data">
		
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						Название текстуры:</b>
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="<?=$textura->name?>">
					</td>
				</tr>
                <tr>
                    <td>
                        <b>Тип материала:</b>
                        <br>
                        <select name="id_material">
                            <option value="0">-</option>
                            <?php foreach ($material as $value):?>
                                <?php if ($value->id == $textura->id_material):?>
                                    <option selected="" value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
				<tr>
					<td>
						<b>Цена(грн.) Экосольвент:</b>
						<br>
						<input style="width:100px;" type="text" name="eco" value="<?=$textura->eco?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Цена(грн.) Латекс:</b>
						<br>
						<input style="width:100px;" type="text" name="latex" value="<?=$textura->latex?>">
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<b>Цена(грн.) Уф:</b>
						<br>
						<input style="width:100px;" type="text" name="uf" value="<?=$textura->uf?>">
					</td>
					<td></td>
				</tr>
                                 <tr>
					<td>
						<b>Ширина полосы:</b>
						<br>
						<input style="width:100px;" type="text" name="tile_size" value="<?=$textura->tile_size;?>">
					</td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option value="1" <?=$textura->visibility == 1 ? 'selected' : ''?>>да</option>
							<option value="0" <?=$textura->visibility == 0 ? 'selected' : ''?>>нет</option>
						</select>
						Опубликовать
					</td>
					<td></td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						<b>Текст:</b>
						<br>
						<textarea name="text" rows="5" style="width:100%;"><?=$textura->text?></textarea>
					</td>
				</tr>	
			</table>
			
			<div style="background:#eee;border:1px solid #ccc;padding:10px;">
				<fieldset>
					<legend>
						<b>Галерея примеров текстуры:</b>
					</legend>
					<table>
						<tr>
							<td style="vertical-align:top;">
								<!--<input type="file" name="gallery_textura" value="" onchange="tmp_upload($(this))">-->
								
								<div id="fileQueue"></div>
		
								<div id="button_uploady" style="display:block;">
									<input id="file_upload" name="file_upload" type="file" multiple="true">
								</div>
							</td>
							<td style="text-align:center;padding:0 10px;vertical-align:top;">
								<?php foreach($textura->example as $k=>$v):?>
								<div id="gal_<?=$v?>" style="display:inline-block;position:relative;vertical-align:top;">
									<img src="<?=base_url(); ?>/img/textura/<?=$textura->id?>/<?=$v?>.jpg" width="150px">
									<a onclick="delTexturaGallery(<?=$textura->id?>,<?=$v?>)" title="Удалить" class="link_del" style="position:absolute;top:0;right:0;background-color:#fff;"></a>
								</div>
								<?php endforeach;?>
								<script>
									function delTexturaGallery(textura, img){
										if(!confirm("Удалить изображение?"))return
										$.post('<?=base_url(); ?>/ajax/del_textura_gallery',{textura:textura, img:img},function(data){
											if(data == 1){
												$('#gal_'+img).remove()
											}else{
												alert('Ошибка!');
											}
										})
									}
									
									//мульти-загрузка примеров текстур
									$(document).ready(function(){
										(function(){
											var c = '';
											var cookies = document.cookie.split('; ');
											for(var i = 0; i < cookies.length; i++){
												var cookie = cookies[i].split('=');
												if(cookie[0] == 'PHPSESSID'){
													c = decodeURIComponent(cookie[1]);
												}
											}

											$('#file_upload').uploadify({
												'formData'     : {
													'uploadify'      : ' ',
													'textura_gallery':<?=$textura->id?>,
													'session'        : c
												},
												'cancelImg'  : '<?=base_url(); ?>/uploadify/uploadify-cancel.png',
												'queueID'    : 'fileQueue'
											});
										})()
									});
								</script>
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
			
		</div>
		
		<div style="width:35%;float:right;background:#eee;padding:5px;border:1px solid #ccc;border-radius:2px;">
		
			<fieldset>
				<legend>
				<b>Изображение текстуры:</b>
				</legend>
				<div style="padding:5px;text-align:center;">
					<div class="tmp_box">
						<div style="padding:5px;border:1px solid #eee;display:inline-block;margin:10px 0;">
							<img src="<?=base_url(); ?>/img/textura/thumb_l_<?=$textura->id?>.jpg" style="width:150px;">
						</div>
					</div>
					<input type="file" name="textura" value="" onchange="tmp_upload($(this))">
				</div>
				<div style="padding:10px 0;">
					<input type="text" name="alt" value="<?=$textura->alt?>"> <b> - alt</b>
				</div>
			</fieldset>
			
			<fieldset>
				<legend>
				<b>Пример изображение:</b>
				</legend>
				<div style="padding:5px;text-align:center;">
					<div class="tmp_box">
						<div style="padding:5px;border:1px solid #eee;display:inline-block;margin:10px 0;">
							<img src="<?=base_url(); ?>/img/textura/example|<?=$textura->id?>.jpg" style="width:150px;">
						</div>
					</div>
					<input type="file" name="example" value="" onchange="tmp_upload($(this))">
				</div>
				<div style="padding:10px 0;">
					<input type="text" name="alt_example" value="<?=$textura->alt_example?>"> <b> - alt для примера</b>
				</div>
			</fieldset>
	
		</div>
		
		<div style="clear:both;height:1px;border-top:1px solid #ccc;margin:5px 0;"></div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="edit" value="">
			<input type="hidden" name="id" value="<?=$textura->id?>">
			<button class="butt_" type="submit">Редактировать</button>
		</div>
	</form>	

		
	<?php endif;?>

</section><!--CENTER-->
