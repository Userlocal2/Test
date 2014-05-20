<section id="content">

<?php //print_r($sel_phot);

//print_r($_SERVER[REDIRECT_QUERY_STRING]);

//print_r($kolll['sel_count']);
/*кол-во записей*/
foreach ($kolll['sel_count'] as $kkk){
//print_r($kkk->kolvo);    
    
    
}
//echo $kkk->kolvo;

//print_r($sel_count);

 ?>
 
<?php require_once '_box_callback.php'; ?>





<?php 


//print_r($_GET);
//if (isset($_GET['nex']))




if (isset($sel_phot['0']))   {


if(isset($_GET['nex'])){
    
$nex = $_GET['nex'];    
    
} else {
    
$nex = 60;    


    
}
/*echo "<br>";
echo "nex";
echo $nex;
echo "<br>";*/

if (isset($_GET['nex_start']))
{

$nex_start = $_GET['nex_start'];

} 
else {
$nex_start = 0;        
}

//echo $nex_start;
/*

echo "<br>";
echo "nex_start";
echo $nex_start;
echo "<br>";

*/


$kol = $kkk->kolvo;

//echo $kol;
if ($nex_start < ($kol/$nex_start))
{
//$nex_start = $nex_start + 60;
$current = $nex_start+$nex/$nex;    
} else {
$nex_start = $nex_start;
}


/*
echo "<br>";
echo $nex_start;
echo "<br>";
*/






if ($nex_start > 0)
{
$back = $nex_start - $nex;
}
else {
$back = 0;
}

/*echo  $kol;
echo $nex_start;*/







/*Подсчет текущей страницы*/




if($_GET['countzap'] == $kol){
//$countzap = 0;

$countzap = $_GET['countzap'];    
    
}

if (!$_GET['countzap']){
$countzap =  count($sel_phot);
}



if ($_GET['countzap'] and $_GET['countzap'] != $kol){
$countzap = count($sel_phot) + $_GET['countzap'];
}

/*
echo "<br>";
echo $countzap;
*/

if ($countzap){

$pag = ceil($countzap/$nex);        
}




/*конец_Подсчета_текущей_страницы*/









/*Подсчет_стартового_числа*/
/*echo $kol;
echo "<br>";
echo $countzap;
echo "<br>";*/
//if ($nex_start+$nex_start < $kol )
if ($countzap < $kol)
 
{    
//echo "mensh"; 
$next_new_st =  $nex_start+$nex;
    
}

else {
//echo "bolsh";    
//$next_new_st =  $nex;

$next_new_st = $nex_start;       
    
}




/*Конец_подсчета_стартового_числа*/







}

/*
echo "<br>";

$caunt = $kol/$nex;
echo "Всего ".$caunt;
echo "<br>";

echo $nex_start;
echo "<br>";
echo $nex;
echo "<br>";

$ii = 0;

$all = $kol - $nex_start;

echo $all;
//$i = 0;
echo "<br>";
$alll = ($kol - $nex_start)/$nex_start;
echo ceil($alll);
echo "<br>";
if ($all > 0)

{
echo "Helll";
$ii + 1;
    
  
}
echo "<br>";

echo $ii;
echo "<br>";*/

/*if ($caunt <= 0){
    
    
}



echo "<br>";
echo round($caunt,0);*/



?>












<?php 







if (isset($sel_phot['0']))   {
    
 
//var_dump($sel_phot); 
//echo count($sel_phot);

 
 
 
 
 
 /*
 
$nex =  $_GET['nex'];   
echo $nex;




$nex_start = $_GET ['nex_start'];
$kol = $kkk->kolvo;
if ($nex_start < ($kol/$nex))
{
$nex_start = $nex_start + $nex;    
$current = $nex_start/$nex;    
} else {
$nex_start = $nex_start;
}
if ($nex_start > 0)
{
$back = $nex_start - $nex;
}
else {
$back = 0;    
}
*/


    ?>



<div class="sort">
<form action="<?php echo base_url();?><?php echo $_SERVER[REDIRECT_QUERY_STRING]; ?>" method="GET">			            
<div style="float:left;">
Items per page:






<select class="graph" onchange="this.form.submit()" name="nex" >



<!--<option value="<?php echo $nex ?>"><?php echo $nex?></option>-->
<option value="60"    <?=($nex == '60') ? 'selected' : '';?>>60</option>
<option value="120" <?=($nex == '120') ? 'selected' : '';?>>120</option>


</select>


  

<input id="sel_hor" type="hidden" value="0" name="nex_start">
                                                           

</div>

			<div style="float:left;margin-left:20px;">
			<!--	<a id="gor" help="1_t" class="gorizont <?=$_SESSION['hor'] == 'h' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('h');$('form').submit()">O</a>
				<a id="ver" help="2_t" class="gorizont <?=$_SESSION['hor'] == 'v' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('v');$('form').submit()">P</a>
				<a id="g_v" help="3_t" class="gorizont <?=$_SESSION['hor'] == '' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('');$('form').submit()">Y</a>-->
				<input id="sel_hor" type="hidden" value="<?=$_SESSION['hor']?>" name="">
			</div>

			<div style="float:right">
			<!--	Order by:
				<select class="graph" onchange="this.form.submit()" name="">
					<option <?=$_SESSION['sort'] == 'popular' ? 'selected':''?> value="popular">popular</option>
					<option <?=$_SESSION['sort'] == 'new' ? 'selected':''?> value="new">new</option>
                    <option <?=$_SESSION['sort'] == 'relevant' ? 'selected':''?> value="relevant">relevant</option>
				</select>
			
            -->
            </div>
		</form>
		<div style="clear:both;"></div>
	</div>




<?php   }

