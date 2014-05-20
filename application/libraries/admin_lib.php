<?php
class Admin_lib
{
	public function admin_view($type,$data)
	{
		$CI =& get_instance();
		
		$CI->load->view('admin/parts/a_header.php', $data);
		$CI->load->view('admin/'.$type.'.php');
	}
	
	public function translit($str)
	{
		$tr = array(
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
			"Д"=>"D","Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
			"Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
			"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
			"У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
			"Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
			"Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
			"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"j",
			"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
			"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
			"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
			"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
	   "."=>"."," "=>"-","?"=>"-","/"=>"-","\\"=>"-",
	   "*"=>"-",":"=>"-","*"=>"-","\""=>"-","<"=>"-",
	   ">"=>"-","|"=>"-","("=>"",")"=>"",","=>""
		);
		return strtr($str,$tr);
	}
	
	public function clean_tmp(){
		$dir = ROOT.'/tmp1/';
		$op_dir = opendir($dir);
		while($file = readdir($op_dir)){
			if(is_file($dir.$file)){
				unlink ($dir.$file);
			}
		}
	}
	//==================================================================PAGIN
	public function Pagin($count, $page){
		$view = array(0=>100,1=>1000);
		$view = $view[(int)@$_GET['view_gallery']];
		
		$allPage = ceil($count/$view); //всего страниц 
		if($allPage == 1){return;}
		
		//первое и последнее значение
		$prev = $page == 0 || $page == 1 ? '' : '<a href="/administrator/gallery?'.(isset($_GET['hidden']) ? 'hidden' : 'id_cat').'='.(int)@$_GET['id_cat'].'&view_gallery='.(int)@$_GET['view_gallery'].'&page='.($page-1).'">&laquo;</a>';
		$next = $page == $allPage ? '' : '<a href="/administrator/gallery?'.(isset($_GET['hidden']) ? 'hidden' : 'id_cat').'='.(int)@$_GET['id_cat'].'&view_gallery='.(int)@$_GET['view_gallery'].'&page='.($page==0?$page+2:$page+1).'">&raquo; </a>';
		
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
				$str .= '<a href="/administrator/gallery/?'.(isset($_GET['hidden']) ? 'hidden' : 'id_cat').'='.(int)@$_GET['id_cat'].'&view_gallery='.(int)@$_GET['view_gallery'].'&page='.$i.'">'.$i.'</a>';
			}
			
		}
		return $str.$next;
	}
	public function Pagin_interior($count, $page){
		$view = 50;
		
		$allPage = ceil($count/$view); //всего страниц 
		if($allPage == 1){return;}
		
		//первое и последнее значение
		$prev = $page == 0 || $page == 1 ? '' : '<a href="/administrator/interior?type_interior='.(int)@$_GET['type_interior'].'&page='.($page-1).'">&laquo;</a>';
		$next = $page == $allPage ? '' : '<a href="/administrator/interior?type_interior='.(int)@$_GET['type_interior'].'&page='.($page==0?$page+2:$page+1).'">&raquo; </a>';
		
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
				$str .= '<a href="/administrator/interior/?type_interior='.(int)@$_GET['type_interior'].'&page='.$i.'">'.$i.'</a>';
			}
			
		}
		return $str.$next;
	}
	
	
}
?>