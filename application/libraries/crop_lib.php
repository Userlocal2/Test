<?php
class Crop_lib{

	public function image(){

		$CI =& get_instance();
		
		$obj = json_decode($_POST['process'], true);
		if(!$obj){echo false;exit;}
		
		//process	{"color": 0, "flip": 0, "img": "1230", "textura": "1"}
		
		$articul = mysql_real_escape_string($obj['img']);
		$res = $CI->db->query('SELECT * FROM gallery WHERE articul = "'.$articul.'"')->row();
		//есть ли токое изображение
		if(!$res){echo false;exit;}
		
		$archiv   = '/img/archiv/'.$res->id_cat.'/'.$res->articul.'.jpg';
		$original = '/img/gallery/'.$res->id_cat.'/thumbs/thumb_l_'.$res->articul.'.jpg';
		
		$textura = $obj['textura'].'|';
		$flip    = $obj['flip'] == 1 ? '|flip|' : '';
		$color   = $obj['color'] === 'sepia' ? '|sepia|' : ($obj['color'] === 'black' ? '|black|' : ($obj['color'] === 'sepia' ? '|sepia|' : ($obj['color'] === 'negativ' ? '|negativ|' : '')));
		
		//проверка наличие текстуры
		$layer = ROOT.'/img/layer/'.$obj['textura'].'.png';
		$isset_textura = is_file($layer) ? true : false;

		//есть ли параметров нет - отдаём оригинал
		if(empty($flip) && empty($color) && !$isset_textura){echo json_encode($original);exit;}
		
		$path = '/img/temp/'.$textura.$flip.$color.$res->articul.'.jpg';
		//$path = '/img/temp/'.$flip.$color.$res->articul.'.jpg';
		
		//если уже есть такое изображение отдаём(чтобы не гонять сервер)
		if(is_file(ROOT.$path)){echo json_encode($path);exit;}
		
		////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////делаем дубликаты
		
		//есть ли такая папка
		$temp = ROOT.'/img/temp';
		if(!is_dir($temp)){
			mkdir($temp, 0755);
		}
		
		//чтобы WM сидел нормально
		$CI->my_imagemagic->upload_2(ROOT.$archiv, ROOT.$path);
		
		if($flip){
			$CI->my_imagemagic->image_flip(ROOT.$path, ROOT.$path);
		}
		if($color == '|black|'){
			$CI->my_imagemagic->black_white(ROOT.$path, ROOT.$path);
		}
		if($color == '|sepia|'){
			$CI->my_imagemagic->sepia(ROOT.$path, ROOT.$path);
		}
		if($color == '|negativ|'){
			$CI->my_imagemagic->negativ(ROOT.$path, ROOT.$path);
		}
		if($isset_textura){
			$CI->my_imagemagic->textura(ROOT.$path, ROOT.$path, $layer);
		}
		
		//налаживаем WM ROOT.$path
		$CI->my_imagemagic->wm(ROOT.$path, ROOT.$path, ROOT.'/img/wm.png');
		
		echo json_encode($path);
		exit;
	}
	
}//END
?>
