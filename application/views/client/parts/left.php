<aside id="left">
	<ul class="menu">




    
      
      




<?php

/*
if (!$bd_sel_cat){
    
//print_r($podcat_all);    

foreach ($podcat_all as $key => $value): */
//print_r($value);
 ?>
<!--<li>
<a <?=$cat_id == $value ? 'class="tmp-current-link"' :''?> href="<?=base_url(); ?><?=strtolower($value); ?>.html" >
<span><?=$value;?></span>
</a>
</li>--> 
<?php/* endforeach;*/?>

<?php    
/*}



else {
  */
  
  
  
  
  
  
  
foreach ($bd_sel_cat as $key => $value):           

//print_r($value);


//$del_arr = array('Art-Illustration','Communication');




$del_arr = array('Art-Illustration', 'Communication','Computers','Education','Health','Internet','Miscellaneous','Sexual','Conceptual','Editorial','Holidays','Industry','Vintage','Landscapes');



foreach ($del_arr as $va){
    
    
 


//$di[] = $va;   




$key = array_search($va, $value);



//$key = array_search('Communication', $value);
if ($key !== false)
{
    unset($value[$key]);
    
   // print_r($value);
}


}










foreach ($value as $kk):?>


<li>




<a <?=$cat_id == $kk ? 'class="tmp-current-link"' :''?> href="<?=base_url(); ?><?=strtolower($kk); ?>.html" >
<span><?=$kk;?></span>
</a>
</li>       
<?php endforeach;?>
<?php endforeach;?>



<?php
//}   //end_else  ?>





</ul>
</aside><!--LEFT-->