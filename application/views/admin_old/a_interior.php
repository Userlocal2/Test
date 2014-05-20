<section>

<!--ALL-->
	<?php if($act == 'all'):?>
	<h1 class="title"><?=$info?> <a class="link_add" href="<?=base_url(); ?>/administrator/interior/?add" title="добавить"></a></h1>
	
	<div class="nav">
		<form id="form_gallery" action="<?=base_url(); ?>/administrator/interior/" method="GET" enctype="multipart/form-data">
			<b>категория</b>
			<select name="type_interior"  id="typeInterior" onchange="this.form.submit()">
				<option value="0" selected>все</option>
				<?php foreach($type_interior as $k):?>
				<option <?=$res = $k->id == @$_GET['type_interior'] ? 'selected' : ''?> value="<?=$k->id?>"><?=$k->name?></option>
				<?php endforeach;?>
			</select>
			<a class="butt_" style="padding:0 5px;line-height:18px;" id="TypeInterior" onclick="TypeInterior()">+ добавить</a>
		</form>
	</div>
	
	<div class="pagin">
		<?=$pagin?>
	</div>
	
	<div id="gallery_box">
		<table id="gb">
			<tr class="gb_f">
				<td class="td_c1" style="width:1%;">№</td>
				<td class="td_c1" style="width:1%;">интерьер</td>
				<td class="td_c1" style="width:1%;">изображение</td>
				<td class="td_c1" style="width:1%;">категория</td>
				<td style="text-align:center;">alt</td>
				<td style="text-align:center;">текст</td>
				<td class="td_c1" style="width:1%;">visible</td>
				<td class="td_c1" style="width:1%;"></td>
				<td class="td_c1" style="width:1%;"></td>
			</tr>
			
			<?php $i=1; foreach($all_interior as $k):?>
			<tr>
				<td class="td_c1"><?=$i?></td>
				<td style="line-height:0;"
					<a class="preview" name="/img/interior/thumb_l_<?=$k->id?>.jpg">
						<img src="/img/interior/thumb_s_<?=$k->id?>.jpg">
					</a>
				</td>
				<td style="line-height:0;">
					<a class="preview" name="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_l_<?=$k->articul_parent?>.jpg">
						<img src="/img/gallery/<?=$k->id_cat?>/thumbs/thumb_s_<?=$k->articul_parent?>.jpg">
					</a>
				</td>
				<td class="td_c1">
					<?php 
					foreach($type_interior as $j){
						if($k->type == $j->id){ echo $j->name;}
					}
					?>					
				</td>
				<td td-click="interior" column="alt" i="<?=$k->id?>"><?=$k->alt?></td>
				<td td-click="interior" column="text" i="<?=$k->id?>" valign="top"><?=$k->text?></td>
				<td class="td_c1">
					<a class="vis_ <?=$k->visibility == 1 ? ' visible' : ' hidden' ?>" tb="interior" i="<?=$k->id?>"></a>
				</td>
				<td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>/administrator/interior/?update=<?=$k->id?>"></a></td>
				<td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$k->id?>, 'interior', '<?=$k->id?>')"></a></td>
			</tr>
			<?php $i++; endforeach;?>
		</table>
	</div>
	
	<div class="pagin">
		<?=$pagin?>
	</div>
	
	<?php endif;?>

