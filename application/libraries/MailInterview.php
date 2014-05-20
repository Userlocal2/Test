<?php if (!defined('BASEPATH')) exit('Нет доступа к скрипту');
class MailInterview {
    
    public function renderInputData()
    {
        //question 1
        if( isset($_POST['sex']) )
        {
            $sex = $_POST['sex'];
        }
        else
        {
            $sex = 'Пол не выбран';
        }
        
        //question 2
        if( isset($_POST['age']) )
        {
            $age = $_POST['age'];
        }
        else
        {
            $age = 'Возраст не введен';
        }
        
        //question 3
        if( isset($_POST['oblast']) )
        {
            $oblast = $_POST['oblast'];
            if( !empty($_POST['city']) )
            {
                $city = $_POST['city'];
            }
            else
            {
                $city = 'Город не введен';
            }
        }
        else
        {
            $oblast = 'Область не выбрана';
            $city = 'Город не введен';
        }
        
        //questin 4
        if( isset($_POST['type_pyament']) )
        {
           $type_pyament = $_POST['type_pyament'];
        }
        else
        {
            $type_pyament = 'Нет';
        }
        
        //question 5
        if( isset($_POST['family']) )
        {
            if( $_POST['family'] == 1 )
            {
                $family = $_POST['family1'];
            }
            else
            {
                $family = 'Нет семьи';
            }
        }
        else
        {
            $family = 'Нет семьи';
        }
        
        //question 6
        if( isset($_POST['amlount_glue']) )
        {
            $amlount_glue = $_POST['amlount_glue'];
        }
        else
        {
            $amlount_glue = 'Не выбрано';
        }
        
        //question 7
        if( !empty($_POST['reason']) )
        {
            $reason = $_POST['reason'];
        }
        else
        {
            $reason = 'Не выбрано';
        }
        
        //question 8
        if( !empty($_POST['how_decided']) )
        {
            $how_decided = $_POST['how_decided'];
        }
        else
        {
            $how_decided = 'Не выбрано';
        }
        
        //question 9
        if( isset($_POST['day_before']) )
        {
            $day_before = $_POST['day_before'];
        }
        else
        {
            $day_before = 'Не выбрано';
        }
        
        //question 10
        if( !empty($_POST['where_looking']) )
        {
            $where_looking = $_POST['where_looking'];
        }
        else
        {
            $where_looking = 'Не выбрано';
        }
        
        //question 11
        if( isset($_POST['tm']) && $_POST['tm'] == 0 )
        {
            $tm = 'Никаких';
        }
        elseif( !empty($_POST['tm']) && $_POST['tm'] != 0 && strlen($_POST['tm']) > 1 )
        {
            $tm = $_POST['tm'];
        }
        else
        {
            $tm = 'Никаких';
        }
        
        //question 12
        if( isset($_POST['why_we']) )
        {
            $why_we = $_POST['why_we'];
        }
        else
        {
            $why_we = 'Не выбрано';
        }
        
        //question 13
        if( isset($_POST['characteristic']) && is_array($_POST['characteristic']) )
        {
            $characteristic = implode(', ', $_POST['characteristic']);
        }
        elseif( !empty($_POST['characteristic']) && is_string($_POST['characteristic']) )
        {
            $characteristic = $_POST['characteristic'];
        }
        else
        {
            $characteristic = 'Не выбрано';
        }
        
        //question 14
        if( isset($_POST['producer']) )
        {
            $producer = $_POST['producer'];
        }
        else
        {
            $producer = 'Не выбрано';
        }
        
        //question 15
        if( isset($_POST['your_fears']) )
        {
            $your_fears = $_POST['your_fears'];
        }
        else
        {
            $your_fears = 'Не выбрано';
        }
        
        //question 16
        if( isset($_POST['how_often']) )
        {
            $how_often = $_POST['how_often'];
        }
        else
        {
            $how_often = 'Не выбрано';
        }
        
        //question 17
        if( isset($_POST['accommodation']) )
        {
            $accommodation = $_POST['accommodation'];
        }
        else
        {
            $accommodation = 'Не выбрано';
        }
        
        //question 18
        if( isset($_POST['worker']) )
        {
            $worker = $_POST['worker'];
        }
        else
        {
            $worker = 'Не выбрано';
        }
        
        //required filed phone
        if( !empty($_POST['phone']) )
        {
            $phone = trim($_POST['phone']);
        }
        else
        {
            $phone = 'Не введен';
        }
        
        //field email
        if( isset($_POST['email']) )
        {
            $email = $_POST['email'];
        }
        else
        {
            $email = 'Не введен';
        }
        
        //field order number
        if( isset($_POST['num_order']) )
        {
            $num_order = $_POST['num_order'];
        }
        else
        {
            $num_order = 'Не введен';
        }
        
        $entry_data = array('sex' => $sex, 
                            'age' => $age, 
                            'oblast' => $oblast, 
                            'type_pyament'=>$type_pyament,
                            'city' => $city, 
                            'family' => $family, 
                            'amlount_glue' => $amlount_glue, 
                            'reason' => $reason, 
                            'how_decided' => $how_decided, 
                            'day_before' => $day_before,
                            'where_looking' => $where_looking, 
                            'tm' => $tm,
                            'why_we' => $why_we,
                            'characteristic' => $characteristic,
                            'producer' => $producer,
                            'your_fears' => $your_fears,
                            'how_often' => $how_often,
                            'accommodation' => $accommodation,
                            'worker' => $worker,
                            'phone' => $phone,
                            'email' => $email,
                            'num_order' => $num_order);
        //if all data is verified, then return array entered data
        return $entry_data;
    }