?>








<?php 


if (!isset($sel_phot['0']))   {?>



<!--
<div class="sort">
    
    
<form action="" method="POST">-->			            
<!--
<div style="float:left;">
			
			
                                                                         
</div>-->

		<!--	<div style="float:left;margin-left:20px;">
				<a id="gor" help="1_t" class="gorizont <?=$_SESSION['hor'] == 'h' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('h');$('form').submit()">O</a>
				<a id="ver" help="2_t" class="gorizont <?=$_SESSION['hor'] == 'v' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('v');$('form').submit()">P</a>
				<a id="g_v" help="3_t" class="gorizont <?=$_SESSION['hor'] == '' ? 'active_h' : ''?>" rel="nofollow" onclick="$('#sel_hor').val('');$('form').submit()">Y</a>
				<input id="sel_hor" type="hidden" value="<?=$_SESSION['hor']?>" name="hor">
			</div>-->

	<!--		<div style="float:right">
				Order by:
				<select class="graph" onchange="this.form.submit()" name="sort">
					<option <?=$_SESSION['sort'] == 'popular' ? 'selected':''?> value="popular">popular</option>
					<option <?=$_SESSION['sort'] == 'new' ? 'selected':''?> value="new">new</option>
                    <option <?=$_SESSION['sort'] == 'relevant' ? 'selected':''?> value="relevant">relevant</option>
				</select>
			</div>-->
	<!--	</form>
		<div style="clear:both;"></div>
	</div>-->




<?php   }

?>

<?php 

//print_r($pagin);



 ?>




<?php 
//print_r($_GET);




if (isset($sel_phot['0']))   {?>
    
<div class="pagin">

<?php 


/*Для пагинации*/


if($_GET['countzap'] == $kol){
//$countzap = 0;

$countzap = $_GET['countzap'];    
    
}

if (!$_GET['countzap']){
$countzap =  count($sel_phot);
}



if ($_GET['countzap'] and $_GET['countzap'] != $kol){
$countzap = count($sel_phot) + $_GET['countzap'];
}

/*
echo "<br>";
echo $countzap;
*/

if ($countzap){

$pag = ceil($countzap/$nex);        
}
/*echo "<br>";
echo $pag; 

echo "<br>";*/

/*end_Для пагинации*/
/*
$nex_start = $_GET ['nex_start'];


$kol = $kkk->kolvo;



if ($nex_start < ($kol/60))
{
    
    
$nex_start = $nex_start + 60;    
$current = $nex_start/60;    
    
} else {
$nex_start = $nex_start;
}

if ($nex_start > 0)

{
    
$back = $nex_start - 60;
}

else {
    
$back = 0;    
}
*/


//echo $nex;





?>



 
<a href="<?php echo base_url();?><?php echo $_SERVER[REDIRECT_QUERY_STRING]; ?>?nex=<?php echo $nex; ?>&nex_start=<?php echo $back; ?>">prev</a>    
<a href="<?php echo base_url();?><?php echo $_SERVER[REDIRECT_QUERY_STRING]; ?>?nex=<?php echo $nex; ?>&nex_start=<?php echo $next_new_st ?>&countzap=<?php echo $countzap?>">next</a>


<span>Current: <?php echo $pag; ?></span>                                
       <!-- <a href="<?=$firstPage;?>">1</a>-->
        <!--<input name="page_current" type="text" class="page_current" placeholder="enter page">-->
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        
        <a class="max-page"  href="#"><?php echo ceil($kol/$nex)?></a>                
</div>    
    
    
    
    
<?php     
}?>



<?php 


