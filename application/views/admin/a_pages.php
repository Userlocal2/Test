<section>

<!--ALL-->
	<?php
//print_r($_REQUEST);

//print_r($page);    
echo $act;    
     if($act == 'all'):?>
	<h1 class="title"><?=$info; ?></h1>
	
	<div class="nav">
		<form id="form_gallery" enctype="multipart/form-data" method="GET" action="<?=base_url(); ?>administrator/pages/">
			<b>тип страниц:</b>
			<select onchange="this.form.submit()" name="getTypePages">
				
				<option value="0" selected>все</option>
				<?php foreach($typePages as $k):
//print_r($typePages);
                
                ?>
				<option value="<?=$k->type?>" <?=$type === $k->type ? ' selected' : '';?>><?=$k->type?></option>
				<?php endforeach;?>
			</select>
			<a title="добавить" class="link_add" href="<?=base_url(); ?>administrator/pages/?add"></a>
		</form>
	</div>
	
	<div id="gallery_box">
			
		<?php 
         
        
        
        if($type):?>
		
			<table id="gb">
				<tr class="gb_f">
					<td class="td_c1" style="width:1%;">№</td>
					<td class="td_c1" style="width:1%;">
						<input id="SORT" tb="pages" type="image" src="<?=base_url(); ?>img/i_admin/filesave.png" value="">
					</td>
					<td style="text-align:center;">название</td>
					<td class="td_c1" style="width:1%;">URL</td>
					<td class="td_c1" style="width:1%;">дом</td>
					<td class="td_c1" style="width:1%;">visible</td>
					<td class="td_c1" style="width:1%;"></td>
					<td class="td_c1" style="width:1%;"></td>
				</tr>
                
                
                
				<?php 
  echo "<pre>";              
//print_r($k);                
echo "<pre>";              


             
                $i=1; foreach($all_pages as $k):?>
				<?php if($type != $k->type){continue;}?>
				<tr>
				
                <!--  buggg -->
                
                
                	<td class="td_c1"><?=$i?></td>
                    
                  
                    
					<td class="td_c1" style="width:1%;line-height:0;">
						<a class="drag" tb="pages" i="<?=$k->id?>"></a>
					</td>
					<td style="white-space:nowrap;"><a href="<?=base_url(); ?>administrator/pages/?update=<?=$k->id?>"><?=$k->name?></a></td>
					<td class="td_c2"><?=$k->url?></td>
					<td class="td_c1">
						<a class="home<?=$k->type == 'home' ? ' activ' : '';?>" i="<?=$k->id?>" title="Сделать главной (двойной клик)"></a>
					</td>
					<td class="td_c1">
						<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="pages" i="<?=$k->id?>"></a>
					</td>
					<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>administrator/pages/?update=<?=$k->id?>"></a></td>
					<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'page', '<?=$k->name?>')"></a></td>
				</tr>
				<?php $i++; endforeach;?>
			</table>
		
		<?php else:?>
			
			<table id="gb">
				<tr class="gb_f">
					<td class="td_c1" style="width:1%;">№</td>
					<td style="text-align:center;">название</td>
					<td class="td_c1" style="width:1%;">URL</td>
					<td class="td_c1" style="width:1%;">дом</td>
					<td class="td_c1" style="width:1%;">visible</td>
					<td class="td_c1" style="width:1%;"></td>
					<td class="td_c1" style="width:1%;"></td>
				</tr>
				<?php $i=1; foreach($all_pages as $k):?>
				<tr>
					<td class="td_c1"><?=$i?></td>
					<td><a href="<?=base_url(); ?>administrator/pages/?update=<?=$k->id?>"><?=$k->name?></a></td>
					<td class="td_c2"><?=$k->url?></td>
					<td class="td_c1">
						<a class="home<?=$k->type == 'home' ? ' activ' : '';?>" i="<?=$k->id?>" title="Сделать главной (двойной клик)"></a>
					</td>
					<td class="td_c1">
						<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="pages" i="<?=$k->id?>"></a>
					</td>
					<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>administrator/pages/?update=<?=$k->id?>"></a></td>
					<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'page', '<?=$k->name?>')"></a></td>
				</tr>
				<?php $i++; endforeach;?>
			</table>
		
		<?php endif;?>
	</div>

	<?php endif;?>
	
