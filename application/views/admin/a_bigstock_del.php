
<style>
#main{
    
position: absolute;    
    
}

</style>
<div style="width: 1024px; margin: 0 auto;">
<form action="get_bigstock_del/<?=$idcat?>" method="POST">
<?php

/**
 * @author admin
 * @copyright 2014
 */

//var_dump($bd_sel_cat);


//print_r($_GET);


//print_r($tot_pages);/*Всего страниц*/
//echo $page;/*текущая страница*/

//print_r($select_ph);

//print_r($data);
echo $idcat;

//die();
echo "<br>";
echo "<strong>Выберите фото для удаления&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>"; 
echo "<strong>Категория: &nbsp;&nbsp; </strong>"."<b style='font-size:17px; color:red;'>".$categ."</b>";
echo "<br>";

echo "<br>";
echo "<br>";


foreach ($select_ph as $valu){

foreach ($valu as $value){


//print_r($value);
/*
echo "<pre>";   
print_r($value);
echo "</pre>";
*/



//print_r($next_key->id);
//print_r($next_key->id.'&nbsp;'.$next_key->small_thumb->url);  

//var_dump ($value);



//echo "<pre>";
echo form_hidden('data['.$value->id_img.'][id]',$value->id_img);/*id*/

echo "<div style='width:250px; float:left;'>";
echo   "<img id='".$value->id_img."' src='".$value->url."'/>&nbsp;";
echo "<div >"; 
 echo form_radio('data['.$value->id_img.'][rdi]','2');
   
       echo "<label class='l_no'>Нет</label>";
      echo form_radio('data['.$value->id_img.'][rdi]','1');
echo   "<label class='l_yes'>Да</label>";
echo "</div>";              
echo "</div>";              


  
}
}




?>

<div><input type="text" style="visibility: hidden;" name="categ" value="<?=$idcat ?>"/></div>
<div><input style="margin-left:500px" type="submit" value="Удалить"/></div>


</form>
</div>



<!--<input value="Всего страниц: <?= $tot_pages?>" type="button"/>
<input value="Текущая страница: <?= $page?>" type="button"/>

-->








