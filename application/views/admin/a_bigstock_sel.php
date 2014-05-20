
<form action="get_bigstock/<?=$idcat?>" method="POST">
<div style=" margin: 0 auto;">
<style>
#main{
    
/*position: absolute;*/    
    
}
</style>
<?php

/**
 * @author admin
 * @copyright 2014
 */

//var_dump($bd_sel_cat);


//print_r($_GET);


//print_r($tot_pages);/*Всего страниц*/
//echo $page;/*текущая страница*/

echo "<br>";
echo "<strong>Выберите фото для Добавления&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>";
echo "<strong style='color:red; font-size: 19px;'>Перед выбором фото необхимо обязательно сделать перевод&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>";  
/*echo "<strong>Категория: &nbsp;&nbsp; </strong>"."<b style='font-size:17px; color:red;'>".$categ."</b>";*/
echo "<br>";

echo "<br>";
echo "<br>";
foreach ($bd_sel_cat as $value){

   
//var_dump($value->description);
//
//print_r($next_key->id);
//print_r($next_key->id.'&nbsp;'.$next_key->small_thumb->url);  

//var_dump ($value);
//int_r($value);

echo "<div class='bl' style='width:250px;  float:left;margin:10px 6px 6px 6px'>";


echo "<br>";
echo "<a href='#' class='heading'>Перевод</a>

<div class='contentt'>";
echo "<br>";
echo "<div class='wrap'><b>Перевести</b>";
echo "<br>";
echo "<br>";

echo form_input('data['.$value->id.'][desc_de]',$value->description,'class="de"');
echo form_input('data['.$value->id.'][desc_en]',$value->description,'class="b"');
echo form_input('data['.$value->id.'][desc_fr]',$value->description,'class="fr"');
echo form_input('data['.$value->id.'][desc_it]',$value->description,'class="it"');
echo form_input('data['.$value->id.'][desc_es]',$value->description,'class="es"');
echo form_input('data['.$value->id.'][desc_pl]',$value->description,'class="pl"');
echo "<br>";
//echo form_button('name','перевести','class="btn"');

 echo "</div>"; 








echo "
</div>";

/*
echo "<div class='wrap'><b>Перевод</b>";
echo "<br>";
echo "<br>";
echo form_input('data['.$value->id.'][id]',$value->id);
echo form_input('data['.$value->id.'][desc_de]',$value->description,'class="de"');
echo form_input('data['.$value->id.'][desc_en]',$value->description,'class="b"');
echo form_input('data['.$value->id.'][desc_fr]',$value->description,'class="fr"');
echo form_input('data['.$value->id.'][desc_it]',$value->description,'class="it"');
echo form_input('data['.$value->id.'][desc_es]',$value->description,'class="es"');
echo form_input('data['.$value->id.'][desc_pl]',$value->description,'class="pl"');
echo "<br>";


 echo "</div>"; */
 echo "<br>";
 
 echo form_input('data['.$value->id.'][id]',$value->id);/*id*/
echo form_hidden('data['.$value->id.'][href]',$value->small_thumb->url); /*url*/
echo form_hidden('data['.$value->id.'][href_width]',$value->small_thumb->width); /*url_width*/
echo form_hidden('data['.$value->id.'][href_height]',$value->small_thumb->height); /*url_height*/
echo form_hidden('data['.$value->id.'][desc]',$value->description); /*url_desc*/


echo form_hidden('data['.$value->id.'][prev]',$value->preview->url); /*preview*/
echo form_hidden('data['.$value->id.'][prev_width]',$value->preview->width); /*preview_wid*/
echo form_hidden('data['.$value->id.'][prev_height]',$value->preview->height); /*preview_hei*/


echo   "<img id='".$value->id."' src='".$value->small_thumb->url."'/>&nbsp;";
echo "<div>"; 
echo form_radio('data['.$value->id.'][rdi]','2');
   
       echo "<label class='l_no'>Нет</label>";
      echo form_radio('data['.$value->id.'][rdi]','1');
echo   "<label class='l_yes'>Да</label>";
echo "</div>";              
echo "</div>";               




}





?>
<br />
<br />
<div>

<p><input value="Всего страниц: <?= $tot_pages?>" type="button"/></p>
<p><input value="Текущая страница: <?= $page?>" type="button"/></p>








<?php 

if($back<$page) {
$back = $page - 1;      
    ?>
<!--<a style="" href="sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $page?>">Next</a>-->
<input value="Предыдущая" onclick="location.href='sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?=$back;?>'" type="button" />
<?php    
}




?> 
<?php 

if($page<=$tot_pages) {
$next = $page + 1;
    ?>
<!--<a style="" href="sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $page?>">Next</a>-->
<input style="margin-top:13px" value="Далее" onclick="location.href='sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $next?>'" type="button" />
<?php    
}
?>  


<p style="margin: auto;"><input type="submit" value="Сохранить изменения"/></p>
</div>
<input type="text" style="visibility: hidden;" name="categ" value="<?=$idcat ?>"/>

</div>



















<script type="text/javascript">



$(".document").ready(function(){
    
    
/*
$.ajax({
type: "POST",                                                           
                                                       
url: "https://translate.yandex.net/api/v1.5/tr.json/translate",
data: {text:'Hello&nbsp;world',key:'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-ru' },                                                            
                    
dataType: 'json',                            
success: function(data){    
$.each(data, function(id, val) {

//console.log(val['0']);


})
}   
});*/

});
/*
$(".btn").click(function(){
    
    
    
  console.log("hello");  
    
})*/
//    

/*
$(function () {
        function dumpInArray(){
           var arr = [];
           $('.bl input[type="radio"]:checked').each(function(){
         
console.log($(this).val());
           });
         
        }
});*/


/*
$('.bl input[type="radio"]:checked').each(function(){
         
  console.log("hello");  
           });*/
           
           
$('.wrap').click(function(){
  //console.log("hello");  
  //alert ($("input:eq(2)").val());
   //dumpInArray();
  
             // console.log((dumpInArray()));  

  item = $(this);
   
   //alert ($(item).children('.b').val());






var titl = $(item).children('.b').val();



$.getJSON("https://translate.yandex.net/api/v1.5/tr.json/translate", { text: titl, key: 'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-fr' }, function(json){
//console.log(json.text);
$(item).children('.fr').val(json.text);
});
$.getJSON("https://translate.yandex.net/api/v1.5/tr.json/translate", { text: titl, key: 'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-de' }, function(json){
//console.log(json.text);

$(item).children('.de').val(json.text);
});
$.getJSON("https://translate.yandex.net/api/v1.5/tr.json/translate", { text: titl, key: 'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-pl' }, function(json){
//console.log(json.text);
$(item).children('.pl').val(json.text);
});
$.getJSON("https://translate.yandex.net/api/v1.5/tr.json/translate", { text: titl, key: 'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-es' }, function(json){
//console.log(json.text);
$(item).children('.es').val(json.text);
});
$.getJSON("https://translate.yandex.net/api/v1.5/tr.json/translate", { text: titl, key: 'trnsl.1.1.20140514T190837Z.500fa096ab7f01eb.d61fbb77ec1c02ea8414f778dbe7dd0384fa7ba0',lang:'en-it' }, function(json){
//console.log(json.text);
$(item).children('.it').val(json.text);
});


});






jQuery(document).ready(function() {
  jQuery(".contentt").hide();
  //toggle the componenet with class msg_body
  jQuery(".heading").click(function()
  {
    jQuery(this).next(".contentt").slideToggle(500);
  });
});

if ($('input[name=rdi]:checked')){
console.log("hello");
    
}


</script>



</form>
