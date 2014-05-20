<section>

<!--ALL-->
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?></h1>
	
	<div id="gallery_box">

           <table id="gb">
                <tr class="gb_f">
                        <td class="td_c1" style="width:1%;">№</td>
                        <td style="text-align:center;">название</td>
                        <td class="td_c1">описание</td>
                        <td class="td_c1" style="width:1%;"></td>
                        <td class="td_c1" style="width:1%;"></td>
                </tr>
                <?php $i=1; foreach($listSubCat as $k):?>
                <tr>
                        <td class="td_c1"><?=$i?></td>
                        <td class="td_c1" style="text-align: left"><?=$k->name;?></td>
                        <td class="td_c1"><?= !empty($k->text) ? 'есть описание' : '';?></td>
                        <td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>/administrator/subcategorymanager/?update=<?=$k->id?>"></a></td>
                        <td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'subcategory', '<?=$k->name?>')"></a></td>
                </tr>
                <?php $i++; endforeach;?>
            </table> 
		
	</div>
	<?php endif;?>
	
<!--UPDATE-->
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?> "<span style="color:red;"><?=$subcat->name?></span>"</h1>
	<form action="<?=base_url(); ?>/administrator/subcategoryManager" method="POST">
            <div style="margin:20px 0;">
                <b style="width: 92px; display: inline-block">Тайтл:</b>
                <input type="text" name="meta_title" value="<?=$subcat->meta_title;?>">
            </div>
            <div style="margin:20px 0;">
                <b style="width: 92px;  display: inline-block">Мета описание:</b>
                <input type="text" name="metadesc" value="<?=$subcat->metadesc;?>">
            </div>
		<div style="margin:20px 0;">
			<b>Текст:</b>
			<br>
			<textarea class="tiny" rows="20" style="width:100%;" name="text"><?=$subcat->text?></textarea>
		</div>

		<div style="margin:10px 0;text-align:right;">
			<input type="hidden" name="id" value="<?=$subcat->id?>">
			<button class="butt_" name="edit" type="submit">Редактировать</button>
		</div>
	</form>
	<?php endif;?>

</section><!--CENTER-->
