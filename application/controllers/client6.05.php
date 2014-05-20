<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
//session_destroy();exit;
class Client extends CI_Controller {
	public $seg  = array();
	public $data = array(
						'US'               =>array(),
						'child'			   =>array(),
						'canonical'        =>'',
                                                'nobots'           => '',
                                                'nofollow'         => '', 
						'colors'           =>array('red'=>'красный', 'orange'=>'оранжевый', 'yellow'=>'желтый', 'green'=>'зеленый', 'azure'=>'голубой', 'blue'=>'синий', 'violet'=>'фиолетовый', 'pink'=>'розовый', 'white'=>'белый', 'grey'=>'серый', 'black'=>'черный', 'brown'=>'коричневый'),
						'view_count'       =>array(60, 120, 150, 198),
						'count'            =>0,
						'pagin'            =>'',
						'name'             =>'',
						'subcategory'      =>array(),
						'subcat_id'        =>0,
						'subcat_name'      =>'',
						'cat_url'          =>'',
						'cat_id'           =>'',
						'cat_name'         =>'',
						'cat'              =>'',
						'metadesc'         =>'',
						'metakey'          =>'',
						'title'            =>'',
						'text'             =>'',
						'all_category'     =>'',
						'all_subcategory'  =>'',
						'all_pages'        =>'',
						'subcategory'      =>array(),
						'search'           =>'',
						'view_client'      =>'',
						'gallery'          =>array(),
						'lang'             =>'',
						'name_as_h1'       =>'',
						'favorit'          =>array()
						 );
    private $idAccount  = '301039';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CONSTRUCT
	public function __construct(){
	   
       
       
		parent::__construct();
		//determine whether client IP blocked
        
        
                $blockedIP = $this->clientmodel->GetBlockedIP( $_SERVER['REMOTE_ADDR'] );
                if( $blockedIP === TRUE )
                {
                    echo 'Your IP address is blocked';
                    exit;
                }
		if(isset($_POST['type'])){
			if($_POST['type'] == 'crop'){
				$this->load->library('crop_lib');
				$this->crop_lib->image();
			}
		}



		$lang = $this->uri->segment(1);
		$this->seg = explode('/', $this->uri->uri_string());
        $this->data['phone'] = $this->db->get('info')->row();
        
        
        
        
        $categories = file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/categories/');
        $categories = json_decode($categories);
        
        
        
        
      //  var_dump($categories->data);die;
		$this->data['all_category']    = $categories->data;
		$this->data['all_pages']       = $this->clientmodel->getAllPages();
		$this->data['i']               = $this->clientmodel->getInfo();
		$this->data['favorit']         = $this->clientmodel->getFavorit();

		if(!isset($_SESSION['view_count'])){ $_SESSION['view_count'] = 120;}
		if(!isset($_SESSION['sort']))      { $_SESSION['sort']       = 'popular';}
		if(!isset($_SESSION['hor']))       { $_SESSION['hor']        = '';}
		if(!isset($_SESSION['old_subcat'])){ $_SESSION['old_subcat'] = 0;}//объявляем для сравнения был ли переход в другую подкатегорию , чтобы сбросить фильтры
		if(!isset($_SESSION['img_title'])) { $_SESSION['img_title']  = 0;}
		if(!isset($_SESSION['search']))    { $_SESSION['search']     = '';}
		if(!isset($_SESSION['next']))      { $_SESSION['next']       = 1;}
                
                /* Ivan 22.07.2013 */
                /*$params = array('smtp_server' => 'rdp.klever.dp.ua');
                $this->load->library('pinghost', $params);
                $this->data['smtp_server_name'] = $this->pinghost->InitCURLSession();*/
                $this->load->helper('file');
                $this->load->helper('email');
                $this->load->helper('captcha');
                $this->load->library('antispam');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__INDEX
	private function info($obj){


echo "eto funtion info";
	   
       
		$arr['name']       = $obj->name;
		$arr['metadesc']   = $obj->metadesc;
		$arr['metakey']    = $obj->metakey;
		$arr['title']      = $obj->title;
		$arr['text']       = $obj->text;
		
		$arr['parent_url']  = isset($obj->parent_url) ? $obj->parent_url : '';
		$arr['parent_name'] = isset($obj->parent_name) ? $obj->parent_name : '';
		
		$arr['name_as_h1'] = @$obj->name_as_h1;

		return $arr;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__INDEX
	public function index($dat = array())
	{

//echo "funct index";
$data = $this->data;



/*vstavka_dlia_bd*/

/*echo "<pre>";
//print_r($data['all_category']);
echo "</pre>";
*/

/*$this->load->model('m_user_date');
$data = $this->m_user_date->user_valid();       */          

$dat = $this->clientmodel->getBigstockCat($data);

//print_r($dat);

$data['bd_sel_cat'] = $dat;  
                
/*end_vstavka_dlia_bd*/ 

                
   
$k = $this->clientmodel->getHomePage();
		//	$data = array_merge($data, $this->info($k));                   


$data['k'] = $k; 
                   
$category = new stdClass;
$category->name = 'Designer murals';                                          
$data['all_category'][] = $category;
sort($data['all_category']);
                
//print_r($category);                

               
	
    	$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'"/>';
 
		if(empty($this->seg[0])){
			$k = $this->clientmodel->getHomePage();
			//$data = array_merge($data, $this->info($k));
		}else{
		
        
foreach($data['all_category'] as $k){
/*echo "<pre>";			 
print_r($k->name);
echo "</pre>";
  */           
             
//print_r($this->seg[0]);                                                            				









if(strtolower($k->name).'.html' == $this->seg[0])
//if(strtolower($k->name).'.html' == $this->seg[0])                
{
					$this->data['cat_id'] = $k->name;
					$this->category($k->name);
					return;
}
}

			if($this->seg[0] == 'crop-image'){
     
     
     //print_r($this->input);         
                $idImg = $this->input->get('title', true);
                
				$this->crop((int)$idImg);
                
                
				return;
			}
            
            
			if($this->seg[0] == 'preview-interior'){
				$this->interior();
				return;
			}
			if($this->seg[0] == 'color'){
				$this->color();
				return;
			}
			if($this->seg[0] == 'texture-photooboi.html'){
				$this->textura();
				return;
			}
			if($this->seg[0] == 'texture-murals.html'){
				$this->freska();
				return;
			}
			if($this->seg[0] == 'popular-wallpapers.html'){
				$this->popular();
				return;
			}
			/*if($this->seg[0] == 'new-wallpapers.html'){
				$this->newimages();
				return;
			}*/
			if($this->seg[0] == 'photooboi-interior.html'){
				$this->photo_interior();
				return;
			}
			if($this->seg[0] == 'order'){
				$this->order();
				return;
			}
			
			if($this->seg[0] == 'search'){
				$this->search();
				return;
			}
			if($this->seg[0] == 'tag'){
				$this->tag();
				return;
			}
			
			if($this->seg[0] == 'karta-sajta.html'){
				$this->sitemap();
				return;
			}
                         if($this->seg[0] == 'reviews.html'){
				$this->reviews();
				return;
			}
                        
			foreach($data['all_pages'] as $k){
			 
//print_r($data['all_pages']);             
             
             
             
				if($k->url.'.html' == $this->seg[0]){
                                        
					$this->pages($k);
					return;
				}
			}

			show_404('page');exit;
		}





//print_r($data);

$this->client_lib->client_view('home', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CATEGORY
public function category($urlCategory,$dat = array(),$urll=array(),$datt=array(), $kol=array())
	{
$data   = $this->data;
//print_r('c'.$urlCategory);



$urll = $urlCategory;
/* вывод всех фоток из базы*/

$kol = $this->clientmodel->m_sel_kol($urll);

//print_r($kol);
$data ['kolll'] = $kol;



if (isset($_GET['nex']))

{
$nex_start = $_GET['nex_start'];
$nex = $_GET['nex'];
}
else {
$nex_start = '0';
$nex = '60';            
}



$datt = $this->clientmodel->m_sel_all($urll,$nex,$nex_start);


//print_r($datt['select_fhot_cate']);
/*echo "<pre>";
var_dump ($datt);

echo "</pre>";*/






$data['sel_phot'] = $datt['select_fhot_cate'];


if (($datt['select_fhot_cate'] > 0)){
//echo "Картинки из базы";            
} else {    
  // echo "Картинки из bigstock";      
}





        /*if (isset($_GET['chpage'])) {
            redirect();
            exit;
        }*/
//print_r($data);
$dat = $this->clientmodel->getBigstockCat($data);



$data['bd_sel_cat'] = $dat;
$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$this->uri->uri_string().'"/>';

        
        if(METHOD == 'POST'){
		  
			if(isset($_POST['view_count'])){
				$_SESSION['view_count'] = (int)$_POST['view_count'];
			}
            
            
			if(isset($_POST['sort'])){
				$_SESSION['sort'] = $_POST['sort'];
			}
			if(isset($_POST['hor'])){
				$_SESSION['hor'] = $_POST['hor'];
			}
            if (isset($_POST['chpage']) && !empty($_POST['page'])) 
            {                                            
//var_dump($urlCategory);
//print_r(strtolower($urlCategory));



$data ['catggg'] = $urlCategory;

                
$images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&order='.$_SESSION['sort'].'&limit='.$_SESSION['view_count'].'&orientation='.$_SESSION['hor'].'&page='.@$_GET['page'].'&exclude=icons');
$images = json_decode($images);



//print_r($images->data->paging->total_pages);
               
                if ((int)$_POST['page'] > $images->data->paging->total_pages) {
                    echo 'fail';
                    exit;
                }
                echo '/'.$this->uri->uri_string().'?page='.$_POST['page'];
                exit;
            }
			redirect($this->uri->uri_string());
			exit;
		}
        
        
        
        
        


$images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&order='.$_SESSION['sort'].'&limit='.$_SESSION['view_count'].'&orientation='.$_SESSION['hor'].'&page='.@$_GET['page'].'&exclude=icons');


        
        if ($images === false) {
$images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&page=1&exclude=icons');
        }

        $images = json_decode($images);
        
        
        $data['firstPage']  = $this->seg[0];
        $data['lastPage']   = array(
            'number'    => $images->data->paging->total_pages,
            'link'      => $this->seg[0] . '?page=' . $images->data->paging->total_pages,
        );
        $data['pagin']      = $images->data->paging;
        $data['gallery']    = $images->data->images;
            
            
            if ($images->data->paging->page == 1) {
                $data['prev'] = false;
            } else {
                $prev = $images->data->paging->page - 1;
                $data['prev'] = '/'.$this->seg[0] .'?page='.$prev;
            }
            
            
            
            if ($images->data->paging->page == $images->data->paging->total_pages) {
                $data['next'] = false;
                
                
            } else {
                $next = $images->data->paging->page + 1;
                $data['next'] = '/'.$this->seg[0] .'?page='.$next;
            }    


$this->client_lib->client_view('gallery', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__ORDER
	public function order()
	{
		$data = $this->data;


$dat = $this->clientmodel->getBigstockCat($data);



$data['bd_sel_cat'] = $dat;

	
   


			if(METHOD == 'POST'){
            $data['post']  = $_SESSION['post'];
            $idImg = $this->input->post('num_img', true);
            
            $jsonData = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/image/'.$idImg);
           
           
           
           
           
            if ($jsonData === false) {
                $data['image'] = new stdClass();
                $data['image']->id = 1;
            } else {
                $image = json_decode($jsonData);
                $data['image'] = $image->data->image;
                $_SESSION['img'] = $image->data->preview->url;
            }
            
			if(isset($_POST['order'])){
                //$isValidData = $this->antispam->ValidationData();


$isValidData = 1;

                if( $isValidData == 1 )
                {
                    //clear notification about incorrect data
                    unset($_SESSION['dataNonValid']);

                    $numberOrder = $this->antispam->FetchLatestOrder();
                    
                    if( 0 && $numberOrder >= 5 )
                    {
                        $this->antispam->BlockIP();
                    }
                    elseif( 0 && $numberOrder >= 3 && $numberOrder < 5 )
                    {
                        
                        
                        //$isCorrectCapthca = $this->antispam->isCorrectCaptcha();
                        
                        $isCorrectCapthca = 1;
                        if( $isCorrectCapthca )
                        {
                            $this->antispam->CommitNewOrder();
                            $this->client_lib->order();
                            redirect($data['lang'].'/order');
                            exit;
                        }
                        else
                        {
                            redirect($data['lang'].'/crop-image/title/?idd='.@$_POST['num_img']);
                            exit;
                        }
                    }
                    else
                    {
                        $this->antispam->CommitNewOrder();
                        $this->client_lib->order();
                        redirect($data['lang'].'/order');
                        exit;
                    }
                }
                else
                {
                    redirect($data['lang'].'/crop-image/title/?idd='.@$_POST['num_img']);
                    exit;
                }
			}
		}

		if(!@$_SESSION['post']){redirect('/');exit;}

		//$data['order'] = $this->clientmodel->getImageGallery($_SESSION['order']);
        $data['image'] = $_SESSION['img'];
        /*if ($_SERVER['QUERY_STRING']=='test') {
            var_dump($_SESSION['order_id']);
            $r=$this->db->query('SELECT * FROM lib_order_info WHERE id='.(int)$_SESSION['order_id']);
            //$r=$this->db->query('SHOW TABLES;');
            echo "<pre>";
            var_dump($r->result());
            echo "</pre>";
        }*/

        $data['order'] = $this->clientmodel->getOrder($_SESSION['order_id']);
        $data['order_id'] = $_SESSION['order_id'];
        

        // !!! после тестирования раскомметировать ниже !!!
		/*$_SESSION['order'] = '';
		$_SESSION['post']  = '';
        $_SESSION['order_id']='';
        $_SESSION['order_amount']='';*/

		$this->client_lib->client_view('order', $data);

	
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CROP-IMAGE
	public function crop($idImg)
	{
		$data = $this->data;
//print_r($data);

//echo $idImg;

//print_r($_GET["idd"]);

$dat = $this->clientmodel->getBigstockCat($data);



$data['bd_sel_cat'] = $dat;

/*Принял переменную гетом, старая не работала. Присвоил старой переменной полученный гет */
$id_imm = $_GET["idd"];

$idImg = $id_imm; 





		if(METHOD == 'POST'){
		  
			if(isset($_POST['order'])){
//print_r($_POST['order']);			 


             
$this->client_lib->order();
                
				exit;
			}
		}
        
        //$jsonData = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/image/'.$idImg);
        $jsonData = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/image/'.$idImg);
        
        
        
        if ($jsonData === false) {
            $data['image'] = new stdClass();
            $data['image']->id = 1;
        } else {
            $image = json_decode($jsonData);
            $data['image'] = $image->data->image;
        }
        
        //var_dump($data['image']);
		$data['textura'] = $this->clientmodel->getTextura();
		
        /**
         * call captcha method
         */
        $showCaptcha = $this->antispam->ShowCapthca();
        $data['onCaptcha'] = $showCaptcha['onCaptcha'];
        $data['capthca_img'] = $showCaptcha['capthca_img'];





                
		$this->client_lib->client_view('crop-image', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__INTERIOR
	public function interior()
	{
		$data = $this->data;

		$k = $this->clientmodel->getPage(83);
		//$data = array_merge($data, $this->info($k));

		$title = mysql_real_escape_string(trim(@$_GET['title']));

		$data['gallery'] = $this->clientmodel->getImageGallery($title);
            if(!empty($data['gallery']->title_image) || !empty($data['gallery']->title_image_ua))
            {
               $data['title'] = LANG == 'ua' ? 'Перегляд фотошпалер "'.$data['gallery']->title_image_ua.'" в інтер\'єрі - Арт-шаплери' : 'Просмотр фотообоев "'.$data['gallery']->title_image.'" в интерьере - Арт-обои';
            }


		//$min_element = $this->db->query('SELECT articul = ');

		$img_before = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul<"'.$title.'" LIMIT 3')->result();


		/*
		*	Выполняем условию данного оператора, при выборе первых трех записей с БД (картинки, который идут первыми при сортировке по тайтлу по убыванию)
		*	Т.е. увеличиваем общее число недостающих превьюшек до 7
		*
		*/
		switch(count($img_before))
		{
			case 0:
				$img_after = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul>"'.$title.'" ORDER BY articul ASC LIMIT 6')->result();
				break;
			case 1:
				$img_after = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul>"'.$title.'" ORDER BY articul ASC LIMIT 5')->result();
				break;
			case 2:
				$img_after = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul>"'.$title.'" ORDER BY articul ASC LIMIT 4')->result();
				break;
			default:
				$img_after = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul>"'.$title.'" ORDER BY articul ASC LIMIT 3')->result();
		}
		/*
		*	Выполняем условию данного оператора, при выборе последних трех записей с БД (картинки, который идут первыми при сортировке по тайтлу по убыванию)
		*	Т.е. увеличиваем общее число недостающих превьюшек до 7
		*
		*/
		switch(count($img_after))
		{
			case 0:
				$img_before = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul<"'.$title.'" ORDER BY articul DESC LIMIT 6')->result();

				break;
			case 1:
				$img_before = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul<"'.$title.'" ORDER BY articul DESC LIMIT 5')->result();

				break;
			case 2:
				$img_before = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul<"'.$title.'" ORDER BY articul DESC LIMIT 4')->result();

				break;
			default:
				$img_before = $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$data['gallery']->id_cat.' AND articul<"'.$title.'" ORDER BY articul DESC LIMIT 3')->result();
		}



		$img_current = $this->db->query('SELECT * FROM gallery WHERE articul="'.$title.'" LIMIT 1')->result();

		$total = array_merge(array_reverse($img_before), $img_current);
		$total = array_merge($total, $img_after);

		$data['img'] = $total;

		$this->client_lib->client_view('interior', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__PHOTO_INTERIOR
	public function photo_interior()
	{
		$data = $this->data;

		if(isset($_GET['type'])){
			$_SESSION['type_interior'] = (int)$_GET['type'] < 0 ? 0 : (int)$_GET['type'];
			redirect($data['lang'].'/photooboi-interior.html');
			exit;
		}else{
			$_SESSION['type_interior'] = isset($_SESSION['type_interior']) ? @$_SESSION['type_interior'] : 0;
		}

		$obj = $this->clientmodel->getPage(87);
		//$data = array_merge($data, $this->info($obj));

		$data['type_interior'] = $this->clientmodel->getTypeInterior();

		$page  = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;
		$count = $this->clientmodel->getCountInterior();

		$data['interior'] = $this->clientmodel->getInterior($page);
		$data['pagin']    = $this->client_lib->pagin_interior($count, $page, $data);
		
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$obj->url.'.html"/>';
		
		$this->client_lib->client_view('photo_interior', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__PAGE
	public function pages($obj)
	{
            
		$data = $this->data;




$dat = $this->clientmodel->getBigstockCat($data);

//print_r($dat);

$data['bd_sel_cat'] = $dat; 


		if($obj == null){ show_404('page');exit;}
        
        
		$obj = $this->clientmodel->getPage($obj->id);
    /*    echo "<pre>";
        print_r($obj);
        echo "</pre>";
        
      */  
        
        
        
        
        
		//$data = array_merge($data, $this->info($obj));
		//проверка есть ли потомки
		foreach($data['all_pages'] as $k){
			if($obj->id == $k->id_parent && $obj->url != 'contacts'){
				$data['child'][] = $k; 
			}
		}
		
		/**
                 * Build pagination buttons if page has nested articles
                 */
                //links' button pagination
                $paginationLinks = '';
                
                if( count( $data['child'] ) != 0 )
                {
                    //sort articles by date create 
                    rsort($data['child']);
                    
                    //count pagination buttons on the page
                    $countElementsOnPage = 7;
                    $data['countElementsOnPage'] = $countElementsOnPage;
                    
                    //determine amount of nested articles for current page 
                    $totalAmountChildArticles = count( $data['child'] );
                   
                    //computation amount of pagination buttons
                    $amountButtons = ceil( $totalAmountChildArticles / $countElementsOnPage );
                    
                    //determie whether is set $_GET and it is digit or not
                    $legalGetParam = isset( $_GET['page'] ) && ctype_digit( $_GET['page'] );

                    //determine whether $_GET['page'] is not 0 and max value $_GET['page'] is not more then maximum value pagination buttons
                    $allowedPageOffset =  ( @$_GET['page'] != 0 ) && ( @$_GET['page'] <= $amountButtons );
                    
                    //set offset initial page
                    $offsetPage = 0;
                    if( $legalGetParam && $allowedPageOffset )
                    {
                        $offsetPage = ( (int)$_GET['page'] * $countElementsOnPage ) - $countElementsOnPage;
                    }
                    //set offset initial page
                    $data['offsetPage'] = $offsetPage;
                    
                    //build a string with pagination buttons
                    for( $i = 1; $i <= $amountButtons; $i++ )
                    {
                        if( !isset( $_GET['page'] ) && $i == 1 )
                        {
                            $paginationLinks.= "<span>{$i}</span>";
                            continue;
                        }
                        elseif( isset( $_GET['page'] ) && $i == 1 )
                        {
                            $paginationLinks.= "<a href='{$obj->url}.html'>{$i}</a>";
                            continue;
                        }
                        elseif( $i == @$_GET['page'] )
                        {
                            $paginationLinks.= "<span>{$i}</span>";
                            continue;
                        }
                        else
                        {
                            $paginationLinks.= "<a href='{$obj->url}.html?page={$i}'>{$i}</a>";
                        }
                    }
                    
                }
                
                $data['pagin'] = $paginationLinks;
                


$data['obj']= $obj;                
                
                
                
                $data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$obj->url.'.html"/>';
                
                
                
                
                
               
		$this->client_lib->client_view('page', $data);
	}
        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__COLOR
	public function color()
	{
		$data = $this->data;
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$this->uri->uri_string().'" />';
		$data['color']     = '';
		$arr = array(
						'red' => array('title'=>'Фотообои красные купить в интернет-магазине art-oboi.com.ua', 'desc'=>'Купите фотообои красные в Украине по доступным ценам. Разнообразные изображения, выполненные в красных тонах придадут яркости и красочности Вашей комнате. Широкий ассортимент в интернет-магазине art-oboi.com.ua.'), 
						'orange' => array('title'=>'Фотообои оранжевые: яркие решения для дома и офиса. Купить в art-oboi.com.ua', 'desc'=>'Фотообои оранжевые. Широкий ассортимент фотообоев, выполненных во всех оттенках оранжевого цвета. Доступные цены, доставка по России.'),  
						'yellow' => array('title'=>'Фотообои желтые по выгодным ценам в интернет-магазине art-oboi.com.ua', 'desc'=>'Приобретите яркие и красочные желтые фотообои по низким ценам в Украине. Создайте солнечное настроение благодаря art-oboi.com.ua.'), 
						'green' => array('title'=>'Фотообои зеленые на стену купить в интернет-магазине art-oboi.com.ua', 'desc'=>'Купите зеленые фотообои по доступным ценам. Мы предалагаем широкий ассортимент зеленых фотообоев различной тематики. Доставка по России.'), 
						'azure' => array('title'=>'Фотообои голубые купить в Украине. Низкие цены в нтернет-магазине art-oboi.com.ua', 'desc'=>'Фотообои голубые на любой вкус в ассортименте. Разнообразная тематика и изображения в голубых тонах. Купите по доступным ценам в интернет-магазине art-oboi.com.ua'), 
						'blue' => array('title'=>'Фотообои синие, голубые по доступным ценам в Украине. Купить в art-oboi.com.ua', 'desc'=>'Голубые и синие фотообои на любой вкус в ассортименте. Разнообразная тематика и изображения в синих тонах. Купите по доступным ценам в интернет маназине art-oboi.com.ua'), 
						'violet' => array('title'=>'Фотообои фиолетовые купить в Украине — интернет-магазин art-oboi.com.ua', 'desc'=>'Фотообои фиолетовые в широком ассортименте. Купите фиолетовые фотообои для Вашего помещения в art-oboi.com.ua по доступным ценам.'), 
						'pink' => array('title'=>'Фотообои розовые. Купить в art-oboi.com.ua по выгодным ценам', 'desc'=>'Купите фотообои розовые по доступным ценам в Украине. Широкий ассортимент фотообоев в розовых тонах в интернет-магазине art-oboi.com.ua.'), 
						'white' => array('title'=>'Фотообои белые по доступным ценам в интернет-магазине art-oboi.com.ua', 'desc'=>'Приобретите белые фотообои самых разнообразных тематик. Широкий ассортимент в интернет-магазине art-oboi.com.ua.'), 
						'grey' => array('title'=>'Фотообои серые в различных тонах в интернет-магазине art-oboi.com.ua', 'desc'=>'Закажите фотообои серые для Вашего дома или офиса в интернет-магазине art-oboi.com.ua по доступным ценам.'), 
						'black' => array('title'=>'Фотообои черные. Фотообои, темных тонов по доступным ценам', 'desc'=>'Фотообои черные в широком ассортименте в интернет-магазине art-oboi.com.ua. Доступные цены, быстрая доставка по России.'),  
						'brown' => array('title'=>'Фотообои коричневые купить в Украине. Низкие цены в art-oboi.com.ua', 'desc'=>'Приобретите с доставкой коричневые фотообои различной тематики: фрески. города, архитектура и другие. Доступные цены и широкий ассортимент в интернет-магазине art-oboi.com.ua')
					);

		if(METHOD == 'POST'){
			if(isset($_POST['view_count'])){
				$_SESSION['view_count'] = (int)$_POST['view_count'];
			}
			if(isset($_POST['sort'])){
				$_SESSION['sort'] = (int)$_POST['sort'];
			}
			if(isset($_POST['hor'])){
				$_SESSION['hor'] = (int)$_POST['hor'];
			}
			redirect($this->uri->uri_string());
			exit;
		}

		$obj = $this->clientmodel->getPage(91);
		//$data = array_merge($data, $this->info($obj));


		$color = $this->uri->segment(2);
		//проверка на .html------------------------------------
		if($color){
			if(preg_match('/(\.html)/', $color)){
				$color = str_replace(".html", "", $color);
				if(array_key_exists($color, $data['colors'])){
					$data['color'] = $color;
				}else{
					show_404('page');exit;
				}
			}else{
				show_404('page');exit;
			}
		}
		//-----------------------------------------------------

		if(array_key_exists($color, $data['colors'])){
			$page = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;

			$count           = $this->clientmodel->getCountColor($color);
			$data['gallery'] = $this->clientmodel->getColor($color, $page);
			$data['pagin']   = $this->client_lib->pagin($count, $page, $data, 'color');
			
			$data['title']    = $arr[$color]['title'];
			$data['metadesc'] = $arr[$color]['desc'];
		}

		$this->client_lib->client_view('color', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__SEARCH
	public function search()
	{
		$data = $this->data;
		
		if(METHOD == 'POST'){
			if (isset($_POST['chpage']) && !empty($_POST['page'])) {
                $images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&order='.$_SESSION['sort'].'&limit='.$_SESSION['view_count'].'&orientation='.$_SESSION['hor'].'&page='.@$_POST['page'].'');
                $images = json_decode($images);
               
                if ((int)$_POST['page'] > $images->data->paging->total_pages) {
                    echo 'fail';
                    exit;
                }
                
                echo '/search?s='.@$_POST['search'].'&page='.@$_POST['page'];
                exit;
            }
		}
		

		if(METHOD == 'GET'){
			$word = mysql_real_escape_string(trim($_GET['s']));
            $word = urlencode($word);
			$images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&order='.$_SESSION['sort'].'&limit='.$_SESSION['view_count'].'&orientation='.$_SESSION['hor'].'&page='.@$_GET['page'].'&q='.$word);
            if ($images === false) {
                $images = @file_get_contents('http://api.bigstockphoto.com/2/'.$this->idAccount.'/search/?response_detail=all&category='.strtolower($urlCategory).'&page=1&q='.$word);
            }
            $images = json_decode($images);
            $data['firstPage']  = $this->seg[0];
            if (isset($_GET['s'])) {
                $data['firstPage']  = $this->seg[0] . '?s='.urlencode($_GET['s']);
            }
            $data['lastPage']   = array(
                'number'    => $images->data->paging->total_pages,
                'link'      => $this->seg[0] . '?s='.urlencode($_GET['s']).'&page=' . $images->data->paging->total_pages,
            );
            $data['pagin']      = $images->data->paging;
            $data['gallery']    = $images->data->images;
            if ($images->data->paging->page == 1) {
                $data['prev'] = false;
            } else {
                $prev = $images->data->paging->page - 1;
                $data['prev'] = '/search?s='.urlencode(@$_GET['s']).'&page='.$prev;
            }
            if ($images->data->paging->page == $images->data->paging->total_pages) {
                $data['next'] = false;
            } else {
                $next = $images->data->paging->page + 1;
                $data['next'] = '/search?s='.urlencode(@$_GET['s']).'&page='.$next;
            }
        }

		$this->client_lib->client_view('gallery', $data);
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__DOWNLOAD
	public function download()
	{	
		
                $imgs  = @$_COOKIE['favorit'];
		$imgs  = @explode('|',$imgs);
		$del   = @array_pop($imgs);
                
                unset($del);
		if(count($imgs) == 0){show_404('page');exit;}

		//создание zip архива
		$zip = new ZipArchive();
                echo '<pre>';
		//имя файла архива
		//$fileZip = tempnam( "artoboi", "zip");
                
                $filename = 'artoboi_' .time(). '.zip';
                $pathToFile = ROOT.'/temporary_dir/';
                
		if ($zip->open($pathToFile.$filename, ZIPARCHIVE::CREATE) !== true) {
                    
			fwrite(STDERR, "Error while creating archive file");
			exit;
		}
                
		//добавляем файлы в архив все файлы из папки src_dir
		foreach($imgs as $k){
			preg_match('/\[(.+)\](.+)/', $k, $match);

			$cat = $match[1];
			$articul = $match[2];
			$path = ROOT.'/img/gallery/'.$cat.'/thumbs/thumb_l_'.$articul.'.jpg';
			
			if(is_file($path)){
                                $zip->addFile($path, $articul.'.jpg');
			}
		}
                
                
		//закрываем архив
		$zip->close();
                
                
                //закачка архива
		/*header("HTTP/1.1 200 OK");
		//header("Connection: close");
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
                header("Content-Length:" . filesize($pathToFile.$filename));
		header("Content-Disposition: Attachment; filename={$filename}");
		
		readfile($pathToFile.$filename);*/
                
                header("Location: /temporary_dir/".$filename);
                $this->deleteFiles($pathToFile);
		//unlink($pathToFile.$filename);

		exit;
	}
        
        private function deleteFiles( $dir )
        {
            $files = scandir($dir);
            
            if( is_array($files) )
            {
                foreach ($files as $value)
                {
                    if(is_file($dir.$value))
                    {
                        $date = substr($value, strpos($value, '_')+1, 10);
                        $expire = (int)$date + 380;
                        if( $expire < time() )
                        {
                            unlink($dir.$value);
                        }
                    }
                }
            }
            
        }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TEXTURA
	public function textura()
	{
		$data = $this->data;

		$obj = $this->clientmodel->getPage(28);
		//$data = array_merge($data, $this->info($obj));
		
		$data['textures'] = $this->clientmodel->getTextura();
        $data['material'] = $this->clientmodel->getMaterial();
	
    
    	foreach($data['textures'] as $k){
			$arr = array();
			$dir = ROOT.'/img/textura/'.$k->id.'/';
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
			$k->example = implode(",", $arr);
		}
        
        

$dat = $this->clientmodel->getBigstockCat($data);

//print_r($dat);

$data['bd_sel_cat'] = $dat; 


//$data['podcat_all'] = $this->clientmodel->m_podcat_all();

        
		//$data['metadesc'] = '';
		$this->client_lib->client_view('textura', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// popular
	public function popular()
	{
		$data = $this->data;

		$obj = $this->clientmodel->getPage(84);
		//$data = array_merge($data, $this->info($obj));
		$data['gallery'] = $this->clientmodel->getPopular();

		$this->client_lib->client_view('popular', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// new
	public function newimages()
	{
		$data = $this->data;
		$obj = $this->clientmodel->getPage(85);
		//$data = array_merge($data, $this->info($obj));
		$data['gallery'] = $this->clientmodel->getNewImages();
                //aweb start
                if($_SERVER['REQUEST_URI']=='/new-wallpapers.html'){
                    $data['title'] = 'Новые эксклюзивные коллекции фтообоев на стены купить в Украине';
                    $data['metadesc'] = 'Новые коллекции эксклюзивных фотообоев на любой вкус. Звоните и заказывайте! Доставка по всей России.';
                }
                //aweb stop
		$this->client_lib->client_view('newimages', $data);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Tag
	public function tag()
	{
		$data = $this->data;

		if(!isset($_GET['alt'])){ redirect('/');exit;}
		$alt = mysql_real_escape_string(trim($_GET['alt']));

		$obj = $this->clientmodel->getPage(88);
		//$data = array_merge($data, $this->info($obj));
		$language = 'alt';
		
		$data['title'] = 'Фотообои "'.$_GET['alt'].'" изготовление на заказ - Арт обои';
		
		$data['gallery'] = $this->clientmodel->getSimilarImage($alt, $language);

		$this->client_lib->client_view('tag', $data);
	}


/////////////////////////////////////////////////////////////////////////////////////////////// sitemap
    public function sitemap()
    {
        $data = $this->data;
        
        $obj = $this->db->query('SELECT * FROM pages WHERE url="karta-sajta"')->row();
        //$data = array_merge($data, $this->info($obj));
        $data['sitemap'] = $this->clientmodel->m_sitemap();
        $this->client_lib->client_view('sitemap', $data);
    }
    
    /***** Ivan 24.07.2013 ******/
    public function reviews()
    {
        $data = $this->data;
        $obj = $this->clientmodel->getPage(121);
        //$data = array_merge($data, $this->info($obj));
        $data['fetched_reviews'] = $this->clientmodel->FetchAllReviews();
        $data['name']       = 'Отзывы о нас';
        $data['metadesc']   = 'Отзывы о фотообоях для профессионального декорирования квартир, домов, офисов и кафе можно прочесть на сайте art-oboi.com.ua.';
        $data['metakey']    = 'отзывы, фотообои на стену';
        $data['title']      = 'Фотообои - отзывы наших покупателей о фотообоях на стену – интернет-магазин ART-oboi';
        $data['name_as_h1'] = 'Отзывы о нас';
        
        //transform from Unix timestamp formats to day-month-year
        foreach ($data['fetched_reviews'] as $value)
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

        $this->client_lib->client_view('reviews', $data);
    }
}//END
