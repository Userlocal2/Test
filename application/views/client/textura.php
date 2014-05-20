<section>
<script type="text/javascript">

</script>
<?php 
/*echo "<pre>";
print_r($material);
echo "</pre>";
*/
?>            
            
<?php  
/*echo "<pre>";
print_r($textures);
echo "</pre>";
*/




foreach ($textures as $req)

{
    /*
    echo "<pre>";
//    print_r($req->name_mater);
    
    echo "</pre>";
    */
}

?>


	
	<?php require_once '_box_callback.php'; ?>
	
	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<!--<a itemprop="url" href="/"><span itemprop="title">Main</span></a>
				/-->
				
<a itemprop="url" href="<?php echo base_url() ?>">
<!--<span itemprop="title">Main</span>-->

</a>				
		<!--<span itemprop="title">текстуры и цены</span>-->
	</div>
      
	<!--<h1 class="title">Текстуры и цены на фотообои</h1>-->
    <div class="type-materials">
    
    <div class="name-material"><a id="smartstick" href="#smart">Adhesive Murals</a></div>
        <div class="name-material"><a id="flizelin" href="#fliz">Fleece Murals</a></div>
       
       
        <div class="name-material"><a href="#vinil">Vinyl Murals</a></div>
        <div class="name-material"><a href="#glyanec">Paper Murals</a></div>
      
       
       
        
    </div>
	
	<div class="all-textures">
		<?php
        
        //print_r($material);
         foreach($material as $values):?>
            <?php if($values->id == 1):?>
            
            <div class="section-vinil">
                <h2><a name="vinil"><?php echo $values->name; ?></a></h2>
                
                <div class="description-material">
                    <?php echo $values->description; ?>
                </div>
                
                
                
                
                <?php
        //print_r($textures);
                 foreach($textures as $value):?>
                <?php if($value->id_material == $values->id):?>
                
                
                <div class="some-texture">
                    <h3><?=$value->name?></h3>
                    <div class="img-textures">
                        <a class="prev_textura" rel="nofollow" name="<?=base_url();?>/img/textura/thumb_l_<?=$value->id?>.jpg">
                            <img src="<?=base_url();?>/img/textura/thumb_l_<?= $value->id; ?>.jpg" class="clear-texture" alt="<?=$value->alt;?>">
                            <span></span>
                        </a>
                        <a class="gallery_textura" rel="nofollow" i="<?=$value->id?>" style="float:right;"  name="<?=base_url();?>/img/textura/example_<?=$value->id?>.jpg">
                            <img src="<?=base_url();?>/img/textura/example_<?= $value->id; ?>.jpg" class="example-texture" alt="<?=$value->alt_example;?>">
                            <span></span>
                        </a>
                    </div>
                    <div class="price-textures">



                        <?php
                        
                   //     print_r($value);
                        
                         if($value->eco):?>
                        <p ><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_eco ?></a> : € <?=$value->eco?> sq. m. </p>
                        <?php endif;?>

                        <?php if($value->latex):?>
                        <p><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_latex ?></a> : € <?=$value->latex?> sq. m. </p>
                        <?php endif;?>

                        <?php if($value->uf):?>
                        
                        <!--<p><a  href="<?=base_url(); ?>uv_printing.html"><?php echo $value->name_mater_uf ?></a> : $ <?=$value->uf?> sq. m. </p>-->
                        <p><a  href="<?=base_url(); ?>brighter-colours-with-UV-Printing.html"><?php echo $value->name_mater_uf ?></a> : € <?=$value->uf?> sq. m. </p>
                        
                        <?php endif;?>

                    </div>
                    <div class="description-texture">
                        <p><?=$value->text?></p>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
            
          <div class="hor-line"></div>      
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
           
            <?php elseif($values->id == 2):?>
            <div class="section-flizelin">
                
                
                <h2><a name="fliz"><?php echo $values->name; ?></a></h2>
                
                
                <div class="description-material">
                    <?php echo $values->description; ?>
                </div>
                <?php foreach($textures as $value):?>
                <?php if($value->id_material == $values->id):?>
                <div class="some-texture">
                    <h3><?=$value->name?></h3>
                    <div class="img-textures">
                        <a class="prev_textura" rel="nofollow" name="<?=base_url(); ?>/img/textura/thumb_l_<?=$value->id?>.jpg">
                            <img src="<?=base_url(); ?>/img/textura/thumb_l_<?= $value->id; ?>.jpg" class="clear-texture" alt="<?=$value->alt;?>">
                            <span></span>
                        </a>
                        <a class="gallery_textura" rel="nofollow" i="<?=$value->id?>" style="float:right;"  name="<?=base_url();?>/img/textura/example_<?=$value->id?>.jpg">
                            <img src="<?=base_url(); ?>/img/textura/example_<?= $value->id; ?>.jpg" class="example-texture" alt="<?=$value->alt_example;?>">
                            <span></span>
                        </a>
                    </div>
                    <div class="price-textures">

                        <?php 
                       /* echo "<pre>";
                        print_r($value);
                        echo "</pre>";
                        */
                        if($value->eco):?>
                        <p ><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_eco ?></a> : € <?=$value->eco?>  sq. m.</p>
                        <?php endif;?>

                        <?php if($value->latex):?>
                        <p><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_latex ?></a> : € <?=$value->latex?>  sq. m.</p>
                        <?php endif;?>

                        <?php if($value->uf):?>
                        <!--<p><a  href="<?=base_url(); ?>/fotooboi-uv-pechat.html"><?php echo $value->name_mater_uf ?></a> : $ <?=$value->uf?> sq. m.</p>-->
                        <p><a  href="<?=base_url(); ?>brighter-colours-with-UV-Printing.html"><?php echo $value->name_mater_uf ?></a> : € <?=$value->uf?> sq. m.</p>
                        <?php endif;?>

                    </div>
                    <div class="description-texture">
                        <p><?=$value->text?></p>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
            
            
            
            
            
                <div class="hor-line"></div>
            <!--  Новая_вставка -->

