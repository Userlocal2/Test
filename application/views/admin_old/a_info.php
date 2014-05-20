<section>
	
	<article>
		<h1 class="title"><?=$info?></h1>

		<table id="gb">
			<tr>
				<td class="td_c3" style="width:20%;">email - <b>ЗАКАЗ:</b></td>
				<td td-click="info" column="mail_order">
					<?=@$inf->mail_order?>
				</td>
			</tr>
			<tr>
				<td class="td_c3">email - <b>ОБРАТНЫЙ ЗВОНОК:</b></td>
				<td td-click="info" column="mail_callback">
					<?=@$inf->mail_callback?>
				</td>
			</tr>
			<tr>
				<td class="td_c3">телефон-1 <b>под логотипом:</b></td>
				<td td-click="info" column="tel_1">
					<?=@$inf->tel_1?>
				</td>
			</tr>
			<tr>
				<td class="td_c3">телефон-2 <b>в подвале:</b></td>
				<td td-click="info" column="tel_2">
					<?=@$inf->tel_2?>
				</td>
			</tr>
			<tr>
				<td class="td_c3">телефон-3 <b>в подвале:</b></td>
				<td td-click="info" column="tel_3">
					<?=@$inf->tel_3?>
				</td>
			</tr>
			<tr>
				<td class="td_c3">телефон-4:<b>круглосуточный:</b></td>
				<td td-click="info" column="tel_4">
					<?=@$inf->tel_4?>
				</td>
			</tr>
		</table>

	</article>
	
</section>
				
				
			
