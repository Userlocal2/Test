<section>
<script type="text/javascript">

</script>

	<?php require_once '_box_callback.php'; ?>

	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<a itemprop="url" href="/"><span itemprop="title">Main</span></a>
		/
		<?php foreach($all_category as $k):?>
			<?php if($k->id == $gallery->id_cat):?>
			<a itemprop="url" href="/<?=$k->url?>.html"><span itemprop="title"> <?=$k->name?></span></a>
			<?php $cu = $k->url; endif;?>
		<?php endforeach;?>
		/
		<span itemprop="title"><?=$gallery->articul?></span>
	</div>


<style>



</style>

<h1 class="title">Просмотр в интерьере изображения <?=empty($gallery->title_image) ? $gallery->articul : $gallery->title_image;?></h1>
	<p>Похожие сюжеты:</p>
	<div class="approximate-image">
		<?php foreach($img as $k=>$val):?>

			<a href="/preview-interior?title=<?=$val->articul?>" class="title-img-link"><img title="<?= $val->articul;?>" src="<?=base_url(); ?>/img/gallery/<?= $val->id_cat; ?>/thumbs/thumb_s_<?= $val->articul;?>.jpg"></a>

		<?php endforeach;?>


	</div>

	<p>Если вы хотите просмотреть, как будут выглядеть обои в интерьере, мы предлагаем Вам воспользоваться тестовыми интерьерами.</p>
	<div class="selection">
			<span>Выберите интерьер: </span>
			<select id="interiers">
				<option value="1" id="interior-1">Вариант 1</option>
				<option value="2" id="interior-2">Вариант 2</option>
				<option value="3" id="interior-3">Вариант 3</option>
				<option value="4" id="interior-4">Вариант 4</option>
				<option value="5" id="interior-5">Вариант 5</option>
				<option value="6" id="interior-6">Вариант 6</option>
				<option value="7" id="interior-7">Вариант 7</option>
                    <option value="8" id="interior-8">Вариант 8</option>
				<option value="9" id="interior-9">Вариант 9</option>
				<option value="10" id="interior-10">Вариант 10</option>
				<option value="11" id="interior-11">Вариант 11</option>
				<option value="12" id="interior-12">Вариант 12</option>
				<option value="13" id="interior-13">Вариант 13</option>
               </select>

                  <div class="order_some_img-div">
                     <a id="order_some_img" class="butt_" href="<?=base_url(); ?>/crop-image?title=<?= $gallery->articul;?>" style="width:195px;padding:0;margin:15px 0 0;"> заказать изображение </a>
                  </div>
	</div>
     <div class="view-at-interior" >

		<img src="<?=base_url(); ?>/img/interiors/001.png" id="background-interiors" class="background-interiors" >
          <div id="div-container-img" ><img src="<?=base_url(); ?>/img/gallery/<?= $gallery->id_cat; ?>/thumbs/thumb_l_<?= $_GET['title'];?>.jpg" class="image-under-interiors" title="<?= $_GET['title'];?>"></div>

	</div>



	<script>
		$('#interiers').change(function(){
			var value = $(this).val();
			var textOption = $("option:selected").text();

			switch(value)
			{
					case '1':
						$('.image-under-interiors').css({'height': '337px'} );
						$('#background-interiors').attr("src","/img/interiors/001.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
					case '2':
						$('.image-under-interiors').css({ 'height': '327px'} );
						$('#background-interiors').attr("src","/img/interiors/002.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
					case '3':
						$('.image-under-interiors').css({ 'height': '300px'} );
						$('#background-interiors').attr("src","/img/interiors/003.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
					case '4':
						$('.image-under-interiors').css({ 'height': '292px'} );
						$('#background-interiors').attr("src","/img/interiors/004.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
					case '5':
						$('.image-under-interiors').css({ 'height': '289px'} );
						$('#background-interiors').attr("src","/img/interiors/005.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
					case '6':
						$('.image-under-interiors').css({ 'height': '307px'} );
						$('#background-interiors').attr("src","/img/interiors/006.png");
                              $('#div-container-img').css({'text-align':'right'})
						break;
					case '7':
						$('.image-under-interiors').css({ 'height': '308px'} );
						$('#background-interiors').attr("src","/img/interiors/007.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
                         case '8':
						$('.image-under-interiors').css({ 'height': '298px'} );
						$('#background-interiors').attr("src","/img/interiors/008.png");
                              $('#div-container-img').css({'text-align':'left'})
						break;
                         case '9':
						$('.image-under-interiors').css({ 'height': '284px'} );
						$('#background-interiors').attr("src","/img/interiors/009.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
                         case '10':
						$('.image-under-interiors').css({ 'height': '322px'} );
						$('#background-interiors').attr("src","/img/interiors/010.png");
                              $('#div-container-img').css({'text-align':'left'})
						break;
                         case '11':
						$('.image-under-interiors').css({ 'height': '285px'} );
						$('#background-interiors').attr("src","/img/interiors/011.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
                         case '12':
						$('.image-under-interiors').css({ 'height': '270px'} );
						$('#background-interiors').attr("src","/img/interiors/012.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
                         case '13':
						$('.image-under-interiors').css({ 'height': '303px'} );
						$('#background-interiors').attr("src","/img/interiors/013.png");
                              $('#div-container-img').css({'text-align':'center'})
						break;
			}

		});

	//извлекаем тайтлы с миниатюр и с активного большого изображения в интерьере, для присвоения класса active текущему миниатюрному изображению, который делаем его с полной непрозрачностю
	$(document).ready(function(){
		var title_large = $('.image-under-interiors').attr('title');
		var title_min = $('.title-img-link > img').each(function(){
			$('.title-img-link > img').attr("title");
		});

		//при срабатывании условия задаем класс с свойством overflow 1 для миниатюрных картинок
		$('.title-img-link > img').each(function(i){
			if(title_large == title_min[i]['title'])
			{
				$('.title-img-link > img').eq(i).addClass('active');
			}
		});
	});

	</script>

</section>
