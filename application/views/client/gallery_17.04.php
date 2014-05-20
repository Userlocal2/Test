<section id="content">

<?php //print_r($sel_phot);

//print_r($gallery);



 ?>
 
	<?php require_once '_box_callback.php'; ?>
	<div class="sort">
		<form action="" method="post">
			<div style="float:left;">
				Items per page:
				<select class="graph" onchange="this.form.submit()" name="view_count">
				<?php foreach($view_count as $value=>$v):?>
					<?php if($_SESSION['view_count'] == $v):?>
					<option value="<?=$v?>" selected><?=$v?></option>
					<?php else:?>
					<option value="<?=$v?>"><?=$v?></option>
					<?php endif;?>
				<?php endforeach;?>
				</select>
			</div>

			<div style="float:left;margin-left:20px;">
				<a id="gor" help="1_t" class="gorizont <?=$_SESSION['hor'] == 'h' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('h');$('form').submit()">O</a>
				<a id="ver" help="2_t" class="gorizont <?=$_SESSION['hor'] == 'v' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('v');$('form').submit()">P</a>
				<a id="g_v" help="3_t" class="gorizont <?=$_SESSION['hor'] == '' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('');$('form').submit()">Y</a>
				<input id="sel_hor" type="hidden" value="<?=$_SESSION['hor']?>" name="hor">
			</div>

			<div style="float:right">
				Order by:
				<select class="graph" onchange="this.form.submit()" name="sort">
					<option <?=$_SESSION['sort'] == 'popular' ? 'selected':''?> value="popular">popular</option>
					<option <?=$_SESSION['sort'] == 'new' ? 'selected':''?> value="new">new</option>
                    <option <?=$_SESSION['sort'] == 'relevant' ? 'selected':''?> value="relevant">relevant</option>
				</select>
			</div>
		</form>
		<div style="clear:both;"></div>
	</div>




<?php 

//print_r($pagin);



 ?>
<div class="pagin">

<span>Current: <?=$pagin->page?></span>
        <?php if($prev !== false): ?>
<a href="<?php echo $prev; ?>">prev</a>
        <?php endif; ?>
        <?php if($next !== false): ?>
            <a href="<?php base_url(); echo $next; ?>">next</a>
        <?php endif; ?>
        <a href="<?=$firstPage;?>">1</a>
        <input name="page_current" type="text" class="page_current" placeholder="enter page">
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        
        <a class="max-page"  href="#"></a>                
</div>






<?php  

//print_r($sel_phot);

if (isset($sel_phot['0'])){
echo "Картинки из базы"; ?>
    


<div id="gallery_box">
		<?php foreach($sel_phot as $value):
        //echo "<pre>";
       // print_r($value);
       // echo "</pre>";
        ?>
		<div class="gallery_item">
			<div class="item_img">
<a class="preview" rel="nofollow" name="<?=$value->prew_url?>" desc="<?=$value->title?>" >
<img class="avatar"  articul="<?=$value->id_img; ?>" alt="" src="<?=$value->url?>" contributor="">
</a>
			</div>
			<div>
				<div class="item_articul"><?=$value->title?></div>
				<div class="item_buttons">
<a class="butt_ ord" href="<?=base_url();?>crop-image/title/?idd=<?=$value->id_img ?>" rel="nofollow">Order</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<div class="clear"></div>
	</div>





<?php }else { 
echo "Картинки из bigstock";?>

<div id="gallery_box">
		<?php foreach($gallery as $value):?>
		<div class="gallery_item">
			<div class="item_img">
                <a class="preview" rel="nofollow" name="<?=$value->preview->url?>" desc="<?=$value->title;?>" >
<img class="avatar"  articul="<?=$value->id ?>" alt="<?=$value->title ?>" src="<?=$value->small_thumb->url?>" contributor="<?=$value->contributor;?>">
				</a>
			</div>
			<div>
				<div class="item_articul"><?=$value->title?></div>
				<div class="item_buttons">
					<a class="butt_ ord" href="<?=base_url();?>crop-image/title/?idd=<?=$value->id?>" rel="nofollow">Order</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
        
        
		<div class="clear"></div>
        
        
</div>





<?php            
}



?>



















	<!--<div id="gallery_box">
		<?php foreach($gallery as $value):?>
		<div class="gallery_item">
			<div class="item_img">
                <a class="preview" rel="nofollow" name="<?=$value->preview->url?>" desc="<?=$value->title;?>" >
<img class="avatar"  articul="<?=$value->id ?>" alt="<?=$value->title ?>" src="<?=$value->small_thumb->url?>" contributor="<?=$value->contributor;?>">
				</a>
			</div>
			<div>
				<div class="item_articul"><?=$value->title?></div>
				<div class="item_buttons">
					<a class="butt_ ord" href="<?=base_url();?>crop-image/title/<?=$value->id?>" rel="nofollow">Order</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<div class="clear"></div>
	</div>-->
    
    
    
    
    
    
    <style>
        .page_current {
            height: 30px;
            width: 71px;
            border: 1px solid #E4E4CD;
            border-radius: 3px;
            background: linear-gradient(to bottom, #E3E3C4 0%, #F1F1D7 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
            color: #888888;
        }
    </style>
	<div class="pagin">
       <span>Current: <?=$pagin->page?></span>
        <?php if($prev !== false): ?>
            <a href="<?php echo $prev; ?>">prev</a>
        <?php endif; ?>
        <?php if($next !== false): ?>
            <a href="<?php echo $next; ?>">next</a>
        <?php endif; ?>
        <a href="<?=$firstPage;?>">1</a>
        <input name="page_current" type="text" class="page_current" placeholder="enter page">
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        <a class="max-page" max-page="<?=$lastPage['number']?>" href="<?=$lastPage['link'];?>"><?=$lastPage['number']?></a>
	</div>
</section>




<script type="text/javascript">

$(document).ready(function(){	

$('.avatar').imageCrop({ width:240, height: 168 });

});








/*
$('.item_img img').load(function(){
    //alert ("Hello");   
	var MAX_WIDTH = 220;
	var MAX_HEIGHT = 180;
	var img_width = $(this).width();
	var img_height = $(this).height();
	var ratio;
	if(img_width<=MAX_WIDTH && img_height<=MAX_HEIGHT){
		ratio=1;
	}
	else if(img_width>img_height){
		ratio=MAX_WIDTH/img_width;
	}
	else {
		ratio=MAX_HEIGHT/img_height;
	}

	$(this).css("width", img_width*ratio); // Set new width
	$(this).css("height", img_height*ratio);  // Scale height based on
});*/



</script>