if (!isset($sel_phot['0'])){ ?>
    
   
    
    
    
    
   <div class="pagin">
       <span>Current: <?=$pagin->page?></span>
        <?php if($prev !== false): ?>
            <a href="<?php echo $prev; ?>">prev</a>
        <?php endif; ?>
        <?php if($next !== false): ?>
            <a href="<?php echo $next; ?>">next</a>
        <?php endif; ?>
        <a href="<?=$firstPage;?>">1</a>
        <!--<input name="page_current" type="text" class="page_current" placeholder="enter page">-->
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        <a class="max-page" max-page="<?=$lastPage['number']?>" href="<?=$lastPage['link'];?>"><?=$lastPage['number']?></a>
	</div>
    
    
    
    
<?php    
}

 ?>





























<?php  

//print_r($sel_phot);

if (isset($sel_phot['0'])){
//echo "Картинки из базы"; 


?>
    


<div id="gallery_box">
		<?php foreach($sel_phot as $value):
        //echo "<pre>";
       // print_r($value);
       // echo "</pre>";
        ?>
		<div class="gallery_item">
			<div class="item_img">
<a class="preview" rel="nofollow" name="<?=$value->prew_url?>" desc="<?=$value->title?>" >
<img class="avatar"  articul="<?=$value->id_img; ?>" alt="<?=$value->title?>" src="<?=$value->url?>" contributor="">
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
//echo "Картинки из bigstock";


?>

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
	
    
  
  
  
<?php   
if (isset($sel_phot['0']))   {?>









<?php  
/*Для пагинации*/




if($_GET['countzap'] == $kol){
//$countzap = 0;

$countzap = $_GET['countzap'];    
    
}

if (!$_GET['countzap']){
$countzap =  count($sel_phot);
}



if ($_GET['countzap'] and $_GET['countzap'] != $kol){
$countzap = count($sel_phot) + $_GET['countzap'];
}

/*echo "<br>";
echo $countzap;
*/

if ($countzap){
$pag =  ceil($countzap/$nex);        
}



/*end_Для пагинации*/
?>


  <div class="pagin">


<a href="<?php echo base_url();?><?php echo $_SERVER[REDIRECT_QUERY_STRING]; ?>?nex=60&nex_start=<?php echo $back; ?>">prev</a>    
<a href="<?php echo base_url();?><?php echo $_SERVER[REDIRECT_QUERY_STRING]; ?>?nex=60&nex_start=<?php echo $next_new_st; ?>&countzap=<?php echo $countzap?>">next</a>
<span>Current: <?php echo $pag; ?></span>                                
       <!-- <a href="<?=$firstPage;?>">1</a>
        <input name="page_current" type="text" class="page_current" placeholder="enter page">-->
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        <a class="max-page"  href="#"><?php echo ceil($kol/$nex)?></a>     
</div>

<?php 
}
?>  
  



<?php 

if (!isset($sel_phot['0']))   {?>  
  




   <div class="pagin">
       <span>Current: <?=$pagin->page?></span>
        <?php if($prev !== false): ?>
            <a href="<?php echo $prev; ?>">prev</a>
        <?php endif; ?>
        <?php if($next !== false): ?>
            <a href="<?php echo $next; ?>">next</a>
        <?php endif; ?>
        <a href="<?=$firstPage;?>">1</a>
        <!--<input name="page_current" type="text" class="page_current" placeholder="enter page">-->
        <img src="/img/i/loading_mini.gif"  class="loading-page">
        <a class="max-page" max-page="<?=$lastPage['number']?>" href="<?=$lastPage['link'];?>"><?=$lastPage['number']?></a>
	</div>
    
      



  
  
<?php 
}

?>  
  
  
  
  
  
  
  
  
  
    
 
    
    
    
    
</section>




<script type="text/javascript">

$(document).ready(function(){	

$('.avatar').imageCrop({ width:240, height: 168 });

});



	$('.preview').Slimbox();
	//при наведении на излбражение (увеличивается)
	_pr.init("preview", 1200);
	_pr.init("prev_", 400);

	//interiorSlimbox();
	$('.preview_interior').interiorSlimbox();



$.fn.Slimbox = function(){
	var allImg = $('.item_img img');
	var next,prev;
	var iM;
	var scrll = $(window).scrollTop();
	var win   = $(window).height();

	var desc = '';
	var box_desc = '';
	var ddd = '';

	this.click(function(){
		boxCenter();
		LOAD($(this));
	});
	var LOAD = function(_this){
		var ddesc = _this.attr('desc')
		desc = _this.attr('desc').split(' ');
		var src = _this.attr('name');
		iM = $('<img>');
		iM.css('opacity', 0);

		iM.one('load', function(){
			scrll = $(window).scrollTop();
			win   = $(window).height();
			var w = this.width+20;
			var h = this.height+25+27+22;
			var t = Math.ceil(h/2);
			var l = Math.ceil(w/2);
			$('#box_center_shd').css({
				width     :w+'px',
				marginLeft:'-'+l+'px',
				top       :(scrll+(win/2-t))+'px',
				left      :'50%'
			});

			var arr = src.split('/');
			var articul = arr[8].replace('thumb_l_', '').replace('.jpg', '');
			var but_l = $('<div>', {id:'but_l'}).click(function(){PREV();});
			var but_r = $('<div>', {id:'but_r'}).click(function(){NEXT();});

			if(desc.length){
				box_desc = '';
				for(var i = 0; i < desc.length; i++){
					if(desc[i].length < 4){ continue;}
					box_desc += '';
				}
				var ddd = $('<div>').addClass('box_desc').html(box_desc);
			}
			
			var activ = $('.add_favorit[i='+articul+']').hasClass('activ')

			var div   = $('<div>',{'class':'item_buttons2'}).html('<div id="_soc" style="position:absolute;bottom:0;left:0;">bb</div><div style="position:absolute;right:0;"><a class="butt_" href="'+lang+'<?php echo base_url()?>/crop-image/title/?idd='+articul+'">'+(window.lang == '/ua' ? 'замовити' : 'Order')+'</a></div>');
			var mail_ = $('<div id="mail_"></div>');
			
			
			var image = $('<div>').css({position:'relative'});
			image.append(this).append(but_l).append(but_r);
			
			
			$('#box_main').html(image);
			$('#box_main').prepend('<div style="font-size: 11px;line-height: 25px;"><span style="color:#aaa;">id:</span> '+articul+'</div>')
			$('#box_main').append(ddd).append(div).append(mail_);
			$('#box_main img').animate({opacity:1},700);
			
			//Соц. сети
			//$('#_soc').append('<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareDescription="'+ddesc+'" data-yashareType="none" data-yashareImage="http://art-oboi.com.ua'+src+'" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,gplus"></div>')
			//var js = $('<script>', {type:'text/javascript', src:'http://yandex.st/share/share.js'})
			//$('.yashare-auto-init').html(js)
			
			getTmpImages(_this);


			//загрузка интерьеров
			/*$.post('/ajax/getInterior',{articul:articul},function(data){
				if(data.length){
					$('#box_center').css('float','right');
					var sh = $('#box_center_shd');

					var box_int = $('<div>',{id:'box_int'});
					box_int.css({visibility:'hidden'});
					var html = '<a class="item_interior" onclick="toogleInterior($(this))" big-interior="'+src+'"><img src="'+src.replace('thumb_l_','thumb_s_')+'"></a>';
					for(var j = 0; j < data.length; j++){
						html += '<a class="item_interior" onclick="toogleInterior($(this))" big-interior="/img/interior/thumb_l_'+data[j].id+'.jpg"><img src="/img/interior/thumb_s_'+data[j].id+'.jpg"></a>';
					}
					box_int.html(html);
					sh.append(box_int);

					var new_w = sh.width()*1 + 120;
					var new_h = box_int.height();
					var height_sh = sh.height();
					var h = height_sh < new_h ? new_h : height_sh;

					var new_ml = sh.css('marginLeft').replace('px', '')*1 - 120 + 'px';

					sh.animate({
						width     :new_w+'px',
						marginLeft:'-'+(new_w/2)+'px',
						top:(scrll+(win/2-t))+'px'
					}, 500, function(){
						box_int.css({visibility:'visible'});
					});
				}
			}, 'json');*/

		});

		iM.attr('src',src);
	}
	//берём 3 рядом стоящие картинки
	var getTmpImages = function(_this){
		next = _this.parents('.gallery_item').next('.gallery_item').find('a.preview');
		prev = _this.parents('.gallery_item').prev('.gallery_item').find('a.preview');

		if(next.length){
			$('<img>').attr('src', next.attr('name'));
			$('#but_r').addClass('br_active');
		}else{
			$('#but_r').removeClass('br_active');
		}
		if(prev.length){
			$('<img>').attr('src', prev.attr('name'));
			$('#but_l').addClass('bl_active');
		}else{
			$('#but_l').removeClass('bl_active');
		}

		return;
	}
	var NEXT = function (){
		if(!next.length){return;}
		$('#box_int').remove();
		LOAD(next);
	}
	var PREV = function(){
		if(!prev.length){return;}
		$('#box_int').remove();
		LOAD(prev);
	}
}





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