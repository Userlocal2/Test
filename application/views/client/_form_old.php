<table class="box_order">
    <tr>
        <td>
        
<sup style="color:#F00;">*</sup>        
            <!--<?=$lang == '/ua' ? 'ім\'я' : 'Name' ;?>:-->
            <?=$lang == '/ua' ? 'ім\'я' : 'First Name' ;?>:
            <br>
            <input class="form-at-crop" name="name" type="text" value="">
        </td>
    </tr>
    
    
   <!-- Моя вставка новыйх параметров  --> 
<tr>
<td>
<sup style="color:#F00;">*</sup>
            <!--<?=$lang == '/ua' ? 'ім\'я' : 'Name' ;?>:-->
            <?=$lang == '/ua' ? 'ім\'я' : 'Last Name' ;?>:
            <br>
       
            <input class="form-at-crop" name="name_last" type="text" value="">
</td>
</tr>









    
    
    
   <!-- end_Моя вставка новыйх параметров  --> 
    
    <tr>
        <td>
            <sup style="color:#F00;">*</sup>
            Phone number:
            <br>
            <input class="form-at-crop" name="phone" type="text">
            <br>
            <span style="opacity: 0.6; font-size: 10px;">for example: 111-111-1111</span>
            <input id="i-am-robot" name="i_am_robot" value="">
        </td>                                   
    </tr>
    <tr class="tr-order">
        <td>

<sup style="color:#F00;">*</sup>
        
            e-mail:
            <br>
            <input class="form-at-crop" name="email" type="text">
        </td>
    </tr>
    
    
    
    
<!-- Моя вставка новыйх параметров  --> 

  <tr>
        <td>


<sup style="color:#F00;">*</sup>        
        
            <?=$lang == '/ua' ? 'коментар' : 'Address Line 1' ;?>:
            <br>
 
            <input class="form-at-crop" name="adre_first" type="text" value="">
        </td>
    </tr>
    

  <tr>
        <td>
        
        
<sup style="color:#F00;">*</sup>        
            <?=$lang == '/ua' ? 'коментар' : 'Address Line 2' ;?>:
            <br>
         
            <input class="form-at-crop" name="adre_sec" type="text" value="">
        </td>
    </tr>



 <tr>
        <td>
        
<sup style="color:#F00;">*</sup>        
        
            <?=$lang == '/ua' ? 'коментар' : 'Suburb/City:' ;?>:
            <br>
       
            <input class="form-at-crop" name="city" type="text" value="">
        </td>
    </tr>



 <tr>
        <td>
        
<sup style="color:#F00;">*</sup>        
        
            <?=$lang == '/ua' ? 'коментар' : 'Country:' ;?>:
            <br>
       
            <input class="form-at-crop" name="country" type="text" value="">
        </td>
    </tr>



 <tr>
        <td>
        
<sup style="color:#F00;">*</sup>        
            <?=$lang == '/ua' ? 'коментар' : 'State/Province:' ;?>:
            <br>

            <input class="form-at-crop" name="state" type="text" value="">
        </td>
    </tr>


 <tr>
        <td>
        
<sup style="color:#F00;">*</sup>        
            <?=$lang == '/ua' ? 'коментар' : 'Zip/Postcode:' ;?>:
            <br>

            <input class="form-at-crop" name="zip" type="text" value="">
        </td>
    </tr>




















<!-- end_Моя вставка новыйх параметров  --> 







    
    
    <tr>
        <td>
            <?=$lang == '/ua' ? 'коментар' : 'Comments' ;?>:
            <br>
            <textarea class="form-at-crop" id="contact_text" name="comment" rows="6" cols="30" style="height:100px;"></textarea>
        </td>
    </tr>
    
    
    
    
    
    <?php if( @$onCaptcha === TRUE ):?>
    <tr>
        <td>
            <?php if(isset($_SESSION['capthca_message'])):?>
            <div style="color:#FF6000"><?= $_SESSION['capthca_message'] ?></div>                             
            <?php endif; ?>
            <?= $lang == '/ua' ? 'Введить код' : 'Enter code' ;?>:
            <br>
            <?= $capthca_img; ?>
            <br>
            <input type="text" name="captcha" value="" />
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="text-align:right;">
            <button class="butt_" name="order"><?=$lang == '/ua' ? 'Зробити замовлення' : 'Make an order' ;?></button>
           <!-- <input type="submit" value="Отправить"/>-->
            
        </td>
    </tr>
</table>