<div class="hor-line"></div>

   <?php elseif($values->id == 8):?>
          
          
          
            <div class="section-glyanec">
                
                
                <h2><a name="glyanec">
           
                
                <?php echo $values->name; ?></a></h2>
                
                
                <div class="description-material">
                    <?php echo $values->description; ?>
                </div>
                <?php foreach($textures as $value):?>
                <?php if($value->id_material == $values->id):?>
                <div class="some-texture">
                    <h3><?=$value->name?></h3>
                    <div class="img-textures">
                        <a class="prev_textura" rel="nofollow" name="<?=base_url(); ?>/img/textura/thumb_l_<?=$value->id?>.jpg">
                            <img src="<?=base_url(); ?>/img/textura/thumb_l_<?= $value->id; ?>.jpg" class="clear-texture" alt="<?=$value->alt;?>">
                            <span></span>
                        </a>
                        <a class="gallery_textura" rel="nofollow" i="<?=$value->id?>" style="float:right;"   name="<?=base_url();?>/img/textura/example_<?=$value->id?>.jpg">
                            <img src="<?=base_url(); ?>/img/textura/example_<?= $value->id; ?>.jpg" class="example-texture" alt="<?=$value->alt_example;?>">
                            <span></span>
                        </a>
                    </div>
                    <div class="price-textures">

                        <?php 
                    
                        if($value->eco):?>                                                
                        
                        <p ><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_eco ?></a> : € <?=$value->eco?> sq. m. </p>
                        <?php endif;?>

                        <?php if($value->latex):?>
                        
                        
                        <p><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_latex ?></a> : € <?=$value->latex?> sq. m. </p>
                        <?php endif;?>

                        <?php if($value->uf):?>
                        <p><a  href="<?=base_url(); ?>brighter-colours-with-UV-Printing.html"><?php echo $value->name_mater_uf ?></a> : € <?=$value->uf?>  sq. m. </p>
                        <?php endif;?>

                    </div>
                    <div class="description-texture">
                        <p><?=$value->text?></p>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach; ?>
            </div>


            
            
            <!-- end_новая_вставка-->
            
            
            
            

            
            

            <div class="hor-line"></div>
            <?php elseif($values->id == 3):?>
            
            
            
            <div class="section-smart">
                <h2><a name="smart"><?php echo $values->name; ?></a></h2>
                <div class="description-material">
                    <?php echo $values->description; ?>
                </div>
                <?php foreach($textures as $value):?>
                <?php if($value->id_material == $values->id):?>
                
                
                
                <div class="some-texture">
                    <h3><?=$value->name?></h3>
                    
                    <div class="img-textures">
                    
                    
                        <a class="prev_textura" rel="nofollow" name="<?=base_url();?>/img/textura/thumb_l_<?=$value->id?>.jpg">
                            <img src="<?=base_url();?>/img/textura/thumb_l_<?= $value->id; ?>.jpg" class="clear-texture" alt="<?=$value->alt;?>">
                            <span></span>
                        </a>
                        <a class="gallery_textura" rel="nofollow" i="<?=$value->id?>" style="float:right;"   name="<?=base_url();?>/img/textura/example_<?=$value->id?>.jpg">
                            <img src="<?=base_url();?>/img/textura/example_<?= $value->id; ?>.jpg" class="example-texture" alt="<?=$value->alt_example;?>">
                            <span></span>
                        </a>
                    </div>
                    
                    
                    
                    <div class="price-textures">

                        <?php if($value->eco):?>
                        
                        <!--<p ><a href="<?=base_url(); ?>/eco-wallpaper.html">Экосольвентная печать</a> : <?=$value->eco?> $</p>-->
                        
                   
                   
                        <p ><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_eco ?></a> : € <?=$value->eco?> sq. m.</p>
                        
                        
                        
                        <?php endif;?>

                        <?php if($value->latex):?>
                        <p><a href="<?=base_url(); ?>latex-printing-ecology-friendly.html"><?php echo $value->name_mater_latex ?></a> : € <?=$value->latex?> sq. m.</p>
                        <?php endif;?>

                        <?php if($value->uf):?>
                        <p><a  href="<?=base_url(); ?>brighter-colours-with-UV-Printing.html"><?php echo $value->name_mater_uf ?></a> : € <?=$value->uf?> sq. m.</p>
                        <?php endif;?>

                    </div>
                    
                    
                    
                    
        
                  
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="description-texture">
                        <p><?=$value->text?></p>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
            
            
            
            
            
            <div class="hor-line"></div>
            
            
            
            
            
            <?php endif; ?>
			
		<?php endforeach;?>
	</div>

