<section>

<!--ALL-->
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?> <a title="добавить" class="link_add" href="<?=base_url(); ?>administrator/category/?add"></a></h1>
	
	<div id="gallery_box">

           <table id="gb">
			<tr class="gb_f">
				<td class="td_c1" style="width:1%;">№</td>
				<td class="td_c1" style="width:1%;">
					<input id="SORT" type="image" tb="category" src="<?=base_url(); ?>img/i_admin/filesave.png" value="">
				</td>
				<td style="text-align:center;">название</td>
				<td class="td_c1" style="width:1%;">URL</td>
				<td class="td_c1" style="width:1%;">visible</td>
				<td class="td_c1" style="width:1%;"></td>
				<td class="td_c1" style="width:1%;"></td>
			</tr>
			<?php $i=1; foreach($all_category as $k):?>
			<tr>
				<td class="td_c1"><?=$i?></td>
				<td class="td_c1" style="width:1%;line-height:0;"><a class="drag" i="<?=$k->id?>"></a></td>
				<td style="white-space:nowrap;">
					<a href="<?=base_url();?>administrator/gallery/?id_cat=<?=$k->id?>"><?=$k->crumb?></a>
				</td>
				<td style="white-space:nowrap;"><?=$k->url?></td>
				<td class="td_c1" style="line-height:0;">
					<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="category" i="<?=$k->id?>"></a>
				</td>
				<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>administrator/category/?update=<?=$k->id?>"></a></td>
				<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'cat', '<?=$k->crumb?>')"></a></td>
			</tr>
			<?php $i++; endforeach;?>
		</table> 
		
	</div>
	<?php endif;?>
	
<!--ADD-->			
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	<form id="add_category" action="<?=base_url(); ?>administrator/category" method="POST">
		<div style="width:48%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название категории:</b>
						<br>
						<input style="width:300px;border:1px solid green;" type="text" name="name" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Хлебные крошки:</b>
						<br>
						<input style="width:300px;" type="text" name="crumb" value="">
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
						<b>Описание категории</b> (metaDescription):
						<br>
						<input style="width:300px;" type="text" name="metadesc" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ключевые слова</b> (metaKeywords):
						<br>
						<input style="width:300px;" type="text" name="metakey" value="">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ссылка на категорию (URL)</b>
						<br>
						<input style="width:300px;" id="add_url" type="text" name="url" value="">
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
		
		<div class="clear"></div>
		
		<div style="margin:20px 0;">
			<b>Текст:</b>
			<br>
			<textarea class="tiny" rows="20" style="width:100%;" name="text"></textarea>
		</div>
		
		<div style="margin:10px 0;text-align:right;">
			<button class="butt_" type="submit" name="add">Добавить</button>
		</div>
	</form>
	
	
	<?php endif;?>
	
	
<!--UPDATE-->
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?> "<span style="color:red;"><?=$cat->name?></span>"</h1>
	<form action="<?=base_url(); ?>administrator/category" method="POST">
		<div style="width:48%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название категории:</b>
						<br>
						<input style="width:300px;border:1px solid green;" type="text" name="name" value="<?=$cat->name?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Хлебные крошки:</b>
						<br>
						<input style="width:300px;" type="text" name="crumb" value="<?=$cat->crumb?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Заголовок</b> (title):
						<br>
						<input style="width:300px;" type="text" name="title" value="<?=$cat->title?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Описание категории</b> (metaDescription):
						<br>
						<input style="width:300px;" type="text" name="metadesc" value="<?=$cat->metadesc?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ключевые слова</b> (metaKeywords):
						<br>
						<input style="width:300px;" type="text" name="metakey" value="<?=$cat->metakey?>">
					</td>
				</tr>
				<tr>
					<td>
						<b>Ссылка на категорию (URL)</b>
						<br>
						<input style="width:300px;" id="add_url" type="text" name="url" value="<?=$cat->url?>">
					</td>
				</tr>
				<tr>
					<td>
						<select name="visibility">
							<option value="1" <?=$res = $cat->visibility == 1 ? 'selected' : ''?>>да</option>
							<option value="0" <?=$res = $cat->visibility == 0 ? 'selected' : ''?>>нет</option>
						</select>
						Опубликовать
					</td>
				</tr>
			</table>
		</div>
		
		<div class="clear"></div>

		<div style="margin:20px 0;">
			<b>Текст:</b>
			<br>
			<textarea class="tiny" rows="20" style="width:100%;" name="text"><?=$cat->text?></textarea>
		</div>

		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="id" value="<?=$cat->id?>">
			<button class="butt_" name="edit" type="submit">Редактировать</button>
		</div>
	</form>
	<?php endif;?>

</section><!--CENTER-->
