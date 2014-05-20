<?php

/**
 * @author Oleg Pamfilov
 * @copyright 2014
 */
?>
<section>
	<?php require_once '_box_callback.php'; ?>
	
    <div style="text-align:center;font-size:14px;padding:50px 0;">
        <div id="loader" >
            <img src="/img/i/progress2.gif" />
        </div>

        <div id="thanks" style="display: none;">
            <p>Thank you! Please wait and you will be redirected to the payment page.</p>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal-form" >

                <!-- Identify your business so that you can collect the payments. -->
                <input type="hidden" name="business" value="pay@art-murals.ca">




                <!-- Specify a Buy Now button. -->
                <input type="hidden" name="cmd" value="_xclick">

                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="Pay for order <?=$order_id?>">
                <input type="hidden" name="amount" value="<?=$order_amount?>">
                <input type="hidden" name="currency_code" value="USD">

                <!-- Display the payment button. -->
                <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif" alt="PayPal - The safer, easier way to pay online">
                <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

            </form>
        </div>

        <script type="text/javascript">
            function rotareThanks() {
                document.getElementById('loader').style.display='none';
                document.getElementById('thanks').style.display='block';
            }
            setTimeout(rotareThanks, 5*1000);

          document.getElementById('paypal-form').submit();
        </script>
    </div>
		
	
	</div>
	
</section>

