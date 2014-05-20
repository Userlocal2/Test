<section>

<!--ALL-->

            



<?php  
//print_r($data);
//print_r($bd_sel_cat);

/*foreach ($bd_sel_catt as $key => $value):           
foreach ($value as $kk):
*/
//print_r($bd_sel_catt);


?>












    <?php 
  
    if ($bd_sel_catt):
    
    /*if($act == 'all'):*/
    
    
    ?>
    
    
    
    
	<h1 class="title"><?=$info?></h1>
	

	<div class="nav">
		<form id="form_gallery" action="<?=base_url();?>administrator/sel_photo" method="GET" enctype="multipart/form-data">
			<b>категория</b>
			<!--<select name="id_cat" id="sel_cat" onchange="$('#hid').remove();this.form.submit()">-->
           
           	
          
 
          
            
            <select name="id_cat" id="sel_cat" onchange="">
            
           
				<option value="0">-</option>
                
 	<?php 
     
     //print_r($bd_sel_catt);
foreach($bd_sel_catt as $value):
foreach ($value as $kk):     
     ?>
                
<option <?=$kk;?> value="<?=$kk;?>"><?=$kk;?> </option>                        
                
                
				<?php endforeach;?>             
            	<?php endforeach;?>           
                
			</select>
            
            
            
            
			
			<span>&nbsp;</span>
			
			<?php if(!isset($_GET['hidden'])):?>
				
				<?php if(count($gallery )):?>

				<a class="butt_" onclick="SubCategory()" style="margin:0 0 0 20px;padding:0 5px;line-height:18px;">+ добавить подкатегорию</a>
				
				<?php endif;?>
				<span>&nbsp;</span>
				<span>&nbsp;</span>
				
				<b>выводить по:</b>
				<select name="view_gallery" id="sel_view" onchange="this.form.submit()">
					<option <?=$view_gallery == 0 ? 'selected' : ''?> value="0">100</option>
					<option <?=$view_gallery == 1 ? 'selected' : ''?> value="1">все</option>
				</select>
				
				<span>&nbsp;</span>
				<span>&nbsp;</span>
				
				<b>состояние:</b>
				<select name="hid" id="hid" onchange="this.form.submit()">
					<option <?=$hid == 0 ? '' : 'selected'?> value="0">все</option>
					<option <?=$hid == 1 ? 'selected' : ''?> value="1">скрытые</option>
				</select>
				 <?php if(count($gallery )):?>
                                <a class="butt_" onclick="downloadAlt(<?= $cat_id;?>)" style="margin:0 0 0 20px;padding:0 5px;line-height:18px;">выгрузить alt</a>
				<?php endif;?>
			<?php endif;?>
			
			<a id="del_ALL" class="link_del_all" onclick="del(0, 'arr_img', '')" title="удалить"></a>
			<a class="link_add" href="<?=base_url(); ?>/administrator/gallery/?add&id_cat=<?=$cat_id?>" title="добавить"></a>


