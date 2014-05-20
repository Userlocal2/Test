<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Antispam{
    
    /**
     * Used for CodeIgniter's classes
     * @var object   
     */
    private $_CI;
    
    /**
     * @var array An array required fileds
     */
    private $_required = array(
          'name'        => FALSE,
          'phone'       => TRUE,
          'email'       => FALSE,
          'comment'     => FALSE
    );
    
    /**
     * @var string Determines whether data sent with bot help or person
     */
    private $_i_am_robot = '';
    
    /**
     * @var string Name table which used for order information
     */
    private $_tblOrderInfo = 'lib_order_info';

    /**
     * @var string Name table which used for storing blocked IP addresses
     */
    private $_tblBlockedIP = 'blocked_ip';
    
    /**
     * @var string Remote ip address
     */
    private $_remoteIP;
    
    /**
     * @var int Expire captcha in seconds
     */
    private $_expireCaptcha = 1800;

    /**
     * @var int Range spam mail expiration in seconds
     */
    private $_rangeAcceptingMail = 90;

    /**
     * Methods
     */
    
    public function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->library('email');
        $this->_CI->load->helper('captcha');
        $this->_remoteIP = $this->_CI->input->ip_address();
    }
    
    /**
     * Creates library's tables
     * For creation library's tables need call this method only once from your controller in __constructor
     * 
     */
    public function CreateTables()
    {
        //An array tables that need create
        $tables = array(
              $this->_tblOrderInfo => ' CREATE TABLE IF NOT EXISTS lib_order_info(
                                        id INT PRIMARY KEY AUTO_INCREMENT,
                                        ip_address BIGINT NOT NULL,
                                        date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        user_client VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                        user_name VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
                                        user_phone VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                        user_email VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
                                        num_img VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci
                                        ) ENGINE = MYISAM;',
              $this->_tblBlockedIP => ' CREATE TABLE IF NOT EXISTS blocked_ip(
                                        id INT PRIMARY KEY AUTO_INCREMENT,
                                        ip_address BIGINT NOT NULL,
                                        expire INT NOT NULL    
                                        ) ENGINE = MYISAM;'
        );

        //create new talbes
        foreach ($tables as $value)
        {
            $this->_CI->db->query($value);
        }
    }
    
    /**
     * Retrives data from contact form 
     * Takes $_POST data and separates name, email, phone, comment from another data
     * @return array An associative array contact data
     */
    private function RetriveContactData()
    {
        $clientData = array();
        foreach ( $this->_required as $key => $values )
        {
            print_r($values);
            if( array_key_exists($key, $_POST) )
            {
                $clientData[$key] = trim( $_POST[$key] );
            }
        }
        return $clientData;
    }

    /**
     * Takes input data from order form and escaping them for insert into DB
     * 
     * @return array An array escaped contact form data
     */
    private function EscapedPostData()
    {
        //data from prder form
        $clientData = $this->RetriveContactData();
        
        //image articul
        $num_img = $this->_CI->input->post('num_img', TRUE);

        //remote ip address
        $remoteIP = $this->_remoteIP;
        
        //data user browser
        $user_agent = $this->_CI->input->user_agent();
        
        //new data for insert into DB from new client order
        $insertData = array(
              'ip_address'  => $this->ip2int( $remoteIP ),
              'user_client' => $user_agent,
              'num_img'     => trim($num_img),
        );
        
        if( !empty($clientData['name']) )
        {
            $insertData['user_name'] = $clientData['name'];
        }
        if( !empty($clientData['phone']) )
        {
            $insertData['user_phone'] = $clientData['phone'];
        }
        if( !empty($clientData['email']) )
        {
            $insertData['user_email'] = $clientData['email'];
        }
        
        return $insertData;
    }
    
    /**
     * Validates input data
     * 
     * @postData array Data from contact form (name,email,phone,comment)
     * @return boolean If all data are coorect and valid return TRUE, otherwise FALSE
     */
    public function ValidationData()
    {
        //name, email, phone, comment data from form
        $postData = $this->RetriveContactData();
        //print_r($postData);
        //check whether all required fields are filled
        
        
        foreach ($postData as $key => $value)
        {
            if( $this->_required[$key] === TRUE && empty($value) )
            {
                $_SESSION['dataNonValid'] = 'Обязательные поля не заполнены';
                return FALSE;
            }
        }

        //check on spam bots, returns FALSE if this field has any value
        $this->_i_am_robot = trim( $this->_CI->input->post('i_am_robot', TRUE) );
        if( !empty($this->_i_am_robot) )
        {
            unset($_SESSION['dataNonValid']);
            return FALSE;
        }
        
        //validation phone
        if( strlen($postData['phone']) > 20 )
        {
            $_SESSION['dataNonValid'] = 'Слишком длинное значение телефона';
            return FALSE;
        }
        if( !$this->correct_number_phone( $postData['phone']) ) //preg_match('/[a-z]+/i', $postData['phone']) == 1
        {
            $_SESSION['dataNonValid'] = 'Неверное значение для телефона';
            return FALSE;
        }
        
        //validation name
        if( mb_strlen ($postData['name']) > 20 )
        {
            $_SESSION['dataNonValid'] = 'Слишком длинное имя';
            return FALSE;
        }
        if( !$this->matches_allowed_string( $postData['name'] ) )
        {
            $_SESSION['dataNonValid'] = 'Имя не должно содержать символы отличные от букв';
            return FALSE;
        }
        
        //validation email
        if( mb_strlen ($postData['email']) > 50 )
        {
            $_SESSION['dataNonValid'] = 'Слишком длинное значение email';
            return FALSE;
        }
        if( !empty($postData['email']) && !$this->_CI->email->valid_email( $postData['email'] ) )
        {
            $_SESSION['dataNonValid'] = 'Не корректный email адрес';
            return FALSE;
        }
  
        //if all data are valid
        return TRUE;
    }
    
    /**
     * Inserts new record about order
     */
    public function CommitNewOrder()
    {
        $insertData = $this->EscapedPostData();
        
        //create SQL insert string
        $sql = $this->_CI->db->insert_string( $this->_tblOrderInfo, $insertData);
        
        //insert new record into table
        $this->_CI->db->query($sql);

        /*$r=$this->_CI->db->query('SELECT LAST_INSERT_ID() AS order_id;');
        $_SESSION['order_id']=$r->row('order_id');*/
        
        
    /*2.05*/    
        
         // получаем ID заказа
        $r=$this->_CI->db->query('SELECT LAST_INSERT_ID() AS order_id;');
        $_SESSION['order_id']=$r->row('order_id');
        
        
        
        
        
   // правильно сумму рассчитывать при добавлении заказа, 
        // а не полагаться на полученную из формы
        // но это самый быстрый способ
      //  print_r($_REQUEST);
        $_SESSION['order_amount']=$_POST['amount'];        
        
        
    /*end_2.05*/    
        
        $_SESSION['order'] = $this->_CI->input->post('num_img', TRUE);
        $_SESSION['post']  = $this->_CI->input->post(NULL, TRUE);
    }

    /**
     * Translates ip address to integer number
     * @param string $ip
     * @return int
     */
    public function ip2int($ip) 
    {
        $num = explode(".",$ip);
        $integerIP = $num[0] * 256 * 256 * 256;
        $integerIP+= $num[1] * 256 * 256;
        $integerIP+= $num[2] * 256;
        $integerIP+= $num[3];
        return $integerIP;
    }
    
    /**
     * Shows captcha
     */
    public function ShowCapthca()
    {
        $numOrderPerMinut = $this->FetchLatestOrder();
        if( $numOrderPerMinut >= 3 )
        {
            //first, delete old captcha
            $this->DeleteCaptcha();
            
            return array(
                'onCaptcha'   => TRUE,
                'capthca_img' => $this->CreateCaptcha()
            );
        }
        else
        {
            return array(
                'onCaptcha'   => FALSE,
                'capthca_img' => ''
            );
        }
    }

    
    /************************************************************************/
    /**
    * Generates CAPTCHA, used CodeIgniter's helper
    */
    private function CreateCaptcha()
    {
        $vals = array(
            'img_path'	 => 'captcha/',
            'img_url'	 => 'captcha/',
            'font_path'	 => 'css/fonts/arial.ttf',
            'expiration' => $this->_expireCaptcha
        );

        $cap = create_captcha($vals);
        $c_data = array(
                'captcha_time'	=> $cap['time'],
                'ip_address'	=> $this->_remoteIP,
                'word'          => $cap['word']
        );
        
        //insert new genereted data about captcha into table DB
        $query = $this->_CI->db->insert_string('captcha', $c_data);
        $this->_CI->db->query($query);
        return $cap['image'];
    }
    
    /**
     * Deletes old captcha, that older then 6 minutes
     * @return boolean
     */
    private function DeleteCaptcha()
    {
        // First, delete old captchas
        $expiration = time() - $this->_expireCaptcha; // Six minutes limit
        $this->_CI->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	
    }
    
    /**
     * Checks whether inputed captcha is correct or not 
     * @return boolean
     */
    public function isCorrectCaptcha()
    {
        
        
        $expiration = time() - $this->_expireCaptcha;
        // Then see if a captcha exists:

        //echo $expiration;
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
      
        $binds = array( $this->_CI->input->post('captcha', TRUE), $this->_remoteIP, $expiration);
        
        
        $query = $this->_CI->db->query($sql, $binds);
         
        $row = $query->row();
//         print_r($row);
        if ($row->count == 0)
        {
            $_SESSION['capthca_message'] = "Вы должны ввести слово, что на картинке";
            return FALSE;
        }
        else
        {
            unset($_SESSION['capthca_message']);
            return TRUE;
        }
    }
    
    /**
     * Fetches the latest orders for 90 seconds.
     */
    public function FetchLatestOrder(  )
    {
        $expire = time() - $this->_rangeAcceptingMail;
//        echo $expire;
        $sql = "SELECT count(ip_address) as num_addr"
          . "   FROM {$this->_tblOrderInfo}"
          . "   WHERE UNIX_TIMESTAMP(date_create) > {$expire}"
          . "   GROUP BY ip_address"
          . "   ORDER BY date_create";
       
        $result = $this->_CI->db->query($sql)->row();
        
        if( !empty($result) )
        {
             
            return (int)$result->num_addr;
        }
       
    }
    
   /**
    * Blocks remote IP address that creates spam traffic
    * 
    * @param string $ipAddress Remote client IP address
    * @param string $phone Client number phone
    */
   public function BlockIP()
   {
        $expire = time() + 7200;
        $sql = "INSERT INTO blocked_ip(ip_address, expire) VALUES ( INET_ATON('{$this->_remoteIP}'), {$expire} )";
        $this->_CI->db->query($sql);
        redirect('/');
        exit;
   }
   
   /**
    * Validates client name with russian and english letters
    *
    * @param string $input_string A string in russian character set
    * @return boolean Returns either TRUE if the client name is valid of FALSE
    */
   private function matches_allowed_string( $matched_string )
   {
       //convert from utf-8 to koi8-r character set
       $string_in_rus_charset = iconv('utf-8', 'koi8-r', $matched_string);
       
       //list russian character ASCII codes
       $russian_ascii = array(
              225 => 'А', 226 => 'Б', 247 => 'В', 231 => 'Г', 228 => 'Д', 229 => 'Е', 179 => 'Ё', 246 => 'Ж', 250 => 'З', 233 => 'И', 234 => 'Й', 235 => 'К', 236 => 'Л', 237 => 'М', 238 => 'Н', 239 => 'О', 240 => 'П', 242 => 'Р', 243 => 'С', 244 => 'Т', 245 => 'У', 230 => 'Ф', 232 => 'Х', 227 => 'Ц', 254 => 'Ч', 251 => 'Ш', 253 => 'Щ', 255 => 'Ъ', 249 => 'Ы', 248 => 'Ь', 252 => 'Э', 224 => 'Ю', 241 => 'Я', 193 => 'а', 194 => 'б', 215 => 'в', 199 => 'г', 196 => 'д', 197 => 'е', 163 => 'ё', 214 => 'ж', 218 => 'з', 201 => 'и', 202 => 'й', 203 => 'к', 204 => 'л', 205 => 'м', 206 => 'н', 207 => 'о', 208 => 'п', 210 => 'р', 211 => 'с', 212 => 'т', 213 => 'у', 198 => 'ф', 200 => 'х', 195 => 'ц', 222 => 'ч', 219 => 'ш', 221 => 'щ', 223 => 'ъ', 217 => 'ы', 216 => 'ь', 220 => 'э', 192 => 'ю', 209 => 'я', 32 => 'space'
       );
       
       //list english character ASCII codes
       $english_ascii = $this->en_character_ascii();
       
       //merge russian and english letters ASCII codes
       $total_ascii = $russian_ascii + $english_ascii;
       
       //length of input string
       $len_string = strlen($string_in_rus_charset);
       
       /**
        * match input string with list allowed characters in array $russian_ascii
        * if input string has character is not in set of allowed characters return FALSE, otherwise TRUE
        */
       for( $i = 0; $i < $len_string; $i++ )
       {
           $ascii = ord($string_in_rus_charset{$i});
           if( array_key_exists($ascii, $total_ascii) === FALSE )
           {
               return FALSE;
           }
       }
       
       return TRUE;
   }
   
   /**
    * Generates array with ASCII codes of upper and lower case english characters
    * 
    * @return array An array ASCII codes for english characters key=>vlaue, where key is code and value is character
    */
   private function en_character_ascii()
   {
       $en_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $en_chars.= strtolower($en_chars);

       //number english alphabetic characters
       $number_chars = 52;
       
       $en_ascii = array();
       
       //create array of ascii english letters
       for( $i = 0; $i < $number_chars; $i++ )
       {
           $ascii = ord( $en_chars{$i} );
           $en_ascii[ $ascii ] = $en_chars{$i};
       }
       return $en_ascii;
   }
   
   /**
    * Matches input number phone on valid values
    * 
    * @param string $number_phone
    * @return boolean
    */
   public function correct_number_phone( $number_phone )
   {
       $allowed_characters = array(
            45 => '-', 48 => '0', 49 => '1', 50 => '2', 51 => '3', 52 => '4', 53 => '5', 54 => '6', 55 => '7', 56 => '8', 57 => '9', 32 => 'space'
       );
       
       //length entered number phone
       $length = mb_strlen($number_phone);
       for( $i = 0; $i < $length; $i++ )
       {
           $ascii = ord( $number_phone{$i} );
           if( array_key_exists($ascii, $allowed_characters) === FALSE )
           {
               return FALSE;
           }
       }
       return TRUE;
   }



    
}

