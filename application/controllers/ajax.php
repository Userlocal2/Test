<?php
session_start();

class Ajax extends CI_Controller {
	public $data       = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('adminModel');
		$this->load->library('admin_lib');
		$this->load->library('My_imagemagic');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INDEX
	public function index(){
		$data = $this->data;
		if(!isset($_SESSION['admin'])){
			header("HTTP/1.0 404 Not Found");
			echo 'error';
			exit;
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////______CLIENT
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function crop_process(){
		if(!isset($_POST['process'])){show_404('page');exit;}
		
		$this->load->library('crop_lib');
		$this->crop_lib->image();
		exit;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////GET_TEXTURA
	public function get_textura(){
		if(METHOD != 'POST'){show_404('page');exit;}
		$res = $this->db->query('SELECT id, name, eco, latex, uf, text FROM textura WHERE visibility = 1')->result();
		
		foreach($res as $k){
		  
	//print_r($k);          
			$arr = array();
			$dir = ROOT.'/img/textura/'.$k->id.'/';
            
/*echo $dir;
print_r($arr);*/

			if(!is_dir($dir)){echo json_encode($arr);exit;}
			
			$op_dir = opendir($dir);
			while($file = readdir($op_dir)){
			 
/*echo "<br>";
echo $file;   */          
				if(is_file($dir.$file)){
					$arr[] = str_replace(".jpg", "", $file); 
				}
			}
			$k->gallery = $arr;
		}
		
		echo json_encode($res);
       
		exit;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CALLBACK
	public function callback(){
		if(METHOD != 'POST'){show_404('page');exit;}
		$this->client_lib->callBack();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////FRIEND_MSG
	public function friend(){
		if(METHOD != 'POST'){show_404('page');exit;}
		$this->client_lib->friend_msg();
	}
        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_Order examples of textures        
        public function getExamples()
        {
            if(METHOD != 'POST'){show_404('page');exit;}
            $this->client_lib->orderTexture();
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_Send image to clients email. Activate by envelop under image in gallery
        public function yourSelect()
        {
            if(METHOD != 'POST'){show_404('page');exit;}
            $this->client_lib->sendImgToMail();
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_Send image to clients email. Activate by envelop in preview big image in gallery
        public function yourSelect1()
        {
            if(METHOD != 'POST'){show_404('page');exit;}
            $this->client_lib->sendImgToMail();
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_Counter amount of orders, when user clicks button ������� ����� � �������
        public function number_orders()
        {
            if(!isset($_POST['num_orders'])){show_404('page');exit;}
            $count = mysql_real_escape_string($_POST['num_orders']);
            $this->clientmodel->mCountOrders($count);
            exit;
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_order_some_img
        public function order_some_img()
        {
			if(!isset($_POST['order_some_img'])){show_404('page');exit;}
			$this->client_lib->orderSomeImg();
			exit;
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_Preview attachment interiors 
	public function getInterior()
	{
		/*if(!isset($_POST['articul'])){show_404('page');exit;}
		echo json_encode($this->clientmodel->getInteriorOfImage($_POST['articul']));*/
		exit;
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////______ADMIN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AUTH	
	private function valid(){
		if(!isset($_SESSION['admin'])){
			header("HTTP/1.0 404 Not Found");
			exit;
		}else{ 
			return true;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__VALID_TABLE
	private function valid_table($table = ''){
		$ex = false;
		
		$arr = $this->db->query('SHOW TABLES')->result();
		foreach($arr as $k){
			$k = (array)$k;
			if(in_array($table, $k)){
				$ex = true;
			}
		}
		return $ex;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////DEL
	public function del(){
		$this->valid();
		
		if(METHOD == 'POST'){
			$res = 0;
			
		
			switch($_POST['type']){
				case 'cat'        : $res = $this->adminModel->delCategory();break;
				case 'page'       : $res = $this->adminModel->delPage();break;
				case 'gallery_img': $res = $this->adminModel->delGallery((int)$_POST['id']);break;
				case 'arr_img'    : 
				
				foreach(json_decode($_POST['id']) as $k){
						$res = $this->adminModel->delGallery((int)$k);
					}
					break;
				case 'textura'     : $res = $this->adminModel->delTextura();break;
				case 'mural'       : $res = $this->adminModel->delMural();break;
				case 'interior'    : $res = $this->adminModel->delInterior();break;
				case 'subcategory' : $res = $this->adminModel->delSubcategory();break;
                case 'reviews'     : $res = $this->adminModel->delReview((int)$_POST['id']); break;
                case 'material'    : $res = $this->adminModel->delMaterial(); break;
			}
			echo json_encode($res);exit;
		}else{ redirect('/administrator');exit;}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VISIBILITY
	public function visibility(){
		$this->valid();
		
		if(METHOD == 'POST'){
			$table = mysql_real_escape_string(trim($_POST['table']));
			$v     = (int)$_POST['vis_'];
			$id    = (int)$_POST['id'];
			
			$v = $v == 1 ? 0 : 1;
			
			if(!$this->valid_table($table)){echo 'error';exit;}
			
			$res = $this->db->query('UPDATE '.$table.' SET visibility = '.$v.' WHERE id = '.$id);
			
			if($res){
				echo 0;
			}else{
				echo 'error';
			} 
			
		}else{ redirect('/administrator');}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TD_CLICK
	public function td_click(){
		$this->valid();
		
		if(METHOD == 'POST'){
			$add = '';
		
			$table  = trim(@$_POST['table']);
			$column = trim(@$_POST['column']);
			$text   = mysql_real_escape_string(trim(@$_POST['text']));
			$id     = @$_POST['id'];
			
			if(!$this->valid_table($table)){echo 0;exit;}
			
			if($id){
				$add .= ' WHERE id = '.$id.' ';
			}
			
			$this->db->query('UPDATE '.$table.' SET `'.$column.'` = "'.$text.'" '.$add);

			echo 1;exit;
		}else{
			redirect('/administrator');
			exit;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////UPLOADIFY
	public function uploadify(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(!isset($_POST['session'])){show_404();exit;}
			$arr = $this->db->query('SELECT * FROM  session_admin WHERE id_session = "'.$_POST['session'].'"')->row();
			if(!$arr){show_404();exit;}
			
			$this->load->library('my_uploadify');
			
			if(isset($_POST['images'])){
				$this->my_uploadify->multiUploadForPages();
				
			}elseif(isset($_POST['gallery'])){
				$this->my_uploadify->multiUpload();
				
			}elseif(isset($_POST['textura_gallery'])){
				$this->my_uploadify->multiUploadTextura();
			}
		}else{
			show_404();exit;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TMP_UPLOAD
	public function tmp_upload(){
		$this->valid();
//echo "dfkjhfkjdhkfjhkdf";


$t = trim($_POST['tmp_upload']);
        
        
		$file = $_FILES[$t];

		if($file['error'] == 0){
			$img = $this->my_imagemagic->base64($file['tmp_name'], 250, 100);
            
            
            
			echo '<script type="text/javascript">window.parent.end_upload(\'<img src="data:jpg;base64,'.$img.'">\');</script>';
		}
		exit;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SET_SORT
	public function set_sort(){
		$this->valid();
		
		if(METHOD == 'POST'){
			$table = trim($_POST['table']);
			$data = json_decode($_POST['sort']);
			
			foreach($data as $k){
				$res = $this->db->query('UPDATE '.$table.' SET `order`= '.$k->pos.' WHERE id = '.$k->id);
				if(!$res){echo 'error';exit;}
			}
			echo 0;
			exit;

		}else{ redirect('/administrator');exit;}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SET_HOME_PAGE
	public function sethomepage(){
		$this->valid();
		
		if(METHOD == 'POST'){
			$id = (int)$_POST['home'];
			
			if($id){
				$this->db->query('UPDATE pages SET type = "0" WHERE type = "home"');
				$res = $this->db->query('UPDATE pages SET type = "home" WHERE id = '.$id);
				if($res){
					echo 0;exit;
				}else{
					echo 'error';exit;
				}
			}else{
				echo 'error';exit;
			}
			exit;
		}else{ redirect('/administrator');exit;}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// SET VISIBILE OR INVISIBLE ALL IMAGES IN CURRENT CATEGORY       
	public function visible_or_invisible(){
		$this->valid();
		if(METHOD == 'POST'){
				$id_cat = (int)$_POST['id_cat'];
				$value = (int)$_POST['value'];
				$this->adminModel->hidden_all_images($id_cat, $value);
				redirect('/administrator/gallery/?id_cat='.$id_cat.'&view_gallery=0');
				exit;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// DEL TEXTURA GALLERY
	public function del_textura_gallery(){
		$this->valid();
		if(METHOD == 'POST'){
			$textura = (int)$_POST['textura'];
			$img = (int)$_POST['img'];
				@unlink(ROOT.'/img/textura/'.$textura.'/mini/'.$img.'.jpg');
			echo unlink(ROOT.'/img/textura/'.$textura.'/'.$img.'.jpg');
			exit;
		}
	}	

        public function send_review()
        {
            if(METHOD == 'POST')
            {
                $name = mysql_real_escape_string(trim($_POST['name_customer']));
                $review = mysql_real_escape_string(trim($_POST['text_review']));
                $phone = mysql_real_escape_string(trim($_POST['phone']));
                $email = mysql_real_escape_string(trim($_POST['email']));
                $date = time();
                
                $this->clientmodel->mInsertReviews($name, $review, $date, $phone, $email);
                
                $this->load->library('email');
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'mail.klever.dp.ua';
                $config['smtp_user'] = 'site@art-oboi.com.ua';
                $config['smtp_pass'] = 'site123';
                $config['smtp_port'] = 25;
                $config['smtp_timeout'] = 10;
                $this->email->initialize($config);
                $this->email->from('site@art-oboi.com.ua', 'Art-oboi');
                $this->email->to('tzud@klever.dp.ua');
                $this->email->cc('reviews@art-oboi.com.ua');
                $this->email->subject('Reviews');
                
                $msg = 'Новый отзыв от '.$name.': '.$email.': '.$phone;
                $msg.= "<br> Отзыв: ".$review;
                $this->email->message( $msg );
                $result = $this->email->send();
                
                if( $result )
                {
                    echo 'Спасибо, Ваш отзыв будет размещен после модерации';
                }
                else
                {
                    echo 'Во время отправки произошла ошибка, повторите попытку';
                }
                exit;
            }
        }
        
        public function UnsetNotification()
        {
            if( isset($_SESSION['dataNonValid']) )
            {
                unset($_SESSION['dataNonValid']);
            }
            return TRUE;
        }
}//END_CALSSS
