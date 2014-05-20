<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Cache-Control: no-store, no-cache, must-revalidate");
setlocale(LC_ALL, 'en_US.utf8');
session_start();

class Administrator extends CI_Controller {

	public $data       = array(
							'act'               =>'',
							'action'            =>'',
							'info'              =>'',
							'gallery'           =>array(),
							'gallery_name'      =>'',
							'cat_url'           =>'',
							'cat_id'            =>0,
							'cat_name'          =>'',
							'metadesc'          =>'',
							'metakey'           =>'',
							'title'             =>'',
							'text'              =>'',
							'all_category'      =>array(),
							'all_pages'         =>array(),
							'type_interior'     => array(),
							'all_interior'      => array(),
							'view_gallery'      =>0,
							'pagin'             =>'',
							'search'            =>array(),
							'images'            =>array()
						 );
	
	public function __construct(){
		parent::__construct();
		
		if(!isset($_SESSION['error'])){
			$_SESSION['error'] = '';
		}
		
		$this->load->model('adminModel');
		$this->load->library('admin_lib');
		$this->load->library('my_imagemagic');
		
		$this->data['all_category']    = $this->adminModel->getAllCategory();
		$this->data['all_pages']       = $this->adminModel->getAllPages();
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INDEX
	public function index(){
		$data = $this->data;
		
		if(!isset($_SESSION['admin'])){
			$this->load->view('admin/a_login');
			return;
		}
		
		$data['info']     = 'Администрация сайта: <b style="color:#000;">'.$_SERVER['SERVER_NAME'].'</b>';
		$data['cat']      = $this->adminModel->getStaticsCategory();																			
		$data['img']      = $this->adminModel->getStaticsGallery();
		$data['pages']    = $this->adminModel->getStaticsPages();
		
		$data['textura']  = $this->adminModel->getStaticsTextura();
		$data['interior'] = $this->adminModel->getStaticsInterior();
		
		$this->admin_lib->admin_view('a_home', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AUTH	
	public function login(){
		if(METHOD != 'POST'){ redirect('/administrator/');exit;}
		$this->adminModel->auth();
		redirect('/administrator/');exit;
	}
	public function logout(){
		session_destroy();
		redirect('/administrator/');
		exit;
	}
	private function valid(){
		if(!isset($_SESSION['admin'])){
			redirect('/administrator/');
			exit;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CATEGORY
	public function Category(){
		$this->valid();
		
		$data = $this->data;
		$data['action']  = 'category';
		$data['act']  = 'all';
		$data['info'] = 'Категории';
			
		if(METHOD == 'POST'){
			if(isset($_POST['edit'])){
				$res = $this->adminModel->updateCategory();
				redirect('/administrator/category');
				exit;
			}
			if(isset($_POST['add'])){
				$this->adminModel->addCategory();
				redirect('/administrator/category');
				exit;
			}
		}else{
			if(isset($_GET['update'])){
				$res = $this->adminModel->getCategory();
				if($res){
					$data['cat']  = $res;
					$data['act']  = 'update';
					$data['info'] = 'Редактирование категории';
				}
			}
			if(isset($_GET['add'])){
				$data['act']  = 'add';
				$data['info'] = 'Добавление категории';
			}
		}
		$this->admin_lib->admin_view('a_category', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////GALLERY
	public function Gallery(){ 
		$this->valid();
		
		$data = $this->data;
		$data['action']  = 'gallery';
		$data['info'] = 'Галерея';
		$data['act']  = 'all';
		
		$data['view_gallery'] = (int)@$_GET['view_gallery'];
		$data['hid']          = (int)@$_GET['hid'];

		if(isset($_GET['hidden'])){
			$data['info'] = 'Галерея - <b style="color:red;">все скрытые изображения</b>';
			$count = count($this->adminModel->getImgHidden());
			$page  = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;
			
			$data['pagin']   = $this->admin_lib->pagin($count, $page);
			$data['gallery'] = $this->adminModel->getGalleryHidden();
			
			$this->admin_lib->admin_view('a_gallery', $data);
			return;
		}
		
		if(isset($_GET['id_cat'])){
			$name = '';
			foreach($data['all_category'] as $k){
				if($k->id == $_GET['id_cat']){$name = $k->name;}
			}
			
			$data['cat_id']      = (int)$_GET['id_cat'];
			$data['subcategory'] = $this->adminModel->getSubcategory((int)$_GET['id_cat']);
			$data['info']        = 'Галерея - '.$name.($data['hid'] ? ' <b style="color:red;">скрытые изображения</b>' : '');
			
			if($data['hid']){
				$data['gallery'] = $this->adminModel->getGalleryHid();
				$this->admin_lib->admin_view('a_gallery', $data);
				return;
			}
			
			
			$count = $this->adminModel->getGalleryOfCategoryCount($data['cat_id']);
			$page  = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;
			$data['pagin'] = $this->admin_lib->pagin($count, $page);
			
			$data['gallery'] = $this->adminModel->getGalleryOfCategory($data['cat_id']);
		}
		
		if(METHOD == 'POST'){	
			if(isset($_POST['edit'])){
				$res = $this->adminModel->updateImage();
				redirect('/administrator/gallery/?id_cat='.(int)$_POST['id_cat']);
				exit;
			}
		}else{
			if(isset($_GET['update'])){
				$res = $this->adminModel->getImg((int)$_GET['update']);
				if($res){
					$data['image'] = $res;
					$data['act']   = 'update';
					$data['info']  = 'Редактирование изображения';
				}
			}
			if(isset($_GET['add'])){
				$data['act']  = 'add';
				$data['info'] = 'Добавить изображения';
			}
		}
		$this->admin_lib->admin_view('a_gallery', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SUBCATEGORY
	public function SubCategory(){ 
		$this->valid();
		
		if(METHOD == 'POST'){
			if(isset($_POST['subCategory'])){
				if($_POST['subCategory'] == 'all'){
					$res = $this->adminModel->getSubcategory((int)$_POST['id_gallery']);
					echo json_encode($res);
					exit;
				}
				if($_POST['subCategory'] == 'add'){
					$res = $this->adminModel->addSubcategory();
					echo 1;
					exit;
				}
			}
		}
		
		exit;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////PAGES
	public function Pages(){
		$this->valid();
		
		$data = $this->data;
		
		$data['action']         = 'pages';
		$data['act']            = 'all';
		$data['info']           = 'Редактирование стрниц';
		$data['typePages']      = $this->adminModel->getAllTypePages();
		$data['type']           = isset($_GET['getTypePages']) ? trim($_GET['getTypePages']) : 0;

		if(METHOD == 'POST'){
			if(isset($_POST['home'])){
				$this->adminModel->setHomePage((int)$_POST['home']);
				exit;
			}
			if(isset($_POST['add'])){
				$this->adminModel->addPage(); 
				redirect('/administrator/pages');
				exit;
			}
			if(isset($_POST['edit'])){
				$res = $this->adminModel->updatePage();
				redirect('/administrator/pages');
				exit;
			}
		}else{
			if(isset($_GET['update'])){
				$res = $this->adminModel->getPage((int)$_GET['update']);
				if($res){
					$data['page']  = $res;
					$data['act']  = 'update';
					$data['info'] = 'Редактирование страницы "<b style="color:red;">'.$res->name.'</b>"';
				}
			}
			if(isset($_GET['add'])){
				$data['act']  = 'add';
				$data['info'] = 'Добавление страницы';
			}
		}
		$this->admin_lib->admin_view('a_pages', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TEXTURA
	public function textura(){
		$this->valid(); 

		$data = $this->data;
		$data['action']  = 'textura';
		
		if(METHOD == 'POST'){
			if(isset($_POST['add'])){
				$this->adminModel->addTextura();
				redirect('/administrator/textura');
				exit;
			}
			if(isset($_POST['edit'])){
				$this->adminModel->editTextura();
				redirect('/administrator/textura');
				exit;
			}
		}
		
		if(isset($_GET['add'])){
			$data['act']      = 'add';
			$data['info']     = 'Добавление текстуры';
		}elseif(isset($_GET['update'])){
			$data['act']      = 'update';
			$data['info']     = 'Редактирование текстуры';
			$data['textura']  = $this->adminModel->getTextura((int)@$_GET['update']);
			
			//галерея текстур
			$arr = array();
			$dir = ROOT.'/img/textura/'.$data['textura']->id.'/';
			if(is_dir($dir)){
				$o_dir = opendir($dir);
				while($file = readdir($o_dir)){
					if(is_file($dir.$file)){
						$f = @getimagesize($dir.$file);
						if($f){
							$arr[] = str_replace(".jpg", "", basename($dir.$file)); 
						}
					}
				}
				sort($arr);
			}
			$data['textura']->example = $arr;
			
		}else{
			$data['act']      = 'all';
			$data['info']     = 'Текстуры';
			$data['textura']  = $this->adminModel->getTextura();
		}

		$this->admin_lib->admin_view('a_textura', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INTERIOR
	public function interior(){
		$this->valid();
		
		$data = $this->data;
		$data['action']  = 'interior';
		
		if(METHOD == 'POST'){
			if(isset($_POST['setArticul'])){
				$res = $this->adminModel->getGalleryArticul($_POST['setArticul']);
				if($res){
					$url = '/img/gallery/'.$res->id_cat.'/thumbs/thumb_m_'.$res->articul.'.jpg';
					echo $url;exit;
				}else{
					echo false;exit;
				}
				exit;
			}
			
			if(isset($_POST['typeInterior'])){
				if($_POST['typeInterior'] == 'all'){
					$res = $this->adminModel->getTypeInterior();
					echo json_encode($res);
					exit;
				}
				if($_POST['typeInterior'] == 'add'){
					$res = $this->adminModel->addTypeInterior();
					echo 1;
					exit;
				}
				if($_POST['typeInterior'] == 'del'){
					$res = $this->adminModel->delTypeInterior();
					echo 1;
					exit;
				}
			}
			
			
			if(@$_POST['AJtype'] == 'name' || @$_POST['AJtype'] == 'name_ua'){
				$pole = trim($_POST['AJtype']);
				$info = mysql_real_escape_string(trim(@$_POST['info']));
				$this->db->query('UPDATE type_interior SET '.$pole.' = "'.$info.'" WHERE id = '.@$_POST['id']);
				
				echo 1;
				exit;
			}
			
			
			if(isset($_POST['add'])){
				$this->adminModel->addInterior();
				redirect('/administrator/interior');
				exit;
			}
			if(isset($_POST['edit'])){
				$this->adminModel->updateInterior();
				redirect('/administrator/interior');
				exit;
			}
		}
		
		
		$data['act']           = 'all';
		$data['info']          = 'Интерьеры';
		$data['type_interior'] = $this->adminModel->getTypeInterior();
		$data['type']          = 0;
		
		if(isset($_GET['type_interior'])){
			$data['type'] = (int)$_GET['type_interior'];
			if(!empty($_GET['type_interior'])){
				$data['all_interior']  = $this->adminModel->getInteriorOfType((int)$_GET['type_interior']);
			}else{
				$data['all_interior']  = $this->adminModel->getInterior();
			}
		}else{
			if(isset($_GET['add'])){
				$data['act']  = 'add';
				$data['info'] = 'Добавить интерьер';
			}
			if(isset($_GET['update'])){
				$data['act']      = 'update';
				$data['info']     = 'Редактировать интерьер';
				$data['interior'] = $this->adminModel->getInterior((int)$_GET['update']);
			}else{
				$data['all_interior']  = $this->adminModel->getInterior();
			}
		}
		
		$count = count($data['all_interior']);
		$page  = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;
		$data['pagin']   = $this->admin_lib->pagin_interior($count, $page);
		
		$data['all_interior'] = $this->adminModel->getInteriorLimit($data['type']);
		
		$this->admin_lib->admin_view('a_interior', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INFO
	//настройка почты
	public function info(){
		$this->valid();
		
		$data = $this->data;
		$data['action']  = 'info';
		
		$res = $this->db->query('SELECT * FROM info');
		
		$data['act']  = 'all';
		$data['info'] = 'Редактирование почты';
		$data['inf']  = $res->row();

		$this->admin_lib->admin_view('a_info', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEARCH
	public function search(){
		$this->valid();
		
		$data = $this->data;
		$data['action']  = 'search';
		
		$search = mysql_real_escape_string(trim(@$_GET['search']));
		
		$data['info']        = 'Поиск';
		$data['search']      = $this->db->query('SELECT gallery.*, (SELECT name FROM category WHERE category.id = gallery.id_cat) AS cat_name FROM gallery WHERE articul = "'.$search.'"')->result();
		if(count($data['search'])){
			$data['subcategory'] = $this->adminModel->getSubcategory($data['search'][0]->id_cat);
		}
		
		$this->admin_lib->admin_view('a_search', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////IMAGES
	public function images(){
		$this->valid();
		
		$data = $this->data;
		$data['action'] = 'images';
		$data['info']   = 'Изображения для страниц';
		
		if(isset($_GET['del'])){
			@unlink(ROOT.'/img/for_page/'.trim($_GET['del']));
			@unlink(ROOT.'/img/for_page/mini/'.trim($_GET['del']));
			redirect('/administrator/images');exit;
		}
		
		if(isset($_GET['add'])){
			$data['act']    = 'add';
		}else{
			$data['act']    = 'all';
			$a = '';
			$dir = ROOT.'/img/for_page/';
			$op_dir = opendir($dir);
			while($file = readdir($op_dir)){
				if(is_file($dir.$file)){
					$arr = getimagesize($dir.$file);
					$a['url']    = basename($dir.$file);
					$a['width']  = $arr[0];
					$a['height'] = $arr[1];
					$a['size']   = filesize($dir.$file);
					$data['images'][] = (object)$a;
				}
			}
		}
		
		$this->admin_lib->admin_view('a_images', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////UPDATE ALT IMAGES
    public function updateAltImages()
    {
        $this->valid();
        $data['action'] = 'update_alt';
        $data['info'] = 'Обновление описания картинок в галереe';

        if(METHOD == 'POST')
        {
            $params = array('filename'=>$_FILES['file_update_alt']['name'], 'path_to_tmp_file'=>$_FILES['file_update_alt']['tmp_name'], 'extension_file'=>$_FILES['file_update_alt']['type']);
            try{
                $this->load->library('UpdateAltOfImages', $params);
                $data['result_update'] = $this->updatealtofimages->updateDBAltOfImage();
            }
            catch (Exception $e)
            {
                $data['result_update'] = $e->getMessage();
            }
            
            redirect('/administrator/updateAltImages?result_update='.$data['result_update'].' ');exit;
        }
       
        $this->admin_lib->admin_view('a_update_alt', $data);
    }
    /*
     * Download data from DB.
     * Does selection all data from table gallery by id_cat
     * 
     * @param int id_cat - identificator of current category, get from $_POST['id_cat']
     * @param array data_alt - contains all fields from table gallery
     * @param string name_file - name of file for alt description of images
     */
    public function c_downloadAlt()
    {
        $this->valid();
        
        if(METHOD == 'POST')
        {
            $id_cat = $_POST['id_cat'];
            $data_alt = $this->adminModel->m_downloadAlt((int)$id_cat);
            $name_file = 'files/data_alt.csv';
            $handle = fopen($name_file, 'w+');
            foreach ($data_alt as $val)
            {
                fputcsv($handle, $val, ',');
            }
        }
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////LOADING IMAGES FOR SALE    
    public function loading_sale_images()
    {
        $this->valid();
        $data['info'] = 'Загрузка изображений для распродажи';
        if(METHOD == 'POST'){
            if(!is_dir('/img/sale')){
                mkdir('img/sale', '0777');
            }
			
            $file = $_FILES['image'];
			
            $this->my_imagemagic->resize($file['tmp_name'], 'img/sale/'.$file['name'], 282, 100);
            $this->adminModel->mloading_sale_images();
            
			redirect('/administrator/loading_sale_images');
			
        }else{
            if(isset($_GET['add'])){
                $data['act'] = 'add';
            }
            elseif(isset ($_GET['edit'])){
                $data['act'] = 'edit';
                $data['sale'] = $this->adminModel->medit_sale_images((int)$_GET['edit']);
            }elseif(isset ($_GET['del'])){
                $this->adminModel->mdelete_sale_image((int)$_GET['del']);
                unlink('img/sale/'.(int)$_GET['article'].'.jpg');
                redirect('/administrator/loading_sale_images');
            } else{
                $data['sale'] = $this->adminModel->mloading_sale_images();
            }
        }
        $this->admin_lib->admin_view('a_loading_sale_images',$data);
    }	
    
    /******************** Ivan 23.07.2013 **************/
    public function ParsingInputData($client_name, $text,  $create_date = 0, $pub_date = 0, $commit_value = 0, $phone = 'none', $email = 'none', $answer = '')
    {
        //Name of client
        $name = trim($client_name);
        //$name = htmlspecialchars($name);

        //Review of client
        $review = trim($text);
       // $review = htmlspecialchars($review);

        //date of creation review
        $create_date = trim($create_date);
       // $create_date = htmlspecialchars($create_date);
        
        //date of publication review
        $pud_date = trim($pub_date);
       // $pub_date = htmlspecialchars($pub_date);

        //commit value
        $commit_value = trim( $commit_value );
       // $commit_value = htmlspecialchars($commit_value);
        
        //client phone and email
        $phone = trim($phone);
        $email = trim($email);
        
        //answer on the reviews
        $answer = trim($answer);
        
        //return all available inputed data
        return array('client_name' => $name, 'review' => $review, 'date_creation' => (int)$create_date, 'date_publication' => (int)$pub_date, 'value_of_commit' => (int)$commit_value, 'phone' => $phone, 'email' => $email, 'answer' => $answer);
    }
    /**************** Ivan 30.07.2013 ******************/
    public function Reviews()
    {
        $this->valid();
        $data['action'] = 'reviews';
        $data['info'] = 'Редактирование отзывов клиентов';
        
        if(METHOD == 'POST')
        {   
            //Addition new review
            if( isset($_POST['add']) && !empty($_POST['client_name']) && !empty($_POST['text']) )
            {
                //call method, that prepares inputed values for DB
                $data_for_addition = $this->ParsingInputData($_POST['client_name'], $_POST['text'], $_POST['create_date'], $_POST['create_date'], $_POST['commit_value'], $_POST['phone'], $_POST['email']);
               
                //call model method, which writes new review about art-oboi
                $this->adminModel->AddNewReview($data_for_addition);
                redirect('/administrator/reviews');
            }
            elseif( isset($_POST['edit']) && !empty($_POST['client_name']) && !empty($_POST['text']) )
            {
                //call method, that prepares inputed values for DB
                $data_for_editing = $this->ParsingInputData($_POST['client_name'], $_POST['text'], $_POST['pub_date'], 0, 0, $_POST['phone'], $_POST['email'], $_POST['answer']);
                
                //send changed data of review
                $id = htmlspecialchars($_POST['id']);
                $this->adminModel->EditReview($data_for_editing, (int)$id);
                redirect('/administrator/reviews');
            }
            else
            {
                redirect('/administrator/reviews');
            }
        }
        //this block executes when isset method $_GET
        else
        {
            //Fetch all reviews by default.
            if( !isset($_GET['action']) )
            {
                //fetch all comment's clients
                $data['all_reviews'] = $this->adminModel->GetAllReviews();
                
                //transform from Unix timestamp formats to day-month-year
                foreach ($data['all_reviews'] as $value)
                {
                    if($value->create_date)
                    {
                        $date = getdate($value->create_date);
                        $value->create_date = $date['mday'].'-'.$date['mon'].'-'.$date['year'];
                    }
                    if($value->pub_date)
                    {
                        $date = getdate($value->pub_date);
                        $value->pub_date = $date['mday'].'-'.$date['mon'].'-'.$date['year'];
                    }
                }
                
                //output all comments to view
                $this->admin_lib->admin_view('review/a_reviews', $data);
                return FALSE;
            }
            //when $_GET['action'] isset, execute matched action
            switch ($_GET['action'])
            {
                case 'edit' :
                            //preparing id given by $_GET['id'] for selection data from table;
                            $comment_id = trim($_GET['id']);
                            $comment_id = mysql_real_escape_string($comment_id );

                            //call adminmodel's method, which fetch one comment by ID
                            $data['reviewer'] = $this->adminModel->GetCommentById($comment_id);

                            //show edit view
                            $this->admin_lib->admin_view('review/a_reviews_edit', $data);
                            return FALSE;
                case 'add' :
                            //show add view
                            $this->admin_lib->admin_view('review/a_reviews_add', $data);
                            return FALSE;
            }
        }
        
        //$this->admin_lib->admin_view('review/a_reviews', $data);
    }
	
}//END_CLASSS
