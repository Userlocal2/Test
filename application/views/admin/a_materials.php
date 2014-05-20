<section>
	
	
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?> <a title="добавить" class="link_add" href="<?=base_url(); ?>/administrator/materials/?add"></a></h1>
	
	<div id="gallery_box">
		<table id="gb">
			<tr class="gb_f">
				<td class="td_c1" style="width:1%;">№</td>
				<td class="td_c1" >метериал</td>
                <td class="td_c1" style="width:1%;"></td>
				<td class="td_c1" style="width:1%;"></td>
			</tr>
			
			<?php $i=1; foreach($material as $k):?>
			<tr>
				<td class="td_c1"><?=$i?></td>
				<td class="td_c1" >
					<?php echo $k->name; ?>
				</td>
                <td class="td_c1"><a title="редактировать" class="link_edit" href="/administrator/materials/?update=<?=$k->id?>"></a></td>
				<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'material', '<?=$k->name?>')"></a></td>
			</tr>
			<?php $i++; endforeach;?>
		</table>
	</div>
	
	<?php endif;?>
	
	
<!--ADD-->	
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form id="add_category" action="<?=base_url(); ?>/administrator/materials" method="POST" enctype="multipart/form-data">
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название метериала:</b>
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="">
					</td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						<b>Текст:</b>
						<br>
						<textarea name="description" rows="5" style="width:100%;"></textarea>
					</td>
				</tr>
			</table>
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
	<form id="add_category" action="<?=base_url(); ?>/administrator/materials" method="POST" enctype="multipart/form-data">
		<div style="width:63%;float:left;">
			<table width="100%" style="font-size:12px;" cellpadding="5">
				<tr>
					<td>
						<b>Название метериала:</b>
						<br>
						<input style="width:250px;border:1px solid green;" type="text" name="name" value="<?php echo $material->name; ?>">
					</td>
				</tr>
				<tr>
					<td style="padding:5px 5px 5px 0;">
						<b>Текст:</b>
						<br>
						<textarea name="description" rows="5" style="width:100%;"><?php echo $material->description; ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<div style="clear:both;height:1px;border-top:1px solid #ccc;margin:5px 0;"></div>
		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="edit" value="">
			<input type="hidden" name="id" value="<?=$material->id?>">
			<button class="butt_" type="submit">Редактировать</button>
		</div>
	</form>	

		
	<?php endif;?>

</section><!--CENTER-->
