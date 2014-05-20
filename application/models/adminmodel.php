<?php
class adminModel extends CI_Model{
	
	function __construct()
    {
        parent::__construct();
    }
    
    public function getTypeMaterials()
    {
        return $this->db->get('type_material')->result();
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AUTH
	public function auth(){
		$login = mysql_real_escape_string(trim($_POST['login']));
		$pass = mysql_real_escape_string(trim($_POST['pass']));
		
        $access_pass = crypt($pass, '$2a$08$H5oKmeCgusCp6ff3Q4nviy$');
		$sql = 'SELECT * FROM klv_access_pass WHERE my_name = "'.$login.'" AND enter_pass = "'.$access_pass.'"';
		$res = $this->db->query($sql);
		if($res->result()){
			$_SESSION['admin'] = session_id();
			$_SESSION['manager'] = session_id();
			$IP     = $_SERVER['REMOTE_ADDR'];
			$client = $_SERVER['HTTP_USER_AGENT'];
			$time   = time();
			$sess   = session_id();
			$this->db->query('DELETE FROM session_admin WHERE enter < '.($time-86400));
			$this->db->query('INSERT INTO session_admin (id_session, ip, info_client, enter) VALUES ("'.$sess.'", "'.$IP.'", "'.$client.'", '.$time.')');
			$_SESSION['admin'] = $sess;
			
			return true;
		}else{
			return false;
		}
	}
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INDEX
	public function getStaticsCategory(){
		return $this->db->query('SELECT COUNT(*) AS all_cat, 
								(SELECT COUNT(*) FROM category WHERE visibility = 0) AS vis, 
								(SELECT COUNT(*) FROM category WHERE title = "") AS no_title, 
								(SELECT COUNT(*) FROM category WHERE metadesc = "") AS no_desc,
								(SELECT COUNT(*) FROM category WHERE metakey = "") AS no_key
								FROM category')->row();
	}
	public function getStaticsGallery(){
		return $this->db->query('SELECT COUNT(*) AS all_img, 
								(SELECT COUNT(*) FROM gallery WHERE visibility = 0) AS vis, 
								(SELECT COUNT(*) FROM gallery WHERE alt = "") AS no_alt
								FROM gallery')->row();
	}
	public function getStaticsPages(){
		return $this->db->query('SELECT COUNT(*) AS all_pages, 
								(SELECT COUNT(*) FROM pages WHERE visibility = 0) AS vis, 
								(SELECT COUNT(*) FROM pages WHERE title = "") AS no_title, 
								(SELECT COUNT(*) FROM pages WHERE metadesc = "") AS no_desc,
								(SELECT COUNT(*) FROM pages WHERE metakey = "") AS no_key
								FROM pages')->row();
	}
	public function getStaticsTextura(){
		return $this->db->query('SELECT COUNT(*) AS all_img, 
								(SELECT COUNT(*) FROM textura WHERE visibility = 0) AS vis, 
								(SELECT COUNT(*) FROM textura WHERE alt = "") AS no_alt
								FROM textura')->row();
	}
	public function getStaticsInterior(){
		return $this->db->query('SELECT COUNT(*) AS all_img, 
								(SELECT COUNT(*) FROM interior WHERE visibility = 0) AS vis, 
								(SELECT COUNT(*) FROM interior WHERE alt = "") AS no_alt
								FROM interior')->row();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CATEGORY
	public function getCategory(){
		return $this->db->query('SELECT * FROM category WHERE id = '.(int)$_GET['update'])->row();
	}
	public function getAllCategory(){
		return $this->db->query('SELECT * FROM category ORDER BY `order` ASC')->result();
	}
	public function addCategory(){
		$name          = mysql_real_escape_string(trim($_POST['name']));
		$crumb         = mysql_real_escape_string(trim($_POST['crumb']));
		$title         = mysql_real_escape_string(trim($_POST['title']));
		$metadesc      = mysql_real_escape_string(trim($_POST['metadesc']));
		$metakey       = mysql_real_escape_string(trim($_POST['metakey']));
		$text          = mysql_real_escape_string(trim($_POST['text']));
		$visibility    = (int)$_POST['visibility'];
		$url           = $this->admin_lib->translit(mb_strtolower(trim($_POST['url'])));
		if(!$url){ $url = time();}
		//$url           = strlen(trim($_POST['url'])) == 0 ?  mysql_real_escape_string(strtolower($this->admin_lib->translit(trim($_POST['name'])))) : mysql_real_escape_string(strtolower(trim($_POST['url'])));
		
		$this->db->query('INSERT INTO category (name,crumb,title,metadesc,metakey,text,url,visibility) 
						  VALUES ("'.$name.'",
								  "'.$crumb.'",
								  "'.$title.'", 
								  "'.$metadesc.'", 
								  "'.$metakey.'", 
								  "'.$text.'",
								  "'.$url.'", 
								   '.$visibility.')');
		return true;
	}
	public function updateCategory(){
		$id_cat        = (int)$_POST['id'];
		$name          = mysql_real_escape_string(trim($_POST['name']));
		$crumb         = mysql_real_escape_string(trim($_POST['crumb']));
		$title         = mysql_real_escape_string(trim($_POST['title']));
		$metadesc      = mysql_real_escape_string(trim($_POST['metadesc']));
		$metakey       = mysql_real_escape_string(trim($_POST['metakey']));
		$text          = mysql_real_escape_string(trim($_POST['text']));
		$visibility    = (int)$_POST['visibility'];
		$url      = strlen(trim($_POST['url'])) == 0 ?  mysql_real_escape_string(strtolower($this->admin_lib->translit(trim($_POST['name'])))) : mysql_real_escape_string(strtolower(trim($_POST['url'])));
		
		$res = $this->db->query('UPDATE category 
								 SET name = "'.$name.'",
									 crumb = "'.$crumb.'",
									 title = "'.$title.'", 
									 metadesc = "'.$metadesc.'", 
									 metakey = "'.$metakey.'", 
									 text = "'.$text.'",
									 url = "'.$url.'", 
									 visibility = '.$visibility.'
									 WHERE id = '.$id_cat);
		return $res;
	}
	public function delCategory(){
		$id_cat = (int)$_POST['id'];
		
		$res = $this->db->query('SELECT id FROM gallery WHERE id_cat = '.$id_cat);
		
		if($res->num_rows() != 0){
			return 'Невозможно удалить категорию!| Категория содержит: изображений - ' . $res->num_rows() ;
		}else{
			$this->db->query('DELETE FROM category WHERE id = '.$id_cat);
			@rmdir(ROOT.'/img/gallery/'.$id_cat.'/thumbs');
			@rmdir(ROOT.'/img/gallery/'.$id_cat);
			return 0;
		}
	}
	public function sort_category(){
		$data = json_decode($_POST['sort']);
		foreach($data as $k){
			$res = $this->db->query('UPDATE category SET `order`= '.$k->pos.' WHERE id = '.$k->id);
			if(!$res){echo 'error';exit;}
		}
		echo 0;
		return;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////PAGES
	public function setHomePage($id = 0){
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
	}
	public function getAllPages()
	{
		return $this->db->query('SELECT * FROM pages ORDER BY `order` ASC')->result();
	}
	public function getPage($id = 0)
	{
		return $this->db->query('SELECT * FROM pages WHERE id = '.$id)->row();
	}
	public function getAllTypePages()
	{
		return $this->db->query('SELECT * FROM type_pages WHERE type <> "home"')->result();
	}

	public function addPage()
	{
		$name       = mysql_real_escape_string(trim($_POST['name']));
		$title      = mysql_real_escape_string(trim($_POST['title']));
		$metadesc   = mysql_real_escape_string(trim($_POST['metadesc']));
		$metakey    = mysql_real_escape_string(trim($_POST['metakey']));
		$text       = mysql_real_escape_string(trim($_POST['text']));
		
		$id_parent  = (int)$_POST['id_parent'];
		
		$name_as_h1 = isset($_POST['name_as_h1']) ? 1 : 0;
		
		$type       = mysql_real_escape_string(trim($_POST['type']));
		$visibility = (int)$_POST['visibility'];
		$url        = strlen(trim($_POST['url'])) == 0 ?  mysql_real_escape_string(strtolower($this->admin_lib->translit(trim($_POST['name'])))) : mysql_real_escape_string(strtolower(trim($_POST['url'])));
		
/*		$this->db->query('INSERT INTO pages (id_parent, name, title, metadesc, metakey, text, url, type, visibility, name_as_h1) 
							   VALUES ('.$id_parent.', "'.$name.'",  "'.$title.'", "'.$metadesc.'", "'.$metakey.'", "'.$text.'", "'.$url.'", "'.$type.'", '.$visibility.', '.$name_as_h1.')');*/
                               
$this->db->query('INSERT INTO pages (id_parent, name, title, metadesc, metakey, text, url, type, visibility, name_as_h1,ua_text) 
VALUES ('.$id_parent.', "'.$name.'",  "'.$title.'", "'.$metadesc.'", "'.$metakey.'", "'.$text.'", "'.$url.'", "'.$type.'", '.$visibility.', '.$name_as_h1.'  ,1)');                               
		
        
        
        
		$id = $this->db->query('SELECT id FROM pages ORDER BY id DESC')->row();
		
		$image = $_FILES['image'];
		if($image['error'] == 0){
			//проверяем существует ли папка PREVIEW_PAGES
			if(!is_dir(ROOT.'/img/preview_pages')){
				mkdir(ROOT.'/img/preview_pages', 0755);
			}
			$this->my_imagemagic->resize_3($image['tmp_name'], ROOT.'/img/preview_pages/'.$id.'.jpg', 184);
		}
		return true;
	}
	
	public function updatePage()
	{
		$id          = (int)$_POST['id'];
		$name        = mysql_real_escape_string(trim($_POST['name']));
		$title       = mysql_real_escape_string(trim($_POST['title']));
		$metadesc    = mysql_real_escape_string(trim($_POST['metadesc']));
		$metakey     = mysql_real_escape_string(trim($_POST['metakey']));
		$text        = mysql_real_escape_string(trim($_POST['text']));
		
		$id_parent  = (int)$_POST['id_parent'];
		
		$name_as_h1 = isset($_POST['name_as_h1']) ? 1 : 0;
		
		$type        = mysql_real_escape_string(trim($_POST['type']));
		$visibility  = (int)$_POST['visibility'];
		$url         = strlen(trim($_POST['url'])) == 0 ?  mysql_real_escape_string(strtolower($this->admin_lib->translit(trim($_POST['name'])))) : mysql_real_escape_string(strtolower(trim($_POST['url'])));
		
		$res = $this->db->query('UPDATE pages SET id_parent  = '.$id_parent.',
												  name       = "'.$name.'", 
												  title      = "'.$title.'", 
												  metadesc   = "'.$metadesc.'", 
												  metakey    = "'.$metakey.'", 
												  text       = "'.$text.'", 
												  url        = "'.$url.'",
												  type       = "'.$type.'",
												  visibility = '.$visibility.',
												  name_as_h1 = '.$name_as_h1.'	
										    WHERE id = '.$id);
		$image = $_FILES['image'];
		if($image['error'] == 0){
			//проверяем существует ли папка PREVIEW_PAGES
			if(!is_dir(ROOT.'/img/preview_pages')){
				mkdir(ROOT.'/img/preview_pages', 0755);
			}

			$this->my_imagemagic->resize($image['tmp_name'], ROOT.'/img/preview_pages/'.$id.'.jpg', 184);
		}
		
		return;
	}
	public function delPage()
	{
		$id_page = (int)$_POST['id'];
		$res = $this->db->query('DELETE FROM pages WHERE id = '.$id_page);
		return 0;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////GALLERY
	public function getAllGallery(){
		$res = $this->db->query('SELECT * FROM gallery');
		return $res->result();
	}
	public function getGalleryArticul($articul){
		$articul = mysql_real_escape_string(trim($_POST['setArticul']));
		return $this->db->query('SELECT * FROM gallery WHERE articul = "'.$articul.'"')->row();
	}
	public function getGalleryOfCategoryCount($id_cat){
		$res = $this->db->query('SELECT COUNT(*) AS cnt FROM gallery WHERE id_cat = ' . $id_cat);
		return $res->row()->cnt;
	}
	public function getGalleryHid(){
		$id_cat = (int)$_GET['id_cat'];
		return $this->db->query('SELECT * FROM gallery WHERE visibility = 0 AND id_cat = '.$id_cat.' ORDER BY hits DESC')->result();
	}
	public function getGalleryHidden(){
		$view = array(0=>100,1=>1000);
		$v = $view[(int)@$_GET['view_gallery']];
		
		$start = (int)@$_GET['page'];
		$start = $v * ($start = $start >= 1 ? $start - 1 : $start);

		$limit = ' LIMIT '.$start.','.$v.' ';
		
		$res = $this->db->query('SELECT * FROM gallery WHERE visibility = 0 ORDER BY hits DESC' . $limit);
		return $res->result();
	}
	public function getGalleryOfCategory($id_cat){
		$view = array(0=>100,1=>1000);
		$v = $view[(int)@$_GET['view_gallery']];
		
		$start = (int)@$_GET['page'];
		$start = $v * ($start = $start >= 1 ? $start - 1 : $start);

		$limit = ' LIMIT '.$start.','.$v.' ';
		
		$res = $this->db->query('SELECT * FROM gallery WHERE id_cat = ' . $id_cat . ' ORDER BY hits DESC' . $limit);
		return $res->result();
	}
	public function getAllCleanGallery(){
		$res = $this->db->query('SELECT * FROM gallery WHERE id_cat = 0');
		return $res->result();
	}
	public function getImg($id_img){
		$res = $this->db->query('SELECT * FROM gallery WHERE id = '.$id_img);
		return $res->row();
	}
	public function getImgHidden(){
		return $this->db->query('SELECT * FROM gallery WHERE visibility = 0')->result();
	}
	public function updateImage(){
		$id         = (int)$_POST['id'];
		$wm         = isset($_POST['wm']) ? (int)$_POST['wm'] : 0; //Дописать обработку наложения WM
		$visibility = (int)$_POST['visibility'];
		$alt        = mysql_real_escape_string(trim($_POST['alt']));
		$title_image= mysql_real_escape_string(trim($_POST['title_image']));
                $width_cm = mysql_real_escape_string(trim($_POST['width_cm']));
                $height_cm = mysql_real_escape_string(trim($_POST['height_cm']));
		
		$this->db->query('UPDATE gallery SET alt = "'.$alt.'", visibility = '.$visibility.', wm = '.$wm.', width_cm = '.$width_cm.', height_cm = '.$height_cm.'  WHERE id = '.$id);
		
		return;
	}
	public function delGallery($id)
	{
		$res = $this->db->query('SELECT * FROM gallery WHERE id = '.$id);
		$row = $res->row();

		@unlink(ROOT.'/img/gallery/'.$row->id_cat.'/thumbs/thumb_l_'.$row->articul.'.jpg');
		@unlink(ROOT.'/img/gallery/'.$row->id_cat.'/thumbs/thumb_m_'.$row->articul.'.jpg');
		@unlink(ROOT.'/img/gallery/'.$row->id_cat.'/thumbs/thumb_s_'.$row->articul.'.jpg');
		@unlink(ROOT.'/img/gallery/'.$row->id_cat.'/thumbs/thumb_sb_'.$row->articul.'.jpg');
		
		@unlink(ROOT.'/img/archiv/'.$row->id_cat.'/'.$row->articul.'.jpg');
		
		$this->db->query('DELETE FROM gallery WHERE id = '.$id);
		
		return 0;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SUBCATEGORY
	public function getSubcategory($id_cat = 0){
		if($id_cat){
			return $this->db->query('SELECT * FROM subcategory WHERE id_cat = '.$id_cat)->result();
		}else{
			return $this->db->query('SELECT * FROM subcategory')->result();
		}
	}
        public function getSubcategoryById($id = 0)
        {
            if($id == 0)
            {
                return array();
            }
            else
            {
                return $this->db->query("SELECT * FROM subcategory WHERE id = {$id}")->row();
            }
        }
        public function addTextToSubCat($inputData)
        {
            $sql = "UPDATE subcategory SET text = '{$inputData['text']}', meta_title = '{$inputData['meta_title']}', metadesc = '{$inputData['metadesc']}' WHERE id = {$inputData['id']}";
            $this->db->query($sql);
            return true;
        }
	public function addSubcategory(){
		$id_gallery = (int)$_POST['id_gallery'];
		$name       = mysql_real_escape_string(trim($_POST['name']));
		
		if($id_gallery){
			return $this->db->query('INSERT INTO subcategory (id_cat,name) VALUES('.$id_gallery.',"'.$name.'")');
		}else{
			return false;
		}
	}
	public function delSubcategory(){
		$id = (int)$_POST['id'];
		$this->db->query('UPDATE gallery SET id_subcat = 0 WHERE id_subcat = '.$id);
		$this->db->query('DELETE FROM subcategory WHERE id = '.$id);
		return  0;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TEXTURA	
	public function getTextura($id = 0){
		if($id){
			$res = $this->db->query('SELECT * FROM textura WHERE id = '.$id);
			return $res->row();
		}else{
			$res = $this->db->query('SELECT * FROM textura ORDER BY id_material');
			return $res->result();
		}
	}
	
    public function addMaterial()
    {
        $data = array (
            'name'          => $this->input->post('name', true),
            'description'   => $this->input->post('description', true),
        );
        
        $this->db->insert('type_material', $data);
    }
    
    public function editMaterial($id)
    {
        $data = array (
            'name'          => $this->input->post('name', true),
            'description'   => $this->input->post('description', true),
        );
        $this->db->where('id', $id);
        $this->db->update('type_material', $data);
    }
    
    public function getMaterialById($id)
    {
        return $this->db->get_where('type_material', array('id' => $id))->row();
    }

  
  
  
  
  
    public function addTextura(){
		$name           = mysql_real_escape_string(trim($_POST['name']));
		$name_ua        = mysql_real_escape_string(trim($_POST['name_ua']));
		$alt            = mysql_real_escape_string(trim($_POST['alt']));
		$alt_example    = mysql_real_escape_string(trim($_POST['alt_example']));
		$text           = mysql_real_escape_string(trim($_POST['text']));
		$visibility     = (int)$_POST['visibility'];
		$eco            = (float)preg_replace('/,/', '.', $_POST['eco']);
		$latex          = (float)preg_replace('/,/', '.', $_POST['latex']);
		$uf             = (float)preg_replace('/,/', '.', $_POST['uf']);
        
        
        /*new_add*/




$name_eco       = ($_POST['name_mater_e']);
        $name_latex     =  ($_POST['name_mater_l']);
        $name_uf        =   ($_POST['name_mater_u']);
        
        
        
        /*end_new_add*/
        
        
        $tile_size      = (int)  mysql_real_escape_string(trim($_POST['tile_size']));
		//$id_maretial    = (int) $this->input->post('id_material', true);
        
        
        $id_maretial    = $this->input->post('id_material', true);

/*

echo "<pre>";    
print_r($id_maretial);    
echo "</pre>";    
  */  
        
        
		$textura = $_FILES['textura'];
		$example = $_FILES['example'];
		
		$wm = ROOT.'/img/wm.png';
        

//echo ROOT;
		//проверяем существует ли папка TEXTURA
		if(!is_dir(ROOT.'/img/textura')){
			mkdir(ROOT.'/img/textura', 0777);
		}
		chmod(ROOT.'/img/textura', 0755);
		define("TEXTURA", ROOT.'/img/textura/');






//print_r($_FILES);
/*
echo "<pre>";    
echo $id_maretial;    
echo "</pre>";   
echo $name_eco;
echo $name_latex;
echo $name_uf;
*/



//print_r($this->input->post('id_material'));

/*
print_r($_REQUEST);
echo $id_maretial;  

echo "<br>";
echo "<pre>";
echo $name;echo "<br>";
echo $alt;echo "<br>";
echo $alt_example;echo "<br>";
echo $text;echo "<br>";
echo $eco;echo "<br>";
echo $latex;echo "<br>";
echo $uf;echo "<br>";
echo $visibility;echo "<br>";
echo $tile_size;echo "<br>";

echo $id_maretial;  echo "<br>";



echo $name_eco;echo "<br>";
echo $name_latex;echo "<br>";
echo $name_uf;echo "<br>";
echo "</pre>"; 

echo "<br>";
*/
//echo $id_material;


                                          
      

/*		
$this->db->query('INSERT INTO textura (name, alt, alt_example, text, eco, latex, uf, visibility, tile_size, id_material, name_mater_eco, name_mater_latex, name_mater_uf) 
									    VALUES("'.$name.'", 
											   "'.$alt.'", 
											   "'.$alt_example.'", 
											   "'.$text.'", 
											    '.$eco.', 
												'.$latex.', 
												'.$uf.',
												'.$visibility.',
                                                '.$tile_size.',
                                                '.$id_maretial.',                                                
                                               	"'.$name_eco.'",
												"'.$name_latex.'",
                                                "'.$name_uf.'")');
*/



/*
	$this->db->query('UPDATE textura SET name = "'.$name.'", 
											  alt = "'.$alt.'", 
									  alt_example = "'.$alt_example.'", 
									         text = "'.$text.'", 
											  eco =  '.$eco.', 
											latex =  '.$latex.', 
                                            
  name_mater_eco = "'.$name_eco.'", 
                                      name_mater_latex = "'.$name_latex.'", 
                                      name_mater_uf = "'.$name_uf.'", 
                                      
                                            
                                            
                                            
											   uf =  '.$uf.',
									   visibility =  '.$visibility.',
                                        tile_size = '.$tile_size.',
                                      id_material = '. $id_material .'
									     WHERE id =  '.$id);
*/





/*
		
$this->db->query('INSERT INTO textura (name, alt, alt_example, text, eco, latex, uf, visibility, tile_size, id_material, name_mater_eco, name_mater_latex, name_mater_uf) 
									    VALUES("'.$name.'", 
											   "'.$alt.'", 
											   "'.$alt_example.'", 
											   "'.$text.'", 
											    '.$eco.', 
												'.$latex.', 
												'.$uf.',
												'.$visibility.',
                                                '.$tile_size.',
                                                '.$id_maretial.',                                                
                                               	"'.$name_eco.'",
												"'.$name_latex.'",
                                                "'.$name_uf.'")');

*/


$this->db->query("SET @@GLOBAL.sql_mode= ''");
$this->db->query("SET @@SESSION.sql_mode= ''");



/*SET @@GLOBAL.sql_mode= ''
SET @@SESSION.sql_mode= ''*/


 $insert = array(
    'name'=>$name,
    'alt'=>$alt,
    'alt_example'=>$alt_example,
    
    
    'text'=>$text,
    'eco'=>$eco,
    
    'latex'=>$latex,
    'uf'=>$uf,
    'visibility'=>$visibility,
    'tile_size'=>$tile_size,
    
    
    
    'id_material'=>$id_maretial,
    'name_mater_eco'=>$name_eco,
    'name_mater_latex'=>$name_latex,
    'name_mater_uf'=>$name_uf
    );


//var_dump($insert);


    $this->db->insert('textura',$insert);

	$res = $this->db->query('SELECT id FROM textura ORDER BY id DESC')->row();
		
        
        
                if(!is_dir(ROOT.'/img/textura/'.$res->id)){
			mkdir(ROOT.'/img/textura/'.$res->id, 0777);
		}
                          
        
		if($textura['error'] == 0){

print_r($resize->$textura['tmp_name'], TEXTURA.$res->id.'.jpg', 700);

                        $this->my_imagemagic->resize($textura['tmp_name'], TEXTURA.$res->id.'.jpg', 700);
			$this->my_imagemagic->resize_2($textura['tmp_name'], TEXTURA.'thumb_l_'.$res->id.'.jpg', 350, 323);
                        
			$this->my_imagemagic->crop($textura['tmp_name'], TEXTURA.'thumb_m_'.$res->id.'.jpg', 195, 65); //обрезка
                        $this->my_imagemagic->wm(TEXTURA.$res->id.'.jpg', TEXTURA.$res->id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->wm(TEXTURA.'thumb_l_'.$res->id.'.jpg', TEXTURA.'thumb_l_'.$res->id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_square(TEXTURA.'thumb_l_'.$res->id.'.jpg', TEXTURA.'thumb_s_'.$res->id.'.jpg', 82);
            
            
            
                        
		}
        
        
    
		if($example['error'] == 0){
			$this->my_imagemagic->resize($example['tmp_name'], TEXTURA.'example_'.$res->id.'.jpg', 350);
			$this->my_imagemagic->wm(TEXTURA.'example_'.$res->id.'.jpg', TEXTURA.'example_'.$res->id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_square(TEXTURA.'example_'.$res->id.'.jpg', TEXTURA.'example_s_'.$res->id.'.jpg', 82);
		}
		    echo "vse ok";    
die();

		return 1;
	}
/*end_addTextura*/    
    
    
    
    
    
    
    
	
	public function editTextura(){
		$id             = (int)$_POST['id'];
		$name           = mysql_real_escape_string(trim($_POST['name']));
		$alt            = mysql_real_escape_string(trim($_POST['alt']));
		$alt_example    = mysql_real_escape_string(trim($_POST['alt_example']));
		$text           = mysql_real_escape_string(trim($_POST['text']));
		$visibility     = (int)$_POST['visibility'];
		$eco            = (float)preg_replace('/,/', '.', $_POST['eco']);
        
         /*new_upd*/
        
        $name_eco       = preg_replace('/,/', '.', $_POST['name_mater_eco']);
        $name_latex     = preg_replace('/,/', '.', $_POST['name_mater_latex']);
        $name_uf        = preg_replace('/,/', '.', $_POST['name_mater_uf']);
        
        /*end_new_upd*/
        
        
		$latex          = (float)preg_replace('/,/', '.', $_POST['latex']);
		$uf             = (float)preg_replace('/,/', '.', $_POST['uf']);
        $tile_size      = (int)  mysql_real_escape_string(trim($_POST['tile_size']));
        $id_material    = (int) $this->input->post('id_material', true);
		$textura = $_FILES['textura'];
		$example = $_FILES['example'];
		
		$res = $this->db->query('SELECT * FROM textura WHERE id = '.$id)->row();
		define("TEXTURA", ROOT.'/img/textura/');
		
		if($textura['error'] == 0){
                        $this->my_imagemagic->resize($textura['tmp_name'], TEXTURA.$res->id.'.jpg', 700);
                        $this->my_imagemagic->crop($textura['tmp_name'], TEXTURA.'thumb_l_'.$res->id.'.jpg', 350, 323);
			$this->my_imagemagic->crop($textura['tmp_name'], TEXTURA.'thumb_m_'.$res->id.'.jpg', 195, 65); //обрезка
			$this->my_imagemagic->wm(TEXTURA.'thumb_l_'.$res->id.'.jpg', TEXTURA.'thumb_l_'.$res->id.'.jpg', ROOT.'/img/wm.png');
                        $this->my_imagemagic->wm(TEXTURA.$res->id.'.jpg', TEXTURA.$res->id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_square(TEXTURA.'thumb_l_'.$res->id.'.jpg', TEXTURA.'thumb_s_'.$res->id.'.jpg', 82);
		}
		
		if($example['error'] == 0){
			$this->my_imagemagic->resize($example['tmp_name'], TEXTURA.'example_'.$res->id.'.jpg', 350);
			$this->my_imagemagic->wm(TEXTURA.'example_'.$res->id.'.jpg', TEXTURA.'example_'.$res->id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_square(TEXTURA.'example_'.$res->id.'.jpg', TEXTURA.'example_s_'.$res->id.'.jpg', 82);
		} 


		
		$this->db->query('UPDATE textura SET name = "'.$name.'", 
											  alt = "'.$alt.'", 
									  alt_example = "'.$alt_example.'", 
									         text = "'.$text.'", 
											  eco =  '.$eco.', 
											latex =  '.$latex.', 
                                            
  name_mater_eco = "'.$name_eco.'", 
                                      name_mater_latex = "'.$name_latex.'", 
                                      name_mater_uf = "'.$name_uf.'", 
                                      
                                            
                                            
                                            
											   uf =  '.$uf.',
									   visibility =  '.$visibility.',
                                        tile_size = '.$tile_size.',
                                      id_material = '. $id_material .'
									     WHERE id =  '.$id);
		
		return;
	}
	public function delTextura(){
		$res = $this->db->query('SELECT * FROM textura WHERE id = '.(int)$_POST['id'])->row();
		if($res){
			@unlink(ROOT.'/img/textura/example_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/textura/example_s_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/textura/thumb_l_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/textura/thumb_m_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/textura/thumb_s_'.$res->id.'.jpg');
                        @unlink(ROOT.'/img/textura/'.$res->id.'.jpg');
			$this->db->query('DELETE FROM textura WHERE id = '.$res->id);
			return 0;
		}else{
			return 'Такого ID нету!';
		}
	}
    
    public function delMaterial()
    {
        $id = $this->input->post('id', true);
        $this->db->delete('type_material', array('id' => $id));
        return 0;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////INTERIOR
	public function getTypeInterior($id = 0){
		if($id){
			return $this->db->query('SELECT * FROM type_interior WHERE id = '.$id)->row();
		}else{
			return $this->db->query('SELECT * FROM type_interior')->result();
		}
	}
	public function addTypeInterior(){
		$name    = mysql_real_escape_string(trim($_POST['name']));
		$this->db->query('INSERT INTO type_interior (name) VALUES("'.$name.'")');
	}
	public function updateTypeInterior(){
		$id      = (int)$_POST['id'];
		$name    = mysql_real_escape_string(trim($_POST['name']));
		$this->db->query('UPDATE type_interior SET name = "'.$name.'" WHERE id = '.$id);
		return;
	}
	public function delTypeInterior(){
		$id = (int)$_POST['id'];
		$this->db->query('DELETE FROM type_interior WHERE id = '.$id);
		return;
	}
	public function getInterior($id = 0){
		if($id){
			return $this->db->query('SELECT interior.*, (SELECT id_cat FROM gallery WHERE gallery.articul = interior.articul_parent LIMIT 1) AS id_cat FROM interior WHERE interior.id = '.$id)->row();
		}else{
			return $this->db->query('SELECT interior.*, (SELECT id_cat FROM gallery WHERE gallery.articul = interior.articul_parent LIMIT 1) AS id_cat FROM interior')->result();
		}
	}
	public function getInteriorLimit($type = 0){
		$v = 50;
		
		$start = (int)@$_GET['page'];
		$start = $v * ($start = $start >= 1 ? $start - 1 : $start);

		$limit = ' LIMIT '.$start.','.$v.' ';
		
		if($type){
			$where = ' WHERE type = '.$type.' ';
		}else{
			$where = '';
		}
		
		$res = $this->db->query('SELECT interior.*, (SELECT id_cat FROM gallery WHERE gallery.articul = interior.articul_parent LIMIT 1) AS id_cat FROM interior '.$where.' '.$limit);
		return $res->result();
	}
	public function getInteriorOfType($type=0){
		return $this->db->query('SELECT interior.*, (SELECT id_cat FROM gallery WHERE gallery.articul = interior.articul_parent LIMIT 1) AS id_cat FROM interior WHERE type = '.$type)->result();
	}
	public function addInterior()
	{
		$type    = (int)$_POST['type_interior'];
		$parent  = mysql_real_escape_string(trim($_POST['parent']));
		$alt     = mysql_real_escape_string(trim($_POST['alt']));
		$text    = mysql_real_escape_string(trim($_POST['text']));
		
		$this->db->query('INSERT INTO interior (articul_parent,type,alt,text) 
							   VALUES("'.$parent.'", '.$type.', "'.$alt.'", "'.$text.'")');
		$name = $this->db->query('SELECT LAST_INSERT_ID() AS last')->row()->last;
		
		$interior = $_FILES['interior'];
		
		//проверяем существует ли папка INTERIOR
		if(!is_dir(ROOT.'/img/interior')){
			mkdir(ROOT.'/img/interior', 0755);
		}

		define("INTERIOR", ROOT.'/img/interior/');
		
		if($interior['error'] == 0){
			$this->my_imagemagic->resize($interior['tmp_name'],              INTERIOR.'thumb_l_'.$name.'.jpg', 580);
			$this->my_imagemagic->wm(INTERIOR.'thumb_l_'.$name.'.jpg',       INTERIOR.'thumb_l_'.$name.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_2(INTERIOR.'thumb_l_'.$name.'.jpg', INTERIOR.'thumb_m_'.$name.'.jpg', 365, 365);
			$this->my_imagemagic->resize_square($interior['tmp_name'],       INTERIOR.'thumb_s_'.$name.'.jpg', 82);
		}
	}
	public function updateInterior(){
		$id      = (int)$_POST['id'];
		$type    = (int)$_POST['type_interior'];
		$parent  = mysql_real_escape_string(trim($_POST['parent']));
		$alt     = mysql_real_escape_string(trim($_POST['alt']));
		$text    = mysql_real_escape_string(trim($_POST['text']));
		
		$interior = $_FILES['interior'];
		
		//проверяем существует ли папка INTERIOR
		if(!is_dir(ROOT.'/img/interior')){
			mkdir(ROOT.'/img/interior', 0777);
		}
		chmod(ROOT.'/img/interior', 0755);
		define("INTERIOR", ROOT.'/img/interior/');
		
		if($interior['error'] == 0){
			$this->my_imagemagic->resize($interior['tmp_name'],              INTERIOR.'thumb_l_'.$id.'.jpg', 580, 90);
			$this->my_imagemagic->wm(INTERIOR.'thumb_l_'.$id.'.jpg',         INTERIOR.'thumb_l_'.$id.'.jpg', ROOT.'/img/wm.png');
			$this->my_imagemagic->resize_2(INTERIOR.'thumb_l_'.$id.'.jpg',   INTERIOR.'thumb_m_'.$id.'.jpg', 365, 365, 90);
			$this->my_imagemagic->resize_square($interior['tmp_name'],       INTERIOR.'thumb_s_'.$id.'.jpg', 82);
		}
		
		$this->db->query('UPDATE interior SET 
								  articul_parent = "'.$parent.'",
									        type = '.$type.',
										     alt = "'.$alt.'",
										    text = "'.$text.'"
										WHERE id = '.$id);
	}
	public function delInterior(){
		$res = $this->db->query('SELECT * FROM interior WHERE id = '.(int)$_POST['id'])->row();
		if($res){
			@unlink(ROOT.'/img/interior/thumb_l_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/interior/thumb_m_'.$res->id.'.jpg');
			@unlink(ROOT.'/img/interior/thumb_s_'.$res->id.'.jpg');
			$this->db->query('DELETE FROM interior WHERE id = '.$res->id);
			return 0;
		}else{
			return 'Такого ID нет!';
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// IVAN 30.04.2013
	public function hidden_all_images($id_cat, $value)
	{
		$this->db->query('UPDATE gallery SET visibility = '.$value.' WHERE id_cat = '.$id_cat.' ');
		return;
	}
        
	public function m_downloadAlt($id_cat)
	{
		return $this->db->query('SELECT * FROM gallery WHERE id_cat = '.$id_cat.' ')->result_array();
	}
	///16.05.2013
        public function mloading_sale_images()
        {
            $article = mysql_real_escape_string(trim($_POST['article_image']));
            $width   = mysql_real_escape_string(trim($_POST['width']));
            $height  = mysql_real_escape_string(trim($_POST['height']));
            $texture = mysql_real_escape_string(trim($_POST['texture']));
            $old_price = mysql_real_escape_string(trim($_POST['old_price']));
            $new_price = mysql_real_escape_string(trim($_POST['new_price']));
            $alt     = mysql_real_escape_string(trim($_POST['alt']));
            $type_act= mysql_real_escape_string(trim($_POST['type_act']));
            $id_img      = mysql_real_escape_string(trim($_POST['id_img']));
            
            if($type_act == 'add')
            {
                $this->db->query('INSERT INTO sale(article, width, height, texture, old_price, new_price, alt)
                                    VALUE ("'.$article.'","'.$width.'","'.$height.'","'.$texture.'","'.$old_price.'","'.$new_price.'","'.$alt.'")');
            }
            elseif($type_act == 'edit')
            {
               $this->db->query('UPDATE sale SET   article = "'.$article.'",
                                                    width   = "'.$width.'",
                                                    height  = "'.$height.'",
                                                    texture = "'.$texture.'",
                                                    old_price="'.$old_price.'",
                                                    new_price="'.$new_price.'",
                                                    alt     = "'.$alt.'"
                                                WHERE id = '.$id_img.'');
                
            }
            else
            {
                return $this->db->query('SELECT * FROM sale')->result();
            }
        }
        
        public function medit_sale_images($id)
        {
            return $this->db->query('SELECT * FROM sale WHERE id = '.$id.' ')->row();
        }
        public function mdelete_sale_image($id)
        {
             $this->db->query('DELETE FROM sale WHERE id = '.$id.' ');
        }
        
         /**************** Ivan 23.07.2013 ********************/ 
        public function GetAllReviews()
        {
            $fetch = $this->db->query('SELECT * FROM reviews ORDER BY visibility ASC');
            return $fetch->result();
        }
        
        public function AddNewReview($data_for_addition)
        {
            //mysql_real_escape_string();
            $this->db->query('INSERT INTO reviews(name, create_date, pub_date, comments, visibility, phone, email) VALUES ("' .mysql_real_escape_string($data_for_addition['client_name']). '",
                                                                                                  ' .$data_for_addition['date_creation']. ', 
                                                                                                  ' .$data_for_addition['date_publication']. ',
                                                                                                 "' .mysql_real_escape_string($data_for_addition['review']). '",
                                                                                                  ' .$data_for_addition['value_of_commit']. ',
                                                                                                 "' .mysql_real_escape_string($data_for_addition['phone']). '",
                                                                                                 "' .mysql_real_escape_string($data_for_addition['email']). '" ) ');
        }
        
        public function GetCommentById($id)
        {
            $comment = $this->db->query('SELECT id, name, comments, phone, email, answers FROM reviews WHERE id = ' .$id. ' ');
            return $comment->row();
        }
        
        public function EditReview($data_for_editing, $id)
        {
            $this->db->query('UPDATE reviews 
                                    SET name = "'.mysql_real_escape_string($data_for_editing['client_name']).'", 
                                        comments = "'.mysql_real_escape_string($data_for_editing['review']).'", 
                                        pub_date = '.$data_for_editing['date_creation'].',
                                        phone = "'.mysql_real_escape_string($data_for_editing['phone']).'",
                                        email = "'.mysql_real_escape_string($data_for_editing['email']).'",
                                        answers = "'.mysql_real_escape_string($data_for_editing['answer']).'"
                                    WHERE id = '.$id.' ');
        }
        
        public function delReview($id)
        {
            $this->db->query('DELETE FROM reviews WHERE id = ' .$id. ' ');
            return 0;
        }
	
    

public function sel_bigst_cat ($data)
{
//echo "sel_bigst_cat";    
$query = $this->db->get('bigstock_cat_id');
//$this->db->query('select FROM bigstock_cat_id');
foreach ($query->result() as $row)
{
    //$car_sec = $row->name;
$diff[] = $row->name;   
} 
//print_r($diff);
$data = array(
'mass_bigstok_bd'=>$diff
);


return $data;



    
    
}/*end_sel_bigst_cat*/ 
/**
 * 
 * @param type $name
 * @return type
 * полусаем АйДи категории по ее имени
 * 
 */
public function getCatId($name = ''){
    $data = array();
    $this->db->select('id_cat');
    $this->db->where('name',$name);
    $query = $this->db->get('bigstock_cat_id');
    if ($query->num_rows()>0){
     $row = $query->row_array();
     $data = $row['id_cat'];
    }
    $query->free_result();
   
    return $data;
}/**/

public function checkImage($image_id = 0,$cat_id = 0){
    $data = 0;
    $this->db->select('id_img');
    $this->db->where('id_img',$image_id);
        $this->db->where('id_cat',$cat_id);
    $query = $this->db->get('bigstock_img');
    if ($query->num_rows()>0){
     $row = $query->row_array();
     $data = $row['id_img'];
    }
    $query->free_result();
    return $data;
}/**/

public function insert_bigst_phot ($data = array(),$cat_name = '')
{
  //  var_dump($data); 


   $cat_id = $this->getCatId($cat_name);
/*echo "<pre>";
var_dump($image);
echo "</pre>";
  */ 
   
   
  
if ($cat_id)
foreach ($data as $key => $image)
{
    if (isset($image['rdi']) && $image['rdi'] == 1){
//echo 'есть радио';
if (!$this->checkImage($image['id'],$cat_id)){
    $insert = array(
    'id_img'=>$image['id'],
    'id_cat'=>$cat_id,
    'url'=>$image['href'],
    
    /*я дописал*/
    
    'width'=>$image['href_width'],
    'height'=>$image['href_height'],
    
//    'title'=>$image['desc'],
'title'=>$image['desc_de'],
'title_en'=>$image['desc_en'],
'title_fr'=>$image['desc_fr'],
'title_it'=>$image['desc_it'],
'title_es'=>$image['desc_es'],
'title_pl'=>$image['desc_pl'],
    
    
    
    'prew_url'=>$image['prev'],
    'prew_width'=>$image['prev_width'],
    'prew_height'=>$image['prev_height']
    
    
    
);
//var_dump($insert);
    $this->db->insert('bigstock_img',$insert);
    echo "<pre>";
echo "Фотографии добавлены, перейдите на предыдущую страницу";
echo "</pre>";
}
    }// end if image rdi
    
} 

}/**/    






public function del_bigst_phot ($data = array(),$cat_name = '')
{
  //  var_dump($data); 


   $cat_id = $this->getCatId($cat_name);
/*echo "<pre>";

echo "</pre>";
  */ 
  
   




  
if ($cat_id)
foreach ($data as $key => $image)
{
    if (isset($image['rdi']) && $image['rdi'] == 1){

 //var_dump($image['rdi']);
echo 'есть радио';


//print_r($image['id']);
//print_r($cat_id);

    $del = array(
    'id_img'=>$image['id']    
);
//var_dump($insert);
$this->db->delete('bigstock_img', $del); 
    //$this->db->insert('bigstock_img',$del);



    }// end if image rdi
    
} 

    echo "<pre>";
echo "Фотографии удалены, перейдите на предыдущую страницу";
echo "</pre>";


}/**/  







public function m_sel_all($urll='')
{
    

//print_r($urll);
echo $urll;


  $da = array();
    $this->db->select('id_cat');
    $this->db->where('name',$urll);
    $query = $this->db->get('bigstock_cat_id');
    if ($query->num_rows()>0){
     $row = $query->row_array();
     $da = $row['id_cat'];
    
    }
    $query->free_result();
  //print_r($da);
 
 echo $da;
 
 
 
 
 
 
 
$query_sec = $this->db->query('SELECT id_img, url, prew_url, title from bigstock_img WHERE id_cat = "'.$da.'"');

 foreach ($query_sec->result() as $roww)
{
    //$car_sec = $row->name;
//$diffs[] = $roww->url; 

$diffs[] = $roww;


/*
echo "<pre>";
print_r($query_sec);
echo "</pre>";
*/
}

if ($query_sec->num_rows()>0){ 
  //  if (empty($query_sec)){
        echo "В этой категории картинки есть"; 
 
    } else {
  $diffs = 0;     
echo "В этой категории картинок нет";        
    }
 

 
 
$data = array(
'select_fhot_cate'=>$diffs

);

//die();
return $data; 
 
 
 
  
}/*m_sel_all*/    







}/*end of Model*/









    

?>