<script>


/*$(document).ready(function(){
	_2pr.init('gallery_textura');
})
var _2pr = {
	select:false,
	id:0,
	galerry:[],
	it:0,
	
	show:function(_this){
	 
		if($('#_bx').length){_2pr.insert(_this);return}
		
		var body   = $(document.body)
		var box    = $('<div>',{id:'_bx'}).css({opacity:0})
		var shadow = $('<div>',{id:'shadow'}).click(function(){_2pr.hide()})
		var exit   = $('<a>',{id:'_exit'}).click(function(){_2pr.hide()})
		var prev   = $('<a>',{id:'_prev'}).html('<span></span>').click(function(){_2pr.prev()})
		var next   = $('<a>',{id:'_next'}).html('<span></span>').click(function(){_2pr.next()})





		
		box.append(exit)
		box.append('<table id="_bx_tb"><tr><td rowspan="2" style="width:65%;text-align:center;vertical-align:middle;"><div id="b_image" style="position:relative;"><div id="_image"></div></div></td><td style="width:35%;border-left:2px solid #222;padding:40px 50px 0 20px;"><div id="_title" style="font-size:26px;"></div><p id="_text"></p><div  id="_print"style="padding:10px;background:#000;border-radius:3px;font-size:13px;"></div><div id="_textura" style="padding:20px 0 0 0;"><span style="color:#999;">Выбрать другую текстуру : </span></div><div id="_gallery" style="padding:20px 0 0;margin:20px 0 0 0;text-align:left;border-top:2px solid #222;"></div></td></tr><tr><td style="border-left:2px solid #222;vertical-align:bottom;text-align:right;" id="_soc"></td></tr></table>')
		body.append(shadow,box)
        
		$('#b_image').append(next,prev)
		
		var sel = _2pr.select.clone(true)
	
    
    
    	sel.find('option[value='+_this.data('info').id+']').attr('selected','selected')
        
        
        
		$('#_textura').append(sel)
		
		_2pr.position()
		
		_2pr.insert(_this)
	},
	
	insert:function(_this){
		var id = _this.data('info').id
		var gal = _this.data('info').gallery
		_2pr.gallery = gal
		_2pr.id = id
		_2pr.it = 0
		
		$('#_title').html(_this.data('info').name)
		$('#_text').html(_this.data('info').text)
		
		var img = $('<img>').css({opacity:0})
		img.load(function(){
			$('#_image').html($(this))
			$(this).animate({opacity:1}, 200)
			_2pr.resize()
			_2pr.position()
			$('#_bx').animate({opacity:1},300)
		})
		if(gal[0] == undefined){$('#_image').html(''); _2pr.position()}
		img.attr('src', '/img/textura/'+id+'/'+gal[0]+'.jpg')
		
		var print = $('#_print')
		print.html('')
		print.append(_this.data('info').eco == 0 ? '' : '<div style="white-space:nowrap;"><?php echo $value->name_mater_eco ?> : <span style="color:#eaeb72">'+_this.data('info').eco+' $ <sup><small>2</small></sup></span></div>')
		print.append(_this.data('info').lat == 0 ? '' : '<div style="white-space:nowrap;"><?php echo $value->name_mater_latex ?> : <span style="color:#eaeb72">'+_this.data('info').lat+' $ <sup><small>2</small></sup></span></div>')
		print.append(_this.data('info').uf  == 0 ? '' : '<div style="white-space:nowrap;"><?php echo $value->name_mater_uf ?> : <span style="color:#eaeb72">'+_this.data('info').uf+' $ <sup><small>2</small></sup></span></div>')
		
		var gallery = $('#_gallery')
		gallery.html('')
		for(var i = 0; i < gal.length; i++){
			$('<img>').attr('src','<?=base_url();?>/img/textura/'+id+'/'+gal[i]+'.jpg')
			var img = $('<img>')
			img.data('set', i)
			.css({width:'100px',height:'100px'})
			.addClass('im '+(i==0?' activ':''))
			.attr('src','<?=base_url();?>/img/textura/'+id+'/mini/'+gal[i]+'.jpg')
			.click(function(){
				$('.im').removeClass('activ')
				$(this).addClass('activ')
				_2pr.it = $(this).data('set')
				
				var newImage = $('<img>')
				newImage.load(function(){
					$('#_image').html($(this))
					_2pr.resize()
				})
				newImage.attr('src','<?=base_url();?>/img/textura/'+id+'/'+gal[_2pr.it]+'.jpg')
				
			})
			gallery.append(img)	
		}
		//Соц. сети
		$('#_soc').append('<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareDescription="'+_this.data('info').text+'" data-yashareType="none" data-yashareImage="http://klv-oboi.ru/img/textura/'+id+'/'+gal[0]+'.jpg" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,gplus"></div>')
		var js = $('<script>', {type:'text/javascript', src:'http://yandex.st/share/share.js'})
		$('.yashare-auto-init').html(js)
		
	},
	
	next:function(){
		var it = _2pr.it
		if(it+1 > _2pr.gallery.length-1){
			_2pr.it = 0
		}else{
			_2pr.it++
		}
		_2pr.replaceImg()
	},
	
	prev:function(){
		var it = _2pr.it
		if(it-1 < 0){
			_2pr.it = _2pr.gallery.length-1
		}else{
			_2pr.it--
		}
		_2pr.replaceImg()
	},
	
	replaceImg:function(){
		var newImage = $('<img>')
		newImage.load(function(){
			$('#_image').html($(this))
			var im = $('.im').removeClass('activ')
			im.eq(_2pr.it).addClass('activ')
			_2pr.resize()
		})
		newImage.attr('src','<?=base_url();?>/img/textura/'+_2pr.id+'/'+_2pr.gallery[_2pr.it]+'.jpg')
	},
	
	resize:function(){
		var boxImage = $('#_image')
		var image = boxImage.find('img')
		
		var ww = $(window).width()
		var iw = image.width()
		var ih = image.height()
		
		var r = ww-(ww/2)
		if(r < iw){
			image.css({width:r+'px', height:r*ih/iw+'px'})
		}
	},
	
	position:function(){
		var ws = $(window).scrollTop()
		var wh = $(window).height()
		var bh = $('#_bx').height() 
		var top = ws+((wh-bh)/2)+'px'
		$('#_bx').css({top:top})
	},
	
	hide:function(){
		$('#shadow, #_bx').remove()
	},
	
	init:function(items){
		if(!$('.'+items).length){return}
		
		$.post('<?=base_url();?>/ajax/get_textura',{},function(data){
		
			_2pr.select = $('<select>')
			$.each(data, function(i, val){
				var name = val.name 
				var text = val.text
				var opt = $('<option>').val(val.id).html(name)
				opt.data('info',{id:val.id, name:name, gallery:val.gallery, text:text, uf:val.uf, eco:val.eco, lat:val.latex})
				
				$('.'+items).each(function(i){
					if($(this).attr('i') == val.id){
						$(this).data('info', {id:val.id, name:name, gallery:val.gallery, text:text, uf:val.uf, eco:val.eco, lat:val.latex})
					}
				})
				
				_2pr.select.append(opt)
			})
			
			_2pr.select.change(function(){
				_2pr.show($(this).find('option:selected'))
			})
			
			$('.'+items).click(function(){
				_2pr.show($(this))
			})
			
			$(document).keydown(function(event){
				if (event.keyCode == 27) _2pr.hide() 
			})
			$(window).resize(function(){
				_2pr.resize()
			})
			
			
		}, 'json')
	}//end INIT
}*/










</script>










	<article>
		<?=
        
 
        
        $text?>
	</article>
	
</section>
