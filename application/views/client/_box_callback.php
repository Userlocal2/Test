<!--<table class="box_callback">
    <tr>
        <td>
            <a class="bc call" onclick="callBack()">
                <span>a</span>
                Заказать обратный звонок
            </a>    
        </td>
        <td>
            <a class="bc inf" href="/production.html">
                <span>h</span>
                Изготовим за 2 дня
            </a>
        </td>
        <td>
            <a class="bc inf2" href="/my-vam-doveryaem.html">
                <span>j</span>
                Мы Вам доверяем
            </a>
        </td>
        <td>
            <a class="bc inf2" href="/reviews.html">
                <span>m</span>
                Отзывы о нас
            </a>
        </td>
    </tr>
</table>-->
<div class="row box_callback">
 <!--   <div class="col-sm-4">
        <span class="glyphicon glyphicon-transfer"></span>
    <!--<a id="cli" onclick="callBack()" >Call back</a>
    <!--<a class="cli" onclick="callBack()" >Call back</a>
    
    
    </div>-->
 <!--   <div style="float:right" class="col-sm-4">
        <span class="glyphicon glyphicon-envelope"></span>
        <a href="mailto:<?php echo $phone->mail_order?>"><?php echo $phone->mail_order?></a>
    </div>-->
   <!-- <div class="col-sm-4">
        <span class="glyphicon glyphicon-earphone"></span>
        <?php echo $phone->tel_1; ?>
    </div>-->
</div>


<script type="text/javascript">

$('table td:contains("Helllo")').css('border', '1px solid red');

/*
$(document).ready( function() {
	$('.cli').click( function() {
	//	var goal_name = this.className.match(/OBRZvon([^\s]+)/)[1];
		yaCounter10077769.reachGoal(OBRZvon);
		return true;
	});
})
*/

</script>

<?php  
//echo "test header";

if ($am){
   echo "<br>"; 
 echo "
 <table style='width:100%; height: 30px; border-radius:10px;  background: none repeat scroll 0 0 #F5F5E9;'>
<tr>
<td style='text-align:center; border-right: 1px solid white;'>Total price: </td>
<td style='text-align:center; '> € ".$am."</td>
</tr>
</table>";  

    
}




?>

