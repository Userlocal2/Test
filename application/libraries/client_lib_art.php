<?php
class Client_lib
{
	public function client_view($type,$data)
	{
		$CI =& get_instance();

		$CI->load->view('client/parts/header.php', $data);
		$CI->load->view('client/parts/left.php');
		$CI->load->view('client/'.$type.'.php');
		$CI->load->view('client/parts/footer.php');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CALLBACK
	public function callBack()
	{
		$CI =& get_instance();

		//$info = $CI->db->query('SELECT * FROM info')->row();

		$name  = substr(htmlspecialchars(trim($_POST['name'])), 0, 100);
		$phone = substr(htmlspecialchars(trim($_POST['contact'])), 0, 100);
		$comm  = substr(htmlspecialchars(trim($_POST['comm'])), 0, 1000);

		if(!empty($phone)){
			$to= $mail_callback;

			if(empty($name)){ $name = 'неизвестно';}
			if(empty($comm)){ $comm = 'пусто';}

			$msg = '<html>
						<head>
						  <title>Callback order art-murals.ca</title>
						</head>
						<body>
							<h2 style="text-align:center; font-weight:normal;color:#fff;background:#53afea;margin:0;">Заказ обратого звонка art-murals.ca</h2>
							<table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
								<tr style="background:#eee;">
									<td width="150px" align="center" style="border:1px solid #ccc"><small>Имя</small></td>
									<td width="150px" align="center" style="border:1px solid #ccc"><small>Телефон / e-mail</small></td>
									<td align="center" style="border:1px solid #ccc"><small>Сообщение</small></td>
								</tr>
								<tr>
									<td valign="top" align="center" style="border:1px solid #ccc">'.$name.'</td>
									<td valign="top" align="center" style="border:1px solid #ccc">'.$phone.'</td>
									<td valign="top" style="font-size:12px;border:1px solid #ccc">'.$comm.'</td>
								</tr>
							</table>
                                                        <br>
						<br>
						<div>
							Begin&GT;'.$name.'|'.$phone.'|'.$comm.'&LT;End
						</div>
                                                </body>
                                </html>';
            
            $to = 'site@art-murals.ca';//'site@art-murals.ca';//'walldeco.klever@gmail.com';//'site@walldeco.com.ua';  
            $headers = 'From: Art-murals <site@art-murals.ca>' . "\r\n";
            $headers.= 'Content-type: text/html; charset="utf-8"';

            $subject = "Callback order art-murals.ca";

            
            $send = mail($to,$subject,$msg,$headers);
            //$this->SendMessageSMTP($to, $msg, $tema);
			echo 'Thanks!';
			exit;
		}
		echo 'You didn\'t enter requred data!';
		exit;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__ORDER_IMG
	public function order()
	{
		$CI =& get_instance();
//print_r($_SESSION['order_id']);
		//$info = $CI->db->query('SELECT * FROM info')->row();
//die();
		$name       = substr(htmlspecialchars(trim($_POST['name'])), 0, 100);
		$email      = substr(htmlspecialchars(trim($_POST['email'])), 0, 100);
		$phone      = substr(htmlspecialchars(trim($_POST['phone'])), 0, 100);
		$comment    = substr(htmlspecialchars(trim($_POST['comment'])), 0, 1000);
		$num_img    = htmlspecialchars(trim($_POST['num_img']));
		$coordinats = htmlspecialchars(trim($_POST['coordinats']));
		$print      = htmlspecialchars(trim($_POST['print1'])); 
		$textura    = htmlspecialchars(trim($_POST['textura']));
        



    
		$flip       = '';//(int)$_POST['flip'] == 1 ? 'ДА' : 'нет';
		$filter     = htmlspecialchars(trim($_POST['filter']));
        //$city       = htmlspecialchars(trim($_POST['city']));
        $lak        = (int)$_POST['lak_'] ? 'да' : 'нет';
        $kley       = (int)$_POST['kley'] ? 'да' : 'нет';
		
    /*2.05*/
        $orderId = (int)$_SESSION['order_id'];
/*end_2.05*/

/*new_filds*/


$name_last  = substr(htmlspecialchars(trim($_POST['name_last'])), 0, 100);
$adre_first = substr(htmlspecialchars(trim($_POST['adre_first'])), 0, 100);

$adre_sec = substr(htmlspecialchars(trim($_POST['adre_sec'])), 0, 100);
$city = substr(htmlspecialchars(trim($_POST['city'])), 0, 100);
$country = substr(htmlspecialchars(trim($_POST['country'])), 0, 100);
$state = substr(htmlspecialchars(trim($_POST['state'])), 0, 100); 
$zip = substr(htmlspecialchars(trim($_POST['zip'])), 0, 100);





/*end_new_filds*/


        
           
$msg = '<html>
					<head>
					  <title>Image_order art-murals.ca</title>
					</head>
					<body>
						<h2 style="text-align:center; font-weight:normal;color:#fff;background:#53afea;margin:0;">Message from the page trim art-murals.ca</h2>
						<table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
						
                        
                        	<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Order ID: </small></td>
								<td align="left" style="border:1px solid #ccc">'.$orderId.'</td>
							</tr>
                        
                        
                        
                        
                        
                        	<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>First Name: </small></td>
								<td align="left" style="border:1px solid #ccc">'.$name.'</td>
							</tr>
                            
                            

<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Lastname: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$name_last.'</td>
</tr> 


		<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Phone Number: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$phone.'</td>
							</tr>



	<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>E-mail: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$email.'</td>
							</tr>                                 


<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Address Line 1: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$adre_first.'</td>
</tr>




<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Address Line 2: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$adre_sec.'</td>
</tr>




<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Suburb/City: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$city.'</td>
</tr>





<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Country: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$country.'</td>
</tr>





<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>State/Province: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$state.'</td>
</tr>


<tr>
								<td width="150px" align="right" style="border:1px solid #ccc;background:#eee;"><small>Zip/Postcode: </small></td>
								<td align="left" style="border:1px solid #ccc;">'.$zip.'</td>
</tr>    
                            
					
						                                                                                                                                 
                           





                                                                                                                                                                                                                            
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Phone pictures: </small></td>
								<td align="left" style="font-size:12px;border:1px solid #ccc">'.$num_img.'</td>
							</tr>
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Type of canvas: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$textura.'</td>
							</tr>
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Cover: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$print.'</td>
							</tr>
							
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Filter: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$filter.'</td>
							</tr>
                            <tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Lacquer: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$lak.'</td>
							</tr>
                            <tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Glue: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$kley.'</td>
							</tr>
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Coordinates trimming: </small></td>
								<td style="font-size:12px;border:1px solid #ccc">'.$coordinats.'</td>
							</tr>
							<tr>
								<td align="right" style="border:1px solid #ccc;background:#eee;"><small>Comments: </small></td>
								<td valign="top" align="left" style="font-size:12px;border:1px solid #ccc">'.$comment.'</td>
							</tr>
						</table>
						<br>
						<br>
						<div>
							Begin&GT;'.$name.'|'.$phone.'|'.$email.'|'.$num_img.'|'.$textura.'|'.$print.'|'.$flip.'|'.$filter.'|'.$coordinats.'|'.$comment.'|'.$lak.'|'.$kley.'|&LT;End
						</div>
					</body>
				</html>';
		
       
       //echo $msg;
       
   
        //$to = 'site@art-murals.ca';//'site@art-murals.ca';//'walldeco.klever@gmail.com';//'site@walldeco.com.ua';  
         $to = 'xxxx@ua.fm';//'site@art-murals.ca';//'site@art-murals.ca';//'walldeco.klever@gmail.com';//'site@walldeco.com.ua';
        $headers = 'From: Art-murals <site@art-murals.ca>' . "\r\n";
        $headers.= 'Content-type: text/html; charset="utf-8"';

        $subject = "Image_order art-murals.ca";
        
        $send = mail($to,$subject,$msg,$headers);
		return true;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__FRIEND_MSG
	public function friend_msg()
	{
		$name  = substr(htmlspecialchars(trim($_POST['name'])), 0, 100);
		$email = substr(htmlspecialchars(trim($_POST['contact'])), 0, 100);
		$comm  = substr(htmlspecialchars(trim($_POST['comm'])), 0, 1000);
		$imgs  = @$_COOKIE['favorit'];
		$imgs  = explode('|',$imgs);
		$del   = array_pop($imgs);
		unset($del);

		if(!count($imgs)){
			echo '<b style="color:red;">ВНИМАНИЕ!</b> Вы не выбрали изображения!';
			exit;
		}

		if(empty($email)){
			echo '<b style="color:red;">ВНИМАНИЕ!</b> Вы не ввели e-mail';
			exit;
		}

		if(!empty($email)){
			$to= $email;

			if(empty($name)){ $name = 'неизвестно';}
			if(empty($comm)){ $comm = 'пусто';}

			$tema    = "Картины сайта art-murals.ca";
			$headers  = "From: art-murals.ca <site@art-murals.ca>\r\n";
			$headers .= "Content-type: text/html; charset=\"utf-8\"";

			$msg = '<html>
						<head>
						  <title>Картины сайта art-murals.ca</title>
						</head>
						<body>
							<h2 style="text-align:center; font-weight:normal;color:#fff;background:#53afea;margin:0;">Картины сайта art-murals.ca</h2>
							<table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
								<tr style="background:#eee;">
									<td width="150px" align="center" style="border:1px solid #ccc"><small>Имя</small></td>
									<td align="center" style="border:1px solid #ccc"><small>Сообщение</small></td>
								</tr>
								<tr>
									<td valign="top" align="center" style="border:1px solid #ccc">'.$name.'</td>
									<td valign="top" style="font-size:12px;border:1px solid #ccc">'.$comm.'</td>
								</tr>
							</table>
							<h3>Ссылки на фотообои:</h3><ol style="padding:10px 0 10px 30px;list-style:decimal;">';
							foreach($imgs as $k){
								preg_match('/\[(.+)\](.+)/', $k, $match);

								$cat = $match[1];
								$articul = $match[2];
								$msg .= '<li style="padding:3px 0;"><a href="http://'.$_SERVER['SERVER_NAME'].'/img/gallery/'.$cat.'/thumbs/thumb_l_'.$articul.'.jpg">'.$articul.'.jpg</a></li>';
							}
							$msg .= '</ol></body>
						</html>';
			mail($to, $tema, $msg, $headers);

			echo 'Ваше письмо успешно отправлено.';
			exit;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__PAGINATION
	public function Pagin($count, $page, $data, $type = 'gallery'){
		$arrViewCount = array(0=>15, 1=>30, 2=>60);
		$view         = array_key_exists($_SESSION['view_count'], $arrViewCount) ? $_SESSION['view_count'] : 0;
		$view         = $arrViewCount[$view];

		$allPage = ceil($count/$view); //всего страниц
		if($allPage == 1){return;}

		//первое и последнее значение
		if($type == 'gallery'){
			$prev = $page == 0 || $page == 1 ? '' : ($page > 2 ? '<a href="'.$data['lang'].'/'.$data['cat_url'].'.html?page='.($page-1).'">&laquo;</a>' : '<a href="'.$data['lang'].'/'.$data['cat_url'].'.html">&laquo;</a>');
			$next = $page == $allPage ? '' : '<a href="'.$data['lang'].'/'.$data['cat_url'].'.html?page='.($page==0?$page+2:$page+1).'">&raquo; </a>';
		}elseif($type == 'color'){
			$prev = $page == 0 || $page == 1 ? '' : ($page > 2 ? '<a href="'.$data['lang'].'/color/'.$data['color'].'.html?page='.($page-1).'">&laquo;</a>' : '<a href="'.$data['lang'].'/color/'.$data['color'].'.html">&laquo;</a>');
			$next = $page == $allPage ? '' : '<a href="'.$data['lang'].'/color/'.$data['color'].'.html?page='.($page==0?$page+2:$page+1).'">&raquo; </a>';
		}

		$str  = $prev;
		$page = $page == 0 ? 1 : $page;//для расчетов ноль не нужен!!!

		$m = $page % 10 == 0 ? 1 : 0;
		$s = (floor(($page-$m)/10).'1')*1;
		$c = (floor(($page-$m)/10).'1')*1+10;

		for($i = $s; $i < $c; $i++){

			if($allPage < $i){ continue;}

			if($i == $page){
				$str .= '<span>'.$i.'</span>';
			}else{
				if($type == 'gallery'){
					$str .= $i==1 ? '<a href="'.$data['lang'].'/'.$data['cat_url'].'.html">'.$i.'</a>' : '<a href="'.$data['lang'].'/'.$data['cat_url'].'.html?page='.$i.'">'.$i.'</a>';
				}elseif($type == 'color'){
					$str .= $i==1 ? '<a href="'.$data['lang'].'/color/'.$data['color'].'.html">'.$i.'</a>' : '<a href="'.$data['lang'].'/color/'.$data['color'].'.html?page='.$i.'">'.$i.'</a>';
				}

			}

		}
		return $str.$next;
	}

	public function Pagin_interior($count, $page = 0, $data){
		$allPage = ceil($count/18); //всего страниц
		if($allPage == 1){return;}

		//первое и последнее значение

		$prev = $page == 0 || $page == 1 ? '' : ($page > 2 ? '<a href="'.$data['lang'].'/photooboi-interior.html?page='.($page-1).'">&laquo;</a>' : '<a href="'.$data['lang'].'/photooboi-interior.html">&laquo;</a>');
		$next = $page == $allPage ? '' : '<a href="'.$data['lang'].'/photooboi-interior.html?page='.($page==0?$page+2:$page+1).'">&raquo; </a>';


		$str  = $prev;
		$page = $page == 0 ? 1 : $page;//для расчетов ноль не нужен!!!

		$m = $page % 10 == 0 ? 1 : 0;
		$s = (floor(($page-$m)/10).'1')*1;
		$c = (floor(($page-$m)/10).'1')*1+10;

		for($i = $s; $i < $c; $i++){

			if($allPage < $i){ continue;}

			if($i == $page){
				$str .= '<span>'.$i.'</span>';
			}else{
				$str .= $i==1 ? '<a href="'.$data['lang'].'/photooboi-interior.html">'.$i.'</a>' : '<a href="'.$data['lang'].'/photooboi-interior.html?page='.$i.'">'.$i.'</a>';
			}
		}

		return $str.$next;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Order texture Ivan
      public function orderTexture()
      {
         $mName         = htmlspecialchars(trim($_POST['mName']));
         $name          = htmlspecialchars(trim($_POST['name']));
         $phone         = htmlspecialchars(trim($_POST['contact']));
         $email         = htmlspecialchars(trim($_POST['email']));
         $city          = htmlspecialchars(trim($_POST['city']));
         $post_num      = htmlspecialchars(trim($_POST['postnum']));
         $index_adress  = htmlspecialchars(trim($_POST['index_adress']));
         $comment       = htmlspecialchars(trim($_POST['comment']));
         $lang          = trim($_POST['lng']);


         $CI =& get_instance();

        // $info = $CI->db->query('SELECT * FROM info')->row();
         $to = 'site@art-murals.ca';//$info->mail_order;

         $tema = "Textures order";
         $headers  = "From: art-murals.ca <site@art-murals.ca>\r\n";
         $headers .= "Content-type: text/html; charset=\"utf-8\"";

         $msg = '<html>
                     <head>
                        <title>Textures order art-murals.ca</title>
                     </head>
                     <body>
                        <table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse; font-size:14px;">
                           <tr>
                              <th colspan="2" style="background:##F2F2DE; font-size:16px; font-weight:bold;" >Данные для заказа образцов текстур</th>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Имя: </td><td style="border:1px solid #ccc;">'.$name.'</td>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Фамилия: </td><td style="border:1px solid #ccc;">'.$mName.'</td>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Телефон: </td><td style="border:1px solid #ccc;">'.$phone.'</td>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Эл. адрес: </td><td style="border:1px solid #ccc;" >'.$email.'</td>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Город: </td><td style="border:1px solid #ccc;">'.$city.'</td>
                           </tr>
                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Номер склада: </td><td style="border:1px solid #ccc;">'.$post_num.'</td>
                           </tr>

                           <tr>
                              <td style="border:1px solid #ccc; background:#efefef; width:200px"">Комметрарий: </td><td style="border:1px solid #ccc;">'.$comment.'</td>
                           </tr>
                        </table>
                        <br>
                        <div>
                        Begin&GT;'.$name.'|'.$mName.'|'.$phone.'|'.$email.'|'.$city.'|'.$post_num.'|'.$comment.'&LT;End
                        </div>
                     </body>
                     </html>';
         //mail($to, $subject, $message, $headers);
         $this->SendMessageSMTP($to, $msg, $tema);
         echo 'Ваше письмо успешно отправлено.';
         exit;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Send mail with link for image
	public function sendImgToMail()
	{
		$articul = htmlspecialchars(trim($_POST['articul']));
		$result = '';
		$this->msg($articul);
	}
	public function get_data($smtp_conn)
	{
		$data="";
		while($str = fgets($smtp_conn)){
			$data .= $str;
			if(substr($str,3,1) == " ") { break; }
		}
		return $data;
	}
	public function msg($articul){
		$mail    = trim($_POST['email']);
		$pathImg = trim($_POST['path']);
		$size = getimagesize('http://'.$_SERVER["SERVER_NAME"].$pathImg);
		if(!empty($mail)){
			$to= $mail;
			$header="Date: ".date("D, j M Y G:i:s")." +0200\r\n";
			$header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Арт обои')))."?= <site@art-murals.ca>\r\n";
			$header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($mail)))."?= <".$mail.">\r\n";
			$header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Вы добавили изображение в список желаний')))."?=\r\n";
			$header.="MIME-Version: 1.0\r\n";
			$header.="Content-Type: text/html; charset=utf-8\r\n";
			$text = '<html>
						<head>
						  <title>Вы добавили изображение в список желаний</title>
						</head>
						<body style="background:#F4F4F4; padding:40px 0;">
							<div style="width:700px; padding:40px 0 40px 15px; background:#fff;  margin: 0 auto;">

								<div style="width:100%; clear:both">
									<img src="http://'.$_SERVER["SERVER_NAME"].'/img/i/logo.jpg">
								</div>

								<div style="width:100%; float: left;">
									<div style="display:inline-block; width: 340px; float:left;">
										<img  alt="включите просмотр картинок" title="" width="339" style="border:1px solid #000;"  src="http://'.$_SERVER["SERVER_NAME"].$pathImg.'">
									</div>
									<div style="display:inline-block;padding-left: 20px; width: 336px;">
										<h3 style="color:#000 !important">Украсьте Вашу жизнь оригинальными фотообоями</h3>
										<p style="margin: 12px 0 0 0; color:#000 !important">Лучший выбор изображений для фотообоев. Выбирайте свое изображение просто, обрезайте под свои размеры удобно, заказывайте легко!</p>
									</div>
								</div>

								<div style="clear: both; padding: 30px 0 0; width: 100%;">
									<div style="display:inline-block; width: 375px;">
										<div style="width:150px; display: inline-block; color:#000 !important; padding-bottom:10px;">Доставка по России</div>
										<div style="width:150px; display: inline-block; color:#000 !important; padding-bottom:10px;">Оплата при получении</div>
										<div style="width:150px; display: inline-block; color:#000 !important">Экологичность</div>
										<div style="width:150px; display: inline-block; color:#000 !important">Возможность возврата</div>
									</div>
									<div style="display:inline-block;padding: 10px 0; width: 260px; background: #e5e5ce; text-align:center; font-size:24px;">
										<a style="text-decoration: none; color: #000 !important;" href="http://'.$_SERVER["SERVER_NAME"].'/crop-image?title='.$articul.'">Заказать сейчас</a>
									</div>
								</div>
							</div>
						</body>
				   </html>';
			$smtp_conn = fsockopen("mail.klever.dp.ua", 25,$errno, $errstr, 10);
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"EHLO klever.dp.ua\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"AUTH LOGIN\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,base64_encode("site@art-murals.ca")."\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,base64_encode("Jlkh78967jjk")."\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"MAIL FROM:site@art-murals.ca\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"RCPT TO:".$mail."\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"DATA\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
			$data = $this->get_data($smtp_conn);

			fputs($smtp_conn,"QUIT\r\n");
			$data = $this->get_data($smtp_conn);

			echo '<div style="  padding: 14px 0 31px;">Ваше письмо успешно отправлено. Проверьте свою почту.</div>';
		}else{
			$GLOBALS['result'] = 'не введен ваш контакт!';
		}
	}  
        
        public function SendMessageSMTP($to, $msg, $theme)
        {
            $header="Date: ".date("D, j M Y G:i:s")." +0300\r\n";
            $header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Арт обои')))."?= <site@art-murals.ca>\r\n";
            $header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($to)))."?= <".$to.">\r\n";
            $header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($theme)))."?=\r\n";
            $header.="MIME-Version: 1.0\r\n";
            $header.="Content-Type: text/html; charset=utf-8\r\n";
            
            $smtp_conn = fsockopen("mail.klever.dp.ua", 25,$errno, $errstr, 10);
            $data = $this->get_data($smtp_conn);
            

            fputs($smtp_conn,"EHLO klever.dp.ua\r\n");
            $data = $this->get_data($smtp_conn); 

            fputs($smtp_conn,"AUTH LOGIN\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,base64_encode("site@art-murals.ca")."\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,base64_encode("Jlkh78967jjk")."\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,"MAIL FROM:site@art-murals.ca\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,"RCPT TO:".$to."\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,"DATA\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,$header."\r\n".$msg."\r\n.\r\n");
            $data = $this->get_data($smtp_conn);

            fputs($smtp_conn,"QUIT\r\n");
            $data = $this->get_data($smtp_conn);
        }
}//END
?>
