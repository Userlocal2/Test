<?php
$domen = 'http://'.end(explode("/", $_SERVER['SERVER_NAME']));
$html = file_get_contents($domen);
$str = '
	<h1>Ошибка 404</h1>
	<div>
		<i>
			Произошла ошибка!
			<br>
			Возможно Вы ввели неверный  URL-адрес или текущая страница временно не доступна.
		</i>
	</div>
	<div style="text-align:center;padding:50px 0;">
		<img src="/img/i/404.jpg">
	</div>
';

$html = preg_replace('/(.+<section>.+)<section>.+(<table class="1box_callback">.+<\/table>).+<\/section>(.+<\/section>.+)/Uis', '${1}<section>${2}'.$str.'</section>${3}', $html);

echo $html;
?>