    public function sendMail()
    {
        
        $to = "jenya@klvoboi.ru";// "ivan@klever.dp.ua";
        $subject  = "Answer to question";
        $headers = "MIME-Version: 1.0\r\n";
        $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.
        $headers.= "Content-Type: multipart/mixed; boundary=".$boundary."\r\n";
        $headers.= "From: Answer to question Art-oboi <sale@art-oboi.com.ua>\r\n";
        
        $entered_data = $this->renderInputData();
        $msg = "<table style='width:100%; border:1px solid #ddd;' cellpadding='0' cellspacing='0'>
                  <tr style='background: #cfcfcf; '>
                     <td style='width:250px; font-size: 15px;  font-weight: bold; background: #cfcfcf; border: 1px solid #ddd; padding:5px 0 5px 15px;'>Вопросы, №</td>
                     <td style=' font-size: 15px;  font-weight: bold; background: #cfcfcf; border: 1px solid #ddd; padding:5px 0 5px 15px;'>Ответы на вопросы</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>1. Пол</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['sex']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>2. Возраст</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['age']."</td>
                  </tr>
                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>3. Область</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['oblast']."</td>
                  </tr>
                  <tr>
                    <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>4. Повлияло бы на Ваше решение, если бы Вам необходимо было внести предоплату заказа?</td>
                    <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['type_pyament']."</td>
                  </tr>
                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>5. Город</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['city']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>6. Есть ли семья и сколько человек?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['family']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>7. Первый ли раз будет клеить фотообо, какой?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['amlount_glue']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>8. Почему решили клеить фотообои? </td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['reason']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>9. Как к этому пришли?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['how_decided']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>10. Как долго принимали решение перед покупкой?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['day_before']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>11. Где еще кроме Интернета смотрели фотообои?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['where_looking']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>12. Какие торговые марки фотообоев знаете?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['tm']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>13. Почему выбрали именно нас?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['why_we']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>14. Перечень наиболее важных для Вас характеристик в фотообоях?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['characteristic']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>15. Доверяете больше национальным ТМ(торговая марка) или иностранным?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['producer']."</td>
                  </tr>
                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>16. Какие опасения связанные с фотообоями?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['your_fears']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>17. Как часто делаете ремонт?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['how_often']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>18. Будете клеить в доме или квартире?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['accommodation']."</td>
                  </tr>

                  <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>19. Будете клеить сами или с помощью наемных работников?</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['worker']."</td>
                  </tr>

                   <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>Телефон</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['phone']."</td>
                  </tr>
                   <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>Email</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['email']."</td>
                  </tr>
                   <tr>
                     <td style='width:250px; background: #e9f5e9; border: 1px solid #ddd; padding:5px 0 5px 15px;'>Номер заказа</td>
                     <td style='border: 1px solid #ddd; padding:5px 0 5px 15px; '>".$entered_data['num_order']."</td>
                  </tr>

                 </table>";
        $filename = $this->putInFile();
        $fp = fopen($filename,"r");
        if (!$fp)
        {
          print "Файл $filename не может быть прочитан";
          exit();
        }
        $file = fread($fp, filesize($filename));
        fclose($fp);
        
        $res = $this->SMTPMail($msg, $filename, $to);
        if($res == true)
        {
           //header('Location: http://art-oboi.com.ua/'.LANG.'/your-review-sent.html');
           return true;
        }
        else
        {
           //header('Location: http://art-oboi.com.ua/'.LANG);
           return false;
        }
    }

    public function putInFile()
    {
        $filename = "files/interview.txt";
        $handlerFile = fopen($filename, "wb");
        $translate_key = array( 'sex' => 'Пол', 
                                'age' => 'Возраст', 
                                'oblast' => 'Область', 
                                'type_pyament' => 'Влияние типа оплаты',
                                'city' => 'Город', 
                                'family' => 'Семья', 
                                'amlount_glue' => 'Количество поклеек', 
                                'reason' => 'Почему решили клеить фотообо', 
                                'how_decided' => 'Как к этому пришли', 
                                'day_before' => 'Как долго принимали решение',
                                'where_looking' => 'Где еще смотрели фотообои', 
                                'tm' => 'Торговые марки',
                                'why_we' => 'Почему мы',
                                'characteristic' => 'Наиболее выжные характеристики',
                                'producer' => 'Доверии к ТМ',
                                'your_fears' => 'Ваши опасения',
                                'how_often' => 'Как часто делаете ремонт',
                                'accommodation' => 'Где клеить',
                                'worker' => 'Кто клеит',
                                'phone' => 'Телефон',
                                'email' => 'E-mail',
                                'num_order' => 'Номер заказа');
        $arrayData = $this->renderInputData();
        foreach ($arrayData as $key => $val)
        {
            $temp_array = array($translate_key[$key], $val);
            fputcsv($handlerFile, $temp_array, ';');
        }
        return $filename;
    }
    
    public function SMTPMail( $message, $filename, $recipient )
    {
        $CI = &get_instance();
        $CI->load->library('email');
        
        //set parameters
        $config['protocol'] = 'smtp';
        $config['charset'] = 'utf-8';
        $config['smtp_host'] = 'mail.klever.dp.ua';
        $config['smtp_user'] = 'oboi@klvru.ru';
        $config['smtp_pass'] = 'oboi123';
        $config['smtp_port'] = '25';
        $config['smtp_timeout'] = '10';
        $CI->email->initialize($config);

        
        $CI->email->from('oboi@klvru.ru', 'Klv-oboi');
        $CI->email->to($recipient); 

        $CI->email->subject('Скидки на обои');
        $CI->email->message($message);	
        
        $CI->email->attach($filename);
        
        $res = $CI->email->send();
        return $res;
    }
   }
?>
