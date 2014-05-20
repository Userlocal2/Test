<table class="box_order">
    <tr>
        <td>
            <sup style="color:#F00;">*</sup>
            <?=$lang == '/ua' ? 'Повне ім\'я' : 'Full Name' ;?>:
            <br>
            <input class="form-at-crop" name="name" type="text" value="">
        </td>
    </tr>
    <tr>
        <td>
            <sup style="color:#F00;">*</sup>
            Telephone number:
            <br>
            <input class="form-at-crop" name="phone" type="text">
            <br><span style="opacity: 0.6; font-size: 10px;">for example: 111-111-1111</span>
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
        </td>
    </tr>
</table>