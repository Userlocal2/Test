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
						'view_count'       =>array(15, 30, 60),
						'count'            =>0,
						'pagin'            =>'',
						'name'             =>'',
						'subcategory'      =>array(),
						'subcat_id'        =>0,
						'subcat_name'      =>'',
						'cat_url'          =>'',
						'cat_id'           =>0,
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

		$this->data['all_category']    = $this->clientmodel->getAllCategory();
		$this->data['all_pages']       = $this->clientmodel->getAllPages();
		$this->data['i']               = $this->clientmodel->getInfo();
		$this->data['favorit']         = $this->clientmodel->getFavorit();

		if(!isset($_SESSION['view_count'])){ $_SESSION['view_count'] = 2;}
		if(!isset($_SESSION['sort']))      { $_SESSION['sort']       = 0;}
		if(!isset($_SESSION['hor']))       { $_SESSION['hor']        = 0;}
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
	public function index()
	{
            
		$data = $this->data;
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'"/>';
 
		if(empty($this->seg[0])){
			$k = $this->clientmodel->getHomePage();
			$data = array_merge($data, $this->info($k));
		}else{
			foreach($data['all_category'] as $k){
				if($k->url.'.html' == $this->seg[0]){
					$this->data['cat_url']  = $k->url;
					$this->data['cat_name'] = $k->name;
					$this->data['crumb']    = $k->crumb;
					$this->data['cat_id']   = $k->id;
					$this->category($k);
					return;
				}
			}

			if($this->seg[0] == 'crop-image'){
				$this->crop();
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
				if($k->url.'.html' == $this->seg[0]){
                                        
					$this->pages($k);
					return;
				}
			}

			show_404('page');exit;
		}

		$this->client_lib->client_view('home', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CATEGORY
	public function category($obj)
	{
            
		$data = $this->data;
                
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$this->uri->uri_string().'"/>';
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

		if($obj == null){ show_404('page');exit;}
                

		$data = array_merge($data, $this->info($obj));
                //aweb start
                //для Самые популярные 6 разделов
                if($obj->order<=5){
                    $data['title'] = $data["name"].' на стену купить в Москве, цены от компании klv-oboi';
                    $data['metadesc'] = 'Заказывайте красивые '.$data["name"].' на стену. Любые размеры по низким ценам. Доставка по всей России.';
                }
                //aweb stop
		//если выбрали подкатегорию - пропускаем всё
		if(isset($_GET['razdel'])){
                    //aweb start
                    //убираем текст из подкатегорий
                    $obj->text='';
                    $data['text']='';
                    //aweb stop
			$data['gallery']   = $this->clientmodel->getGalleryOfCategoryAndSubcategory((int)$_GET['razdel']);
			$data['subcat_id'] = (int)$_GET['razdel'];
			//если неверный параметр 404
			if(!count($data['gallery'])){show_404('page');exit;}

			//подкатегории  
			$data['subcategory'] = $this->clientmodel->getSubcategoryOfCategory($obj->id);

			foreach($data['subcategory'] as $k){
				if($k->id_subcat == (int)$_GET['razdel']){
					$data['subcat_name'] = $k->subcat_name;
				}
			}
                  $data['typeRoom']= $this->db->query('SELECT type_room FROM category WHERE id = '.$obj->id.' ')->row();
                  
                        if($obj->order<=5){
                            $data['title'] = 'Фотообои '.$data["subcat_name"].' на стену купить в Москве, цены от компании klv-oboi';
                            $data['metadesc'] = 'Заказывайте красивые фотообои '.$data["subcat_name"].' на стену. Любые размеры по низким ценам. Доставка по всей России.';
                        }
			$this->client_lib->client_view('gallery', $data);
			return;
		}


		$page = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;

		if(@$_SESSION['old_cat'] != $obj->id){ 
			@$_SESSION['hor'] = 0;
		}
		@$_SESSION['old_cat'] = $obj->id;
                
		$count           = $this->clientmodel->getCountGalleryOfCategory($obj->id);
		$data['gallery'] = $this->clientmodel->getGalleryOfCategory($obj->id, $page);

		$data['pagin']    = $this->client_lib->pagin($count, $page, $data);
		$data['typeRoom'] = $this->db->query('SELECT type_room FROM category WHERE id = '.$obj->id.' ')->row();
		//подкатегории
		$data['subcategory'] = $this->clientmodel->getSubcategoryOfCategory($obj->id);
                

		$this->client_lib->client_view('gallery', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__ORDER
	public function order()
	{
		$data = $this->data;

		if(!isset($_SESSION['order'])){
			$_SESSION['order'] = '';
			$_SESSION['post']  = '';
		}

		if(METHOD == 'POST'){
			if(isset($_POST['order'])){
                            $isValidData = $this->antispam->ValidationData();
                            if( $isValidData )
                            {
                                //clear notification about incorrect data
                                unset($_SESSION['dataNonValid']);

                                $numberOrder = $this->antispam->FetchLatestOrder();
                                if( $numberOrder >= 5 )
                                {
                                    $this->antispam->BlockIP();
                                }
                                elseif( $numberOrder >= 3 && $numberOrder < 5 )
                                {
                                    $isCorrectCapthca = $this->antispam->isCorrectCaptcha();
                                    if( $isCorrectCapthca )
                                    {
                                        $this->antispam->CommitNewOrder();
                                        $this->client_lib->order();
                                        redirect($data['lang'].'/order');
                                        exit;
                                    }
                                    else
                                    {
                                        redirect($data['lang'].'/crop-image?title='.@$_POST['num_img']);
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
                                redirect($data['lang'].'/crop-image?title='.@$_POST['num_img']);
                                exit;
                            }
			}
		}

		if(!@$_SESSION['post']){redirect('/');exit;}

		$data['order'] = $this->clientmodel->getImageGallery($_SESSION['order']);
		$data['post']  = $_SESSION['post'];
		$_SESSION['order'] = '';
		$_SESSION['post']  = '';

		$this->client_lib->client_view('order', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__CROP-IMAGE
	public function crop()
	{
		$data = $this->data;

		if(METHOD == 'POST'){
			if(isset($_POST['order'])){
				$this->client_lib->order();
				exit;
			}
		}

		if(!isset($_GET['title'])){ show_404();exit;}
		$title           = mysql_real_escape_string(trim($_GET['title']));
		$data['gallery'] = $this->clientmodel->getImageGallery($title);
		
		if(!count($data['gallery'])){ show_404();exit;}
		
		$data['textura'] = $this->clientmodel->getTextura();
		
		$name = $data['gallery']->title_image ? $data['gallery']->title_image : $data['gallery']->articul;
		
		$data['title']   = 'Фотообои "'.$name.'" на заказ под свой размер - art-oboi.com.ua';
		$data['name']     = 'Фотообои '.$name;
		$data['metadesc'] = '';
		$data['metakey']  = '';
		
		//Делаем хит в БД
		$this->db->query('UPDATE gallery SET hits = hits + 1 WHERE id = '.$data['gallery']->id);

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
		$data = array_merge($data, $this->info($k));

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
		$data = array_merge($data, $this->info($obj));

		$data['type_interior'] = $this->clientmodel->getTypeInterior();

		$page  = isset($_GET['page']) ? ((int)$_GET['page'] < 0 ? 0 : (int)$_GET['page']) : 0;
		$count = $this->clientmodel->getCountInterior();

		$data['interior'] = $this->clientmodel->getInterior($page);
		$data['pagin']    = $this->client_lib->pagin_interior($count, $page, $data);
		
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$obj->url.'.html"/>';
		if($_SERVER['REQUEST_URI']=='/photooboi-interior.html'){
                    $data['metadesc'] = '';
                }
		$this->client_lib->client_view('photo_interior', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__PAGE
	public function pages($obj)
	{
            
		$data = $this->data;

		if($obj == null){ show_404('page');exit;}
		$obj = $this->clientmodel->getPage($obj->id);
		$data = array_merge($data, $this->info($obj));
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
                
                $data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$obj->url.'.html"/>';
                $arr_no_description = array(
                    '/wallpapers-around-us.html',
                    '/holst.html',
                    '/delivery-ukraine.html',
                    '/contacts.html',
                );
                if(in_array($_SERVER['REQUEST_URI'],$arr_no_description) ){
                    $data['metadesc'] = '';
                }
		$this->client_lib->client_view('page', $data);
	}
        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__COLOR
	public function color()
	{
		$data = $this->data;
		$data['canonical'] = '<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/'.$this->uri->uri_string().'" />';
		$data['color']     = '';
		$arr = array(
						'red' => array('title'=>'Фотообои красные купить в интернет-магазине KLV-oboi.ru', 'desc'=>'Купите фотообои красные в Москве по доступным ценам. Разнообразные изображения, выполненные в красных тонах придадут яркости и красочности Вашей комнате. Широкий ассортимент в интернет-магазине KLV-oboi.ru.'), 
						'orange' => array('title'=>'Фотообои оранжевые: яркие решения для дома и офиса. Купить в KLV-oboi.ru', 'desc'=>'Фотообои оранжевые. Широкий ассортимент фотообоев, выполненных во всех оттенках оранжевого цвета. Доступные цены, доставка по России.'),  
						'yellow' => array('title'=>'Фотообои желтые по выгодным ценам в интернет-магазине KLV-oboi.ru', 'desc'=>'Приобретите яркие и красочные желтые фотообои по низким ценам в Москве. Создайте солнечное настроение благодаря KLV-oboi.ru.'), 
						'green' => array('title'=>'Фотообои зеленые на стену купить в интернет-магазине KLV-oboi.ru', 'desc'=>'Купите зеленые фотообои по доступным ценам. Мы предалагаем широкий ассортимент зеленых фотообоев различной тематики. Доставка по России.'), 
						'azure' => array('title'=>'Фотообои голубые купить в Москве. Низкие цены в нтернет-магазине KLV-oboi.ru', 'desc'=>'Фотообои голубые на любой вкус в ассортименте. Разнообразная тематика и изображения в голубых тонах. Купите по доступным ценам в интернет-магазине KLV-oboi.ru'), 
						'blue' => array('title'=>'Фотообои синие, голубые по доступным ценам в Москве. Купить в KLV-oboi.ru', 'desc'=>'Голубые и синие фотообои на любой вкус в ассортименте. Разнообразная тематика и изображения в синих тонах. Купите по доступным ценам в интернет маназине KLV-oboi.ru'), 
						'violet' => array('title'=>'Фотообои фиолетовые купить в Москве — интернет-магазин KLV-oboi.ru', 'desc'=>'Фотообои фиолетовые в широком ассортименте. Купите фиолетовые фотообои для Вашего помещения в KLV-oboi.ru по доступным ценам.'), 
						'pink' => array('title'=>'Фотообои розовые. Купить в KLV-oboi.ru по выгодным ценам', 'desc'=>'Купите фотообои розовые по доступным ценам в Москве. Широкий ассортимент фотообоев в розовых тонах в интернет-магазине KLV-oboi.ru.'), 
						'white' => array('title'=>'Фотообои белые по доступным ценам в интернет-магазине KLV-oboi.ru', 'desc'=>'Приобретите белые фотообои самых разнообразных тематик. Широкий ассортимент в интернет-магазине KLV-oboi.ru.'), 
						'grey' => array('title'=>'Фотообои серые в различных тонах в интернет-магазине KLV-oboi.ru', 'desc'=>'Закажите фотообои серые для Вашего дома или офиса в интернет-магазине KLV-oboi.ru по доступным ценам.'), 
						'black' => array('title'=>'Фотообои черные. Фотообои, темных тонов по доступным ценам', 'desc'=>'Фотообои черные в широком ассортименте в интернет-магазине KLV-oboi.ru. Доступные цены, быстрая доставка по России.'),  
						'brown' => array('title'=>'Фотообои коричневые купить в Москве. Низкие цены в KLV-oboi.ru', 'desc'=>'Приобретите с доставкой коричневые фотообои различной тематики: фрески. города, архитектура и другие. Доступные цены и широкий ассортимент в интернет-магазине KLV-oboi.ru')
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
		$data = array_merge($data, $this->info($obj));


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
		/*
		if(METHOD == 'POST'){
			if(isset($_POST['next'])){
				$res = $this->clientmodel->loadNextGaallery($_SESSION['search'], $_SESSION['next'], $limit = 60);
				$_SESSION['next']++;
				echo json_encode($res);
				exit;
			}
			echo 0;
			exit;
		}
		*/

		if(METHOD == 'GET'){
			$word = mysql_real_escape_string(trim($_GET['s']));
			$_SESSION['search'] = $word;
			$_SESSION['next']   = 1;

			$data['name']=$data['metadesc']=$data['metakey']=$data['title'] = 'Поиск';
            $curr_lang = LANG == 'ua' ? 'ua_alt' : 'alt';
			$data['s_gallery'] = $this->clientmodel->searchGallery($word, $curr_lang);
		}

		$this->client_lib->client_view('search', $data);
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
		$data = array_merge($data, $this->info($obj));
		
		$data['textures'] = $this->clientmodel->getTextura();

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
		$data['metadesc'] = '';
		$this->client_lib->client_view('textura', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// popular
	public function popular()
	{
		$data = $this->data;

		$obj = $this->clientmodel->getPage(84);
		$data = array_merge($data, $this->info($obj));
		$data['gallery'] = $this->clientmodel->getPopular();

		$this->client_lib->client_view('popular', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// new
	public function newimages()
	{
		$data = $this->data;
		$obj = $this->clientmodel->getPage(85);
		$data = array_merge($data, $this->info($obj));
		$data['gallery'] = $this->clientmodel->getNewImages();
                //aweb start
                if($_SERVER['REQUEST_URI']=='/new-wallpapers.html'){
                    $data['title'] = 'Новые эксклюзивные коллекции фтообоев на стены купить в Москве';
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
		$data = array_merge($data, $this->info($obj));
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
        $data = array_merge($data, $this->info($obj));
        $data['sitemap'] = $this->clientmodel->m_sitemap();
        $this->client_lib->client_view('sitemap', $data);
    }
    
    /***** Ivan 24.07.2013 ******/
    public function reviews()
    {
        $data = $this->data;
        $obj = $this->clientmodel->getPage(121);
        $data = array_merge($data, $this->info($obj));
        $data['fetched_reviews'] = $this->clientmodel->FetchAllReviews();
        $data['name']       = 'Отзывы о нас';
        $data['metadesc']   = 'Отзывы о фотообоях для профессионального декорирования квартир, домов, офисов и кафе можно прочесть на сайте klv-oboi.ru.';
        $data['metakey']    = 'отзывы, фотообои на стену';
        $data['title']      = 'Фотообои - отзывы наших покупателей о фотообоях на стену – интернет-магазин KLV-oboi';
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