<!--ADD-->			
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	<form id="add_category" action="<?=base_url(); ?>administrator/pages" method="POST" enctype="multipart/form-data">
		<div style="width:48%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название страницы:</b>
						<br>
						<input style="width:300px;border:1px solid green;" type="text" name="name" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Использовать название страницы как заголовок статьи:</b>
						<br>
						<input  type="checkbox" name="name_as_h1" >
					</td>
				</tr>
				<tr>
					<td>
						<b>Заголовок (title):</b>
						<br>
						<input style="width:300px;" type="text" name="title" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Описание страницы (MetaDescription):</b>
						<br>
						<input style="width:300px;" type="text" name="metadesc" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ключевые слова (metaKeywords):</b>
						<br>
						<input style="width:300px;" type="text" name="metakey" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ссылка на страницу (URL)</b>
						<br>
						<input style="width:300px;" id="add_url" type="text" name="url" value="">
					</td>
				</tr>
				<tr>
					<td>
						<select name="type">
							<option value="0">--</option>
							<?php foreach($typePages as $k):?>
							<?php if($k->id == 1){ continue;}?>
							<option  value="<?=$k->type?>"><?=$k->type?></option>
							<?php endforeach;?>
						</select>
						укажите <b style="color:red;">Тип</b> страницы
					</td>
				</tr>
				<tr>
					<td>
						<select name="id_parent">
							<option value="0">--</option>
							<?php foreach($all_pages as $k):?>
							<option  value="<?=$k->id?>"><?=$k->name?></option>
							<?php endforeach;?>
						</select>
						прикрепить к странице
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
			</table>
		</div>
		
		<div style="width:48%;float:right;background:#eee;border-radius:5px;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td style="text-align:center;">
						<fieldset>
							<legend>
							<b>Изображения для превью страницы:</b>
							</legend>
							<div style="padding:5px;text-align:center;">
								<input type="file" name="image" value="" onchange="tmp_upload($(this))">
							</div>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="clear"></div>
		
		<div style="margin:20px 0;">
			<b>Текст:</b>
			<br>
			<textarea class="tiny" rows="20" style="width:100%;" name="text"></textarea>
		</div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="add" value="">
			<button class="butt_" type="submit">Добавить</button>
		</div>
	</form>
	
	
	<?php endif;?>
	
	
<!--UPDATE-->
	<?php if($act == 'update'):?>
	
	<h1 class="title"><?=$info?></h1>
	<form id="add_category" action="<?=base_url(); ?>administrator/pages" method="POST" enctype="multipart/form-data">
		<div style="width:48%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название страницы:</b>
						<br>
						<input style="width:300px;border:1px solid green;" type="text" name="name" value="<?=$page->name?>">
					</td>
				</tr>
				
				<tr>
					<td>
						<b>Использовать название страницы как заголовок статьи:</b>
						<br>
						<?php if($page->name_as_h1==1):?>
							<input  type="checkbox" name="name_as_h1" checked>
                                                <?php else: ?>
                                                        <input  type="checkbox" name="name_as_h1" >
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Заголовок (title):</b>
						<br>
						<input style="width:300px;" type="text" name="title" value="<?=$page->title?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Описание страницы (MetaDescription):</b>
						<br>
						<input style="width:300px;" type="text" name="metadesc" value="<?=$page->metadesc?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ключевые слова (metaKeywords):</b>
						<br>
						<input style="width:300px;" type="text" name="metakey" value="<?=$page->metakey?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ссылка на страницу (URL)</b>
						<br>
						<input style="width:300px;" id="add_url" type="text" name="url" value="<?=$page->url?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php if($page->type == 'home'):?>
						<b>ТИП - Главная</b>
						<input type="hidden" name="type" value="home">
						<?php else:?>
						<select name="type">
							<option value="0">--</option>
							<?php foreach($typePages as $k):?>
							<option <?=$k->type == $page->type ? 'selected' : ''?>  value="<?=$k->type?>"><?=$k->type?></option>
							<?php endforeach;?>
						</select>
						укажите <b style="color:red;">Тип</b> страницы
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<td>
						<select name="id_parent">
							<option value="0">--</option>
							<?php foreach($all_pages as $k):?>
							<?php if($k->id == $page->id){continue;}?>
							<option  value="<?=$k->id?>" <?=$page->id_parent == $k->id ? 'selected' : '';?>><?=$k->name?></option>
							<?php endforeach;?>
						</select>
						прикрепить к странице
					</td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option <?=$page->visibility == 1 ? 'selected' : ''?> value="1" selected>да</option>
							<option <?=$page->visibility == 0 ? 'selected' : ''?>  value="0">нет</option>
						</select>
						Опубликовать
					</td>
				</tr>
			</table>
		</div>
		
		<div style="width:48%;float:right;background:#eee;border-radius:5px;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td style="text-align:center;">
						<fieldset>
							<legend>
								<b>Изображения для превью страницы:</b>
							</legend>
							<div style="padding:5px;text-align:center;">
								<div class="tmp_box">
									<div>
										<img style="width:150px;" src="<?=base_url(); ?>img/preview_pages/<?=$page->id?>.jpg">
									</div>
								</div>
								<input type="file" name="image" value="" onchange="tmp_upload($(this))">
							</div>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="clear"></div>
		
		<div style="margin:20px 0;">
			<b>Текст:</b>
			<br>
			<textarea class="tiny" rows="20" style="width:100%;" name="text"><?=$page->text?></textarea>
		</div>
		
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="id" value="<?=$page->id?>">
			<input type="hidden" name="edit" value="">
			<button class="butt_" type="submit">Редактировать</button>
		</div>
	</form>
	<?php endif;?>

</section><!--CENTER-->