<input type="submit" value="Выбор фотографий"/>
			
		</form>
	</div>	
    
    
    
    
	
	<div class="pagin">
		<?=$pagin?>
	</div>
	
	<div id="gallery_box">
		<?php if(count($gallery)):?>
		<?php
        
        echo "<pre>";
        //var_dump($gallery);
        echo "</pre>";
        
        
        ?>	
		<script>var ID_GALLERY = <?=$gallery[0]->id_cat?>;</script>
		
			<table id="gb">
				<tr class="gb_f">
					<td class="td_c1" style="width:1%;">№</td>
					<td class="td_c1" style="width:1%;">
						<input type="checkbox" onclick="allSelect(this)" value="" name="">
					</td>
					<td class="td_c1" style="width:1%;"></td>
					<td class="td_c1" style="width:1%;">Артикул</td>
					<td class="td_c1" style="width:1%;">подкатегория</td>
					<td style="text-align:center;">title</td>
					<td style="text-align:center;">alt</td>
					<td class="td_c1" style="width:1%;">ширина<br>см.</td>
					<td class="td_c1" style="width:1%;">высота<br>см.</td>
					<td class="td_c1" style="width:1%;">hits</td>
					<td class="td_c1" style="width:1%;">page<br>hits</td>
					<td class="td_c1" style="width:1%;">
                                            <a onclick="all_images_invisible_or_visible(<?= $gallery[0]->id_cat; ?>, 0)" title="Скрыть все"><img width="15" src="/img/i_admin/do_invisible_img.png"></a>
						<br>
						visible
						<br>
						<a onclick="all_images_invisible_or_visible(<?= $gallery[0]->id_cat; ?>, 1)" title="Показать все"><img width="15" src="/img/i_admin/do_visible_img.png"></a>
					</td>
					<td class="td_c1" style="width:1%;"></td>
					<td class="td_c1" style="width:1%;"></td>
				</tr>
				
			<?php $i=1; foreach($gallery as $k):?>
				<tr>
					<td class="td_c1"><?=$i?></td>
					<td class="td_c1"><input class="ch_imgs" type="checkbox" value="<?=$k->id?>" name="g_img[]" onclick="selCountChechBox()"></td>
					<td class="td_c1" style="line-height:0;">
						<a class="preview" name="<?=base_url();?>img/gallery/<?=$k->id_cat?>/thumbs/thumb_l_<?=$k->articul?>.jpg">
							<img src="<?=base_url();?>img/gallery/<?=$k->id_cat?>/thumbs/thumb_sb_<?=$k->articul?>.jpg">
						</a>
					</td>
					<td class="td_c1"><?=$k->articul?></td>
					<td class="td_c1">
						<select name="subcategory" onchange="selSubcategory($(this),<?=$k->id?>)">
							<option value="0">-</option>
							<?php foreach($subcategory as $jj):?>
								<option value="<?=$jj->id?>" <?=$k->id_subcat == $jj->id ? 'selected' : '';?>><?=$jj->name?></option>
							<?php endforeach;?>
						</select>
					</td>
					<td td-click="gallery" column="title_image" i="<?=$k->id?>" title="изменить - двойной клик"><?=$k->title_image?></td>
					<td td-click="gallery" column="alt" i="<?=$k->id?>" title="изменить - двойной клик"><?=$k->alt?></td>
					<td class="td_c1"><?=$k->width_cm?></td>
					<td class="td_c1"><?=$k->height_cm?></td>
					<td class="td_c1" td-click="gallery" column="hits" i="<?=$k->id?>" title="изменить - двойной клик"><?=$k->hits?></td>
					<td class="td_c1" td-click="gallery" column="hits2" i="<?=$k->id?>" title="изменить - двойной клик"><?=$k->hits2?></td>
					<td class="td_c1">
						<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden'?>" tb="gallery" i="<?=$k->id?>" title="изменить - один клик"></a>
					</td>
					<td class="td_c1"><a class="link_edit" href="<?=base_url();?>administrator/gallery/?update=<?=$k->id?>" title="редактировать"></a></td>
					<td class="td_c1"><a class="link_del" onclick="del(<?=$k->id?>, 'gallery_img', '<?=$k->articul?>')" title="удалить"></a></td>
				</tr>
			<?php $i++; endforeach;?>
			</table>
		<?php endif;?>
	</div>
	
	<div class="pagin">
		<?=$pagin?>
	</div>

<script>
function SubCategory(){
	
	if(!$('#_box').length){
		boxCenter();
	}

	$.post('<?=base_url();?>administrator/subcategory',{subCategory:'all', id_gallery:ID_GALLERY}, function(data){
		var a = $('#_box');
		var res = '<div class="title_b">Подкатегории галереи <a onclick="addSubCategory(\'add\')" class="l_add"></a></div>'+
				 '<table class="_b">'+
					'<tr class="t1">'+
						'<td class="w">№</td>'+
						'<td style="text-align:center;">название</td>'+
						'<td class="w"></td>'+
					'</tr>';
		
		$.each(data, function(i, val){
			res += '<tr id="tr_'+val.id+'">'+
						'<td class="w">'+(i+1)+'</td>'+
						'<td td-click="subcategory" column="name" i="'+val.id+'">'+val.name+'</td>'+
						'<td><a onclick="del('+val.id+', \'subcategory\',\''+val.name+'\')" class="l_del"><a></td>' +
					'</tr>';
		});
			
			res +='</table>';
		var b = $('<div>').html(res);
		a.html(b);
		position(a);
		
		$('td[td-click]').tdClick();
	}, 'json');
}
function addSubCategory(){

	var a = $('#_box');
	var html = '<div class="title_b">Добавить подкатегорию</div>'+
				 '<table class="_b">'+
					'<tr>'+
						'<td>название<input type="text" id="name" value=""></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan="2" style="text-align:right;"><button id="newSC" class="butt_" style="padding:0 10px;line-height:20px;">добавить</button></td>'+
					'</tr>'+
				'</table>';
	a.html(html);
	
	position(a);
	
	$('#newSC').one('click', function(){
		var n = $.trim($('#name').val());
		
		$.post('/administrator/subcategory',{subCategory:'add', name:n, id_gallery:ID_GALLERY},function(data){
			
			$.post('/administrator/subcategory',{subCategory:'all', id_gallery:ID_GALLERY}, function(o){
				var res = '<option selected="" value="0">-</option>';
				$.each(o, function(i, val){
					res += '<option value="'+val.id+'">'+val.name+'</option>';
				});
				$('select[name=subcategory]').html(res);
				SubCategory();
			}, 'json');
			
		}, 'html');
	});
}
function selSubcategory(_this, id){
	var text = _this.find('option:selected').val();
	var div = $('<div>').css({position:'fixed',zIndex:10000,top:0,bottom:0,left:0,right:0,background:'#fff',opacity:0.3});
	$('body').append(div);
	$.post('/ajax/td_click',{table:'gallery', column:'id_subcat', id:id, text:text},function(){
		div.remove();
	});
}

function downloadAlt(id_cat)
{
    $.post('/administrator/c_downloadAlt', {id_cat : id_cat}, function(){
       window.location.href = '<?=base_url(); ?>/files/savefile.php';
    });
}
</script>	

	<?php endif;?>
	
	
<!--ADD-->			
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	
	<div style="border:1px solid #ccc;background:#eee;padding:10px;border-radius:2px;">
		<div style="border:1px solid #ddd;padding:5px;border-radius:2px;display:inline-block;">
			<h2 style="margin:0 0 3px 0;text-align:center;border-bottom:1px solid #ddd;padding:0 0 2px 0;">Куда загружать</h2>
			<table>
				<tr>
					<td style="width:1px;">
						<b>категория</b>
					</td>
					<td>
					
                    
                    
                    
                    	<select name="id_cat" id="sel_cat" onchange="GoUpload();">
							<option value="0">-</option>
						swdedrfdefde
                        
                        
                        
                        	<?php 
                            
                            echo "tutttt";
                            foreach($bd_sel_catt as $k):
                            print_r($k);
                            ?>
							<option <?=$res = $k->id == $cat_id ? 'selected' : ''?> value="<?=$k->id?>"><?=$k->crumb?></option>
							<?php endforeach;?>
                            </select>
                        
                        
                        
                        
                        
                        
                        
					</td>
				</tr>
			</table>
		</div>
		<div style="border:1px solid #ddd;padding:5px;border-radius:2px;display:inline-block;">
			<h2 style="margin:0 0 3px 0;text-align:center;border-bottom:1px solid #ddd;padding:0 0 2px 0;">Настройки</h2>
			<table>
				<tr>
					<td style="width:1px;">
						<input id="wm" type="checkbox" value="1" onchange="GoUpload()">
					</td>
					<td>
					</td>
				</tr>
			</table>
		</div>		
		<div id="fileQueue"></div>		
		<div id="button_uploady">
			<form>
				<input id="file_upload" name="file_upload" type="file" multiple="true">
			</form>
		</div>
	</div>
	
	<script>
	$(document).ready(function(){
		GoUpload()
	})
	function GoUpload(){
		var cat = $('#sel_cat option:selected').val() * 1
		var wm  = $('#wm:checked').length
		
		if(cat != 0){
			$('#button_uploady').css({display:'block'})
		}else{
			$('#button_uploady').css({display:'none'})
			return
		}
		
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
				'uploadify': ' ',
				'gallery'  : ' ',
				'cat'      : cat,
				'wm'       : wm,
				'session'  : c
			},
			'cancelImg'  : '/uploadify/uploadify-cancel.png',
			'queueID'    : 'fileQueue'
		});
	}
	</script>
	
	<?php endif;?>

	
<!--UPDATE-->
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?></h1>
	<div style="text-align:center;padding:30px;">
		<img style="border:2px solid #ccc;" src="/img/gallery/<?=$image->id_cat?>/thumbs/thumb_m_<?=$image->articul?>.jpg">
		<br>
		<b><?=$image->articul?></b>
		<br>
		<br>
	</div>
	<form enctype="multipart/form-data" method="POST" action="/administrator/gallery">
		<div style="width:48%;float:left;">
			<table cellpadding="5" width="100%" style="font-size:12px;">
				<tr>
					<td>
						alt:
						<br>
						<input type="text" value="<?=$image->alt?>" name="alt" style="width:300px;">
					</td>
				</tr>
				<tr>
					<td>
						title:
						<br>
						<input type="text" value="<?=$image->title_image?>" name="title_image" style="width:300px;">
					</td>
				</tr>
			</table>
		</div>
		<div class="clear"></div>
		
		<table>
			<?php if($image->wm == 0):?>
			<tr>
				<td>
					влдяной знак:
				</td>
				<td>
					<input type="checkbox" name="wm" value="1">
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td>
					<input type="text" value="<?=$image->width_cm?>" name="width_cm" style="width:70px;">
					
				</td>
				<td>
					ширина (см)
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" value="<?=$image->height_cm?>" name="height_cm" style="width:70px;">
					
				</td>
				<td>
					высота (см)
				</td>
			</tr>
			<tr>
				<td>
					опубликовать:
				</td>
				<td>
					<select name="visibility">
						<option <?=$image->visibility == 1 ? 'selected' : ''?> value="1">да</option>
						<option <?=$image->visibility == 0 ? 'selected' : ''?> value="0">нет</option>
					</select>
				</td>
			</tr>
		</table>
		
		<hr>
		<div style="padding:20px;text-align:center;">
			<input type="hidden" value="<?=$image->id_cat?>" name="id_cat">
			<input type="hidden" value="<?=$image->id?>" name="id">
			<input type="hidden" value="" name="edit">
			<button class="butt_" type="submit">редактировать</button> 
		</div>
		
	</form>

	<?php endif;?>

</section><!--CENTER-->