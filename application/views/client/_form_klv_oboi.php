<table class="box_order">
    <tr>
        <td>
            <sup style="color:#F00;">*</sup>
            город:
            <br>
            <input class="form-at-crop" name="city" type="text">
        </td>
    </tr>
    <tr>
        <td>
            <?=$lang == '/ua' ? 'ім\'я' : 'имя' ;?>:
            <br>
            <input class="form-at-crop" name="name" type="text" value="">
        </td>
    </tr>
    <tr>
        <td>
            <sup style="color:#F00;">*</sup>
            телефон:
            <br>
            <input class="form-at-crop" name="phone" type="text">
            <input id="i-am-robot" name="i_am_robot" value="">
        </td>
    </tr>
    <tr class="tr-order">
        <td>
            e-mail:
            <br>
            <input class="form-at-crop" name="email" type="text">
        </td>
    </tr>
    <tr>
        <td>
            <?=$lang == '/ua' ? 'коментар' : 'комментарий' ;?>:
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
            <?= $lang == '/ua' ? 'Введить код' : 'Введите код' ;?>:
            <br>
            <?= $capthca_img; ?>
            <br>
            <input type="text" name="captcha" value="" />
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="text-align:right;">
            <button class="butt_" name="order"><?=$lang == '/ua' ? 'Зробити замовлення' : 'Сделать заказ' ;?></button>
        </td>
    </tr>
</table>
<div style="font-size:10px;padding:5px 0 0;border-top:1px solid #DFDFBC;">
    <sup>*</sup>
    <?=$lang == '/ua' ? 'поля відмічені зірочкою обов\'язкові для заповнення' : 'поля отмеченные звездочкой обязательны для заполнения' ;?>
</div>