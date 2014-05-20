
<form action="get_bigstock/<?=$idcat?>" method="POST">
<div style="width: 900px; margin: 0 auto;">

<?php

/**
 * @author admin
 * @copyright 2014
 */

//var_dump($bd_sel_cat);


//print_r($_GET);


//print_r($tot_pages);/*Всего страниц*/
//echo $page;/*текущая страница*/


foreach ($bd_sel_cat as $value){

   
//var_dump($value->description);
//
//print_r($next_key->id);
//print_r($next_key->id.'&nbsp;'.$next_key->small_thumb->url);  

//var_dump ($value);



echo form_hidden('data['.$value->id.'][id]',$value->id);/*id*/
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
              
echo "</pre>";

  

}





?>
</div>



<input value="Всего страниц: <?= $tot_pages?>" type="button"/>
<input value="Текущая страница: <?= $page?>" type="button"/>






<?php 

if($back<$page) {
$back = $page - 1;      
    ?>
<!--<a style="" href="sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $page?>">Next</a>-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input value="Предыдущая" onclick="location.href='sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?=$back;?>'" type="button" />
<?php    
}




?> 
<?php 

if($page<=$tot_pages) {
$next = $page + 1;
    ?>
<!--<a style="" href="sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $page?>">Next</a>-->
<input value="Далее" onclick="location.href='sel_photo?id_cat=<?= $_GET['id_cat'];?>&view_gallery=<?= $_GET['view_gallery'];?>&hid=<?= $_GET['hid'];?>&page=<?= $next?>'" type="button" />
<?php    
}
?>  










<input type="text" style="visibility: hidden;" name="categ" value="<?=$idcat ?>"/>
<input type="submit" value="Сохранить изменения"/>


</form>
