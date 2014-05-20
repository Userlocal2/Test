<?php

/**
 * @author Oleg Pamfilov
 * @copyright 2014
 */



?>

<section>
    <style>
        .res-box {
            position: relative;
            text-align: center;
            font-size: 14px;
            padding: 50px 0;
        }
        .payu-frame {
            width: 100%;
            height: 900px;
            border: 0;
            
        }
        #loader {
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 10;
        }
        #thanks {
            position: relative;
            z-index: 8;
        }
    </style>
	<?php require_once '_box_callback.php'; ?>
	
    <div class="res-box">
        <div id="loader" style="display: n-one;">
            <img src="/img/i/progress2.gif" />
        </div>

        <div id="thanks" style="display: non-e;">
            <!--p>Thank you! Please wait and you will be redirected to the payment page.</p-->
<?
    $this->config->load('payu', true);
    $payu_config = $this->config->item('payu');
    //var_dump($payu_config);

    $form=array(
        'merchant' => $payu_config['payu_merchant'],
        'order_ref' => $order->id,
        'order_date' => date('Y-m-d H:i:s'),
        'order_pname' => 'Pay for order #'.$order->id,
        'order_pcode' => 'uwall_'.$order->id,
        'order_pinfo' => '',
        'order_price' => $order->amount,
        'order_qty' => 1,
        'order_vat' => 0,

        'order_shipping' => 0,
        'prices_currency' => 'USD',
        'pay_method' => '',
        'order_price_type' => 'GROSS',
    );
    $s='';
    foreach ($form as $v) {
        $s.=mb_strlen($v,'8bit').$v;
    }
    $hash=hash_hmac("md5", $s, $payu_config['payu_secretKey']);
?>

<form method="post" action="https://secure.payu.ua/order/lu.php" id="payUform" accept-charset="utf-8" target="tPayFrame">
    <input type="hidden" name="MERCHANT" value="<?=$form['merchant']?>" />
    <input type="hidden" name="ORDER_REF" value="<?=$form['order_ref']?>" />
    <input type="hidden" name="ORDER_DATE" value="<?=$form['order_date']?>" />

    <input type="hidden" name="ORDER_PNAME[]" value="<?=$form['order_pname']?>" />
    <input type="hidden" name="ORDER_PCODE[]" value="<?=$form['order_pcode']?>" />
    <input type="hidden" name="ORDER_PINFO[]" value="<?=$form['order_pinfo']?>" />
    <input type="hidden" name="ORDER_PRICE[]" value="<?=$form['order_price']?>" />
    <input type="hidden" name="ORDER_PRICE_TYPE[]" value="<?=$form['order_price_type']?>" />
    <input type="hidden" name="ORDER_QTY[]" value="<?=$form['order_qty']?>" />
    <input type="hidden" name="ORDER_VAT[]" value="<?=$form['order_vat']?>" />

    <input type="hidden" name="ORDER_SHIPPING" value="<?=$form['order_shipping']?>" />
    <input type="hidden" name="PRICES_CURRENCY" value="<?=$form['prices_currency']?>" />
    <input type="hidden" name="PAY_METHOD" value="<?=$form['pay_method']?>">

    <?
        list($n1,$n2)=explode(' ', $order->user_name);
    ?>
    <input type="hidden" name="BILL_FNAME" value="<?=htmlspecialchars($n1)?>" />
    <input type="hidden" name="BILL_LNAME" value="<?=htmlspecialchars($n2)?>" />
    <input type="hidden" name="BILL_EMAIL" value="<?=htmlspecialchars($order->user_email)?>" />
    <input type="hidden" name="BILL_PHONE" value="<?=htmlspecialchars($order->user_phone)?>" />

    <input type="hidden" name="AUTOMODE" value="1" />
    <input type="hidden" name="LANGUAGE" value="EN" />
    <!--input type="hidden" name="TESTORDER" value="FALSE" /-->
    <!--input type="hidden" name="DEBUG" value="0" /-->
    <input type="hidden" name="ORDER_HASH" value="<?=$hash?>" />
    <!--input type="hidden" name="BACK_REF" value="https://secure.payu.ua"-->

    <input type="submit" value="pay via PayU" style="display: none;" />
</form>
            

           <iframe width="100%" height="500px" class="payu-frame" name="tPayFrame" id="PayFrame" onload="hideLoader()"></iframe>
        </div>

        <script type="text/javascript">
            function paySubmit() {
                document.getElementById('payUform').setAttribute('target','PayFrame');
                document.getElementById('PayFrame').style.display='block';
                return true;
            }
            function rotareThanks() {
                document.getElementById('loader').style.display='none';
                document.getElementById('thanks').style.display='block';
            }
            //setTimeout(rotareThanks, 5*1000);

            function hideLoader() {
                document.getElementById('loader').style.display='none';
            } 
         document.getElementById('payUform').submit();
        </script>
    </div>
		
	
	</div>
	
</section>