<!--ADD-->
	
	<?php if($act == 'add'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form action="<?=base_url(); ?>/administrator/interior" method="post" enctype="multipart/form-data">
		<div id="gallery_box">
			<table style="width:100%;border-spacing:20px;">
				<tr>
					<td>
						<b style="color:red;">КАТЕГОРИЯ:</b>
						<select name="type_interior" id="typeInterior">
							<option value="0" selected>-</option>
							<?php foreach($type_interior as $k):?>
								<option value="<?=$k->id?>"><?=$k->name?></option>
							<?php endforeach;?>
						</select>
						<a class="butt_" style="padding:0 5px;line-height:18px;" id="TypeInterior" onclick="TypeInterior()">+ добавить</a>
					<td>
					<td></td>
				</tr>
				<tr>
					<td style="width:50%;text-align:center;vertical-align:top;">
						загрузить интерьер:
						<br>
						<input type="file" name="interior" value=""  onchange="tmp_upload($(this))">
					</td>
					<td style="text-align:center;vertical-align:top;">
						артукул изображения к которому определить интерьер:
						<br>
						<input type="text" name="parent" value="" onfocus="setArticul($(this))">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
			</table>
			<table style="width:100%;border-spacing:20px;">
				<tr>
					<td>
						<b>alt</b>
						<br>
						<input type="text" name="alt" value="" style="width:100%;">
					</td>
				</tr>
				<tr>
					<td>
						<b>Текст:</b>
						<br>
						<textarea name="text" style="width:100%;" rows="7"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input type="hidden" value=""  name="add">
						<a class="butt_" onclick="valid_form($(this))">Добавить</a>
					</td>
				</tr>
			</table>
		</div>
	</form>
	<script>
		function setArticul(_this){
			_this.one('blur',function(){
				var a = $.trim(_this.val());
				if(a.length == 0){return;}
				$.post('<?=base_url(); ?>/administrator/interior',{setArticul:a},function(data){
					if(data){
						$('#parent_img').remove();
						var d = $('<div>',{id:'parent_img'}).css('padding','5px');
						d.html('<img src="'+data+'" style="width:150px;">');
						_this.parent().prepend(d);
					}else{
						alert('Такого изображения нет!');
						$('#parent_img').remove();
						_this.val('');
					}
				}, 'html');
			});
			
			document.onkeydown=function(e){
				e=e||window.event;
				if(e.keyCode==13){
					_this.blur();
				}
			}
		}
		
		function valid_form(_this){
			if($('input[type=file]').val() == ''){
				alert('Вы не выбрали интерьера');
				return false;
			}
			if($('select[name=type] option:selected').val() == 0){
				alert('Вы не выбрали категорию интерьера!');
				return false;
			}
			_this.parents('form').submit();
		}
	</script>
	<?php endif;?>
	
	
	
<!--UPDATE-->
	
	<?php if($act == 'update'):?>
	<h1 class="title"><?=$info?></h1>
	
	<form action="<?=base_url(); ?>/administrator/interior" method="post" enctype="multipart/form-data">
		<div id="gallery_box">
			<table style="width:100%;border-spacing:20px;">
				<tr>
					<td>
						<b style="color:red;">КАТЕГОРИЯ:</b>
						<select name="type_interior" id="typeInterior">
							<option value="0">-</option>
							<?php foreach($type_interior as $k):?>
								<option value="<?=$k->id?>" <?=$k->id == $interior->type ? 'selected' :'';?>><?=$k->name?></option>
							<?php endforeach;?>
						</select>
						<a class="butt_" style="padding:0 5px;line-height:18px;" id="TypeInterior" onclick="TypeInterior()">+ добавить</a>
					<td>
					<td></td>
				</tr>
				<tr>
					<td style="width:50%;text-align:center;vertical-align:top;">
						<div class="tmp_box">
							<div style="padding:5px;border:1px solid #eee;display:inline-block;margin:10px 0;">
								<img width="150px" src="<?=base_url(); ?>/img/interior/thumb_l_<?=$interior->id?>.jpg">
							</div>
						</div>
						поменять интерьер:
						<br>
						<input type="file" name="interior" value=""  onchange="tmp_upload($(this))">
					</td>
					<td style="text-align:center;vertical-align:top;">
						<div id="parent_img" style="padding: 5px;">
							<img style="width:150px;" src="<?=base_url(); ?>/img/gallery/<?=$interior->id_cat?>/thumbs/thumb_m_<?=$interior->articul_parent?>.jpg">
						</div>
						артукул изображения к которому определить интерьер:
						<br>
						<input type="text" name="parent" value="<?=$interior->articul_parent?>" onfocus="setArticul($(this))">
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
			</table>
			<table style="width:100%;border-spacing:20px;">
				<tr>
					<td>
						<b>alt</b>
						<br>
						<input type="text" name="alt" value="<?=$interior->alt?>" style="width:100%;">
					</td>
				</tr>
				<tr>
					<td>
						<b>Текст:</b>
						<br>
						<textarea name="text" style="width:100%;" rows="7"><?=$interior->text?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input type="hidden" value="<?=$interior->id?>"  name="edit">
						<input type="hidden" value="<?=$interior->id?>"  name="id">
						<a class="butt_" onclick="valid_form($(this))">Редактировать</a>
					</td>
				</tr>
			</table>
		</div>
	</form>
<script>
function setArticul(_this){
	_this.one('blur',function(){
		var a = $.trim(_this.val());
		if(a.length == 0){return;}
		$.post('<?=base_url(); ?>/administrator/interior',{setArticul:a},function(data){
			if(data){
				$('#parent_img').remove();
				var d = $('<div>',{id:'parent_img'}).css('padding','5px');
				d.html('<img src="'+data+'" style="width:150px;">');
				_this.parent().prepend(d);
			}else{
				alert('Такого изображения нет!');
				$('#parent_img').remove();
				_this.val('');
			}
		}, 'html');
	});
	
	document.onkeydown=function(e){
		e=e||window.event;
		if(e.keyCode==13){
			_this.blur();
		}
	}
}

function valid_form(_this){
	if($('select[name=type] option:selected').val() == 0){
		alert('Вы не выбрали категорию интерьера!');
		return false;
	}
	_this.parents('form').submit();
}
</script>
	<?php endif;?>


<script>
function TypeInterior(){
	if(!$('#_box').length){
		boxCenter();
	}

	$.post('<?=base_url(); ?>/administrator/interior',{typeInterior:'all'}, function(data){
		var a = $('#_box');
		var res = '<div class="title_b">Категории (интерьеров) <a onclick="addTypeInterior(\'add\')" class="l_add"></a></div>'+
				 '<table class="_b">'+
					'<tr class="t1">'+
						'<td class="w">№</td>'+
						'<td style="text-align:center;">название</td>'+
						'<td class="w"></td>'+
					'</tr>';
		
		$.each(data, function(i, val){
			res += '<tr id="tr_'+val.id+'">'+
						'<td class="w">'+(i+1)+'</td>'+
						'<td td-click="type_interior" column="name" i="'+val.id+'">'+val.name+'</td>'+
						'<td><a onclick="delTypeInterior('+val.id+')" class="l_del"><a></td>'+
					'</tr>';
		});
			
			res +='</table>';
		var b = $('<div>').html(res);
		a.html(b);
		
		position(a);
		
		$('td[td-click]').tdClick();
		
	}, 'json');
}
function addTypeInterior(){
	var a = $('#_box');
	var html = '<div class="title_b">Добавить Категорию</div>'+
				 '<table class="_b">'+
					'<tr>'+
						'<td>название<input type="text" id="name" value=""></td>'+
					'</tr>'+
					'<tr>'+
						'<td colspan="2" style="text-align:right;" id="newType"><button class="butt_" style="padding:0 10px;line-height:20px;">добавить</button></td>'+
					'</tr>'+
				'</table>';
	a.html(html);
	
	position(a);
	
	$('#newType').one('click',function(){
		var n    = $.trim($('#name').val());
		var n_ua = $.trim($('#name_ua').val());

		$.post('<?=base_url(); ?>/administrator/interior',{typeInterior:'add',name:n},function(data){
			
			$.post('<?=base_url(); ?>/administrator/interior',{typeInterior:'all'}, function(o){
				var res = '<option selected="" value="0">все</option>';
				$.each(o, function(i, val){
					res += '<option value="'+val.id+'">'+val.name+'</option>';
				});
				$('select[name=type_interior]').html(res);
				TypeInterior();
			}, 'json');
			
		}, 'html');
	});
}
function delTypeInterior(id){
	if(confirm('Удалить категорию?')){
		$.post('<?=base_url(); ?>/administrator/interior',{typeInterior:'del',id:id},function(data){
			$('#tr_'+id).remove();
		});
	}
}
</script>	

</section><!--CENTER-->
