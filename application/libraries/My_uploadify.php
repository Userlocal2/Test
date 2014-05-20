<?php
class My_uploadify{
	
	public function multiUpload(){
		$CI =& get_instance();
                 
		$data = $_FILES['Filedata'];
		$wm   = ROOT.'/img/wm.png';
		
		//проверяем существует ли папка GALLERY
		if(!is_dir(ROOT.'/img/gallery')){
			mkdir(ROOT.'/img/gallery', 0755);
		}
		define("GALLERY", ROOT.'/img/gallery/');
		
		
		if(isset($_POST['cat'])){
			$id_cat = (int)$_POST['cat'];
			$cat = GALLERY.$id_cat;
			//проверяем существует ли папка категории
			if(!is_dir($cat)){
				mkdir($cat, 0755);
			}
			//@chmod($cat, 0777);
		}else{
			echo 0;
			exit;
		}
		
		list($articul, $type) = explode('.', $data['name']);
		$name = $articul.'.jpg';
		
		//проверка, есть ли изображение с таким АРТИКУЛОМ
		if($CI->db->query('SELECT * FROM gallery WHERE id_cat = '. $id_cat.' AND articul = "'.$articul.'"')->row()){echo 0;exit;}
		
		
		//в архив(archiv) для обработки(зеркальное,черно-белое,сепия)
		$archiv = ROOT.'/img/archiv/';
		if(!is_dir($archiv)){
			mkdir($archiv, 0700);
		}
		//@chmod($archiv, 0777);
		$archiv = $archiv.$id_cat.'/';
		if(!is_dir($archiv)){
			mkdir($archiv, 0700);
		}
		//@chmod($archiv, 0777);
		$CI->my_imagemagic->resize($data['tmp_name'], $archiv.$name, 580);
		//-----------------------------------------------------------
		
		
		$CI->my_imagemagic->resize($data['tmp_name'], $cat.'/'.$name, 580);
		
		$watermark = 0;
		if($_POST['wm']){
			$CI->my_imagemagic->wm($cat.'/'.$name, $cat.'/'.$name, $wm);
			$watermark = 1;
		}
		
		//================================================================THUMBs
		
		$thumbs = $cat.'/thumbs';
		if(!is_dir($thumbs)){
			mkdir($thumbs, 0755);
		}
		//@chmod($thumbs, 0777);
		
		$CI->my_imagemagic->resize($cat.'/'.$name, $thumbs.'/thumb_l_'.$name, 580, 90);
		$CI->my_imagemagic->resize_2($data['tmp_name'], $thumbs.'/thumb_m_'.$name, 240, 200, 90);
		$CI->my_imagemagic->resize_square($data['tmp_name'], $thumbs.'/thumb_s_'.$name, 82, 90);
		$CI->my_imagemagic->resize_background($data['tmp_name'], $thumbs.'/thumb_sb_'.$name, 82, 82, 0xF2F2DE, 90);
		
		//Заносим в базу
		list($width, $height) = @getimagesize($thumbs.'/thumb_l_'.$name);
		$colors = $CI->my_imagemagic->colorator($thumbs.'/thumb_m_'.$name);
		
		$CI->db->query('INSERT INTO gallery (id_cat, articul, red, orange, yellow, green, azure, blue, violet, pink, white, grey, black, brown, dt, width, height,wm) 
						  VALUES (
							'.$id_cat.',
							"'.$articul.'",
							'.$colors['red'].',
							'.$colors['orange'].',
							'.$colors['yellow'].',
							'.$colors['green'].',
							'.$colors['azure'].',
							'.$colors['blue'].',
							'.$colors['violet'].',
							'.$colors['pink'].',
							'.$colors['white'].',
							'.$colors['grey'].',
							'.$colors['black'].',
							'.$colors['brown'].',
							'.time().',
							'.$width.',
							'.$height.',
							'.$watermark.'
						  )');
						  
		@unlink($cat.'/'.$name);

		echo 1;
		exit;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__UPLOAD FOR_PAGES	
	public function multiUploadForPages(){
	
		$CI =& get_instance();
		
		$wm     = (int)$_POST['wm'] ? 1 : 0;
		$width  = (int)$_POST['width'] ? (int)$_POST['width'] : 0;
		$height = (int)$_POST['height'] ? (int)$_POST['height'] : 0;
		
		$images = $_FILES['Filedata'];

		if($images['error'] == 0){
			$dir = ROOT.'/img/for_page/';
			$op_dir = opendir($dir);
			while($file = readdir($op_dir)){
				if(is_file($dir.$file)){
					if(basename($dir.$file) == $images['name']){
						echo 0;
						exit;
					}
				}
			}
			
			$name = preg_replace('/\.[a-z]{3,4}$/i', '', $images['name']);
			
			//проверяем существует ли папка FOR_PAGE
			if(!is_dir(ROOT.'/img/for_page')){
				mkdir(ROOT.'/img/for_page', 0755);
			}
			//проверяем существует ли папка MINI
			if(!is_dir(ROOT.'/img/for_page/mini')){
				mkdir(ROOT.'/img/for_page/mini', 0755);
			}
		
			//для превьюшки в админке
			$CI->my_imagemagic->resize($images['tmp_name'], ROOT.'/img/for_page/mini/'.$name.'.jpg', 100, 70);
			
			
			$new = $images['tmp_name'];
			if($wm){
				$new = ROOT.'/img/for_page/'.$name.'.jpg';
				$CI->my_imagemagic->wm($images['tmp_name'], $new, ROOT.'/img/wm.png');
			}
			
			if($width && $height){
				$CI->my_imagemagic->resize_2($new, ROOT.'/img/for_page/'.$name.'.jpg', $width, $height);
			}
			if(!$width && !$height){
				$CI->my_imagemagic->upload($new, ROOT.'/img/for_page/'.$name.'.jpg');
			}else{
				$CI->my_imagemagic->resize($new, ROOT.'/img/for_page/'.$name.'.jpg', max($width, $height));
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////__UPLOAD TEXTURA GALLERY
	public function multiUploadTextura(){
		$CI =& get_instance();
		
		$textura = (int)$_POST['textura_gallery'];
		if(!$textura){echo 0;exit;}
		
		$wm = ROOT.'/img/wm.png';
		$images = $_FILES['Filedata'];
		if($images['error'] != 0){echo 0;exit;}
		
		$dir = ROOT.'/img/textura/'.$textura.'/';
		if(!is_dir($dir)){mkdir($dir, 0755);}
		
		$mini = ROOT.'/img/textura/'.$textura.'/mini/';
		if(!is_dir($mini)){mkdir($mini, 0755);}
		
		$arr = array();
		$op_dir = opendir($dir);
		while($file = readdir($op_dir)){
			if(is_file($dir.$file)){
				$arr[] = str_replace(".jpg", "", $file); 
			}
		}
		sort($arr);
		if(count($arr)){
			$item = array_pop($arr) + 1;
		}else{
			$item = 1;
		}
		
		$CI->my_imagemagic->upload_2($images['tmp_name'], ROOT.'/img/textura/'.$textura.'/'.$item.'.jpg');
		$CI->my_imagemagic->wm(ROOT.'/img/textura/'.$textura.'/'.$item.'.jpg', ROOT.'/img/textura/'.$textura.'/'.$item.'.jpg', $wm);
		
		$CI->my_imagemagic->resize_square($images['tmp_name'], ROOT.'/img/textura/'.$textura.'/mini/'.$item.'.jpg', 100);
		
		
		echo 1;
		exit;
	}
	
	
}//end class
?>