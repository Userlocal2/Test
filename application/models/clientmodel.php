<?php
class clientModel extends CI_Model{

	function __construct()
    {
        parent::__construct();
    }
    /**
     * 
     */
    public function GetBlockedIP( $remoteIP )
    {
        //unblocked IP address
        $unblockedTime = time();
        $this->db->query("DELETE FROM blocked_ip WHERE expire < {$unblockedTime}");
        
        //fetch blocked IP address
        $sql = "SELECT COUNT(id) as block FROM blocked_ip WHERE ip_address = INET_ATON('{$remoteIP}') AND expire > UNIX_TIMESTAMP(CURRENT_TIMESTAMP) LIMIT 1";
        $blockIP = $this->db->query($sql)->row()->block;
        if( (int)$blockIP == 1 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_INFO
	public function getInfo(){
		return $this->db->query('SELECT * FROM info')->row();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////_FAVORIT
	public function getFavorit(){
		$arr = array();
		if(isset($_COOKIE['favorit'])){
			$cookie = explode("|", $_COOKIE['favorit']);
			for($i = 0; $i < count($cookie); $i++){
				$arr[] = preg_replace("/\[.*\]/", "", $cookie[$i]);
			}
		}
		 
		return $arr;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CATEGORY
	public function getCategory()
	{
		return $this->db->query('SELECT * FROM category WHERE id = '.(int)$_GET['category'])->row();
	}
	public function getAllCategory()
	{
		return $this->db->query('SELECT * FROM category WHERE visibility = 1 ORDER BY `order` ASC')->result();
	}
//======================================================================================================================
	public function getCountGalleryOfCategory($id_cat)
	{
		$hor = $_SESSION['hor'] == 0 ? ' ' : ($_SESSION['hor'] == 1 ? ' AND height > width ' : ' AND height < width ') ;
		$res = $this->db->query('SELECT id FROM gallery WHERE id_cat = '.$id_cat.$hor.' AND visibility = 1 ');
		return $res->num_rows();
	}
	public function getGalleryOfCategory($id_cat, $start)
	{
		$arrViewCount = array(0=>15, 1=>30, 2=>60);
		$view         = array_key_exists($_SESSION['view_count'], $arrViewCount) ? $_SESSION['view_count'] : 0;
		$view         = $arrViewCount[$view];

		$arrSort      = array(0=>' ORDER BY hits DESC ', 1=>' ORDER BY dt DESC ');
		$sort         = array_key_exists($_SESSION['sort'], $arrSort) ? $_SESSION['sort'] : 0;
		$sort         = $arrSort[$sort];
		$hor          = $_SESSION['hor'] == 0 ? ' ' : ($_SESSION['hor'] == 1 ? ' AND height > width ' : ' AND height < width ') ;

		$start = $view * ($start = $start > 1 ? $start -1 : $start);

		$limit = $view;
		$limit = ' LIMIT '.$start.','.$limit.' ';

		$sql = 'SELECT * FROM gallery WHERE id_cat = '.$id_cat. $hor . ' AND visibility = 1 ' . $sort . $limit;

		$res = $this->db->query($sql);
	
		return $res->result();
	}
	public function getImageGallery($title){
		$title = mysql_real_escape_string(trim($title));
		$res = $this->db->query('SELECT * FROM gallery WHERE articul = "'.$title.'"');
		return $res->row();
	}
	public function getSubcategoryOfCategory($id_cat = 0, $id_subcat = 0){
		if($id_subcat){
			return $this->db->query('SELECT * FROM gallery WHERE id_cat = '.(int)$id_cat.' AND visibility = 1 AND id_subcat = '.(int)$id_subcat)->result();
		}else{
			return $this->db->query('SELECT gallery.*, (SELECT name FROM subcategory WHERE subcategory.id = gallery.id_subcat) AS subcat_name
													   FROM gallery WHERE id_cat = '.(int)$id_cat.' AND id_subcat <> 0 AND gallery.visibility = 1 GROUP BY id_subcat')->result();
		}
	}
	public function getGalleryOfCategoryAndSubcategory($id_subcat = 0){
		if(!$id_subcat){return array();}
		return $this->db->query('SELECT * FROM gallery WHERE id_subcat = ' . $id_subcat.' AND visibility = 1')->result();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////COLOR
	public function getCountColor($color){
		$color = mysql_real_escape_string(trim($color));
		$hor = $_SESSION['hor'] == 0 ? ' ' : ($_SESSION['hor'] == 1 ? ' AND height > width ' : ' AND height < width ');
		$res = $this->db->query('SELECT * FROM gallery WHERE ' . $color . ' > 20  ' . $hor . 'AND visibility = 1 GROUP BY articul');
		return $res->num_rows();
	}
	public function getColor($color, $start)
	{
		$arrViewCount = array(0=>15, 1=>30, 2=>60);
		$view         = array_key_exists($_SESSION['view_count'], $arrViewCount) ? $_SESSION['view_count'] : 0;
		$view         = $arrViewCount[$view];

		$sort         = ' ORDER BY '.$color.' DESC ';
		$hor          = $_SESSION['hor'] == 0 ? ' ' : ($_SESSION['hor'] == 1 ? ' AND height > width ' : ' AND height < width ') ;

		$start = $view * ($start = $start > 1 ? $start -1 : $start);

		$limit = $view;
		$limit = ' LIMIT '.$start.','.$limit.' ';

		$sql = 'SELECT * FROM gallery WHERE ' . $color . ' > 20  ' . $hor . 'AND visibility = 1 GROUP BY articul '. $sort . $limit;

		$res = $this->db->query($sql);

		return $res->result();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////PAGES
	public function getAllPages()
	{
		return $this->db->query('SELECT * FROM pages WHERE visibility = 1 ORDER BY `order` ASC')->result();
	}
	public function getPage($id = 0)
	{
		if($id == 0){
			$res = $this->db->query('SELECT * FROM pages WHERE url = "home"');
			return $res->row();
		}else{
			$res = $this->db->query('SELECT *, (SELECT url FROM pages WHERE id = a.id_parent) AS parent_url, (SELECT name FROM pages WHERE id = a.id_parent) AS parent_name FROM pages AS a WHERE id = '.$id);
			//$res = $this->db->query('SELECT * FROM pages WHERE id = '.$id);
			return $res->row();
		}
	}
	public function getHomePage()
	{
		return $this->db->query('SELECT * FROM pages WHERE type = "home"')->row();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEARCH
	public function searchGallery($articul = '', $lang = 'alt')
	{
		$res = $this->db->query('SELECT * FROM gallery WHERE visibility = 1 AND articul = "'.$articul.'" OR MATCH('.$lang.') AGAINST("'.$articul.'" IN BOOLEAN MODE) GROUP BY articul LIMIT 120');
		return $res->result();
	}
	public function loadNextGaallery($word, $start, $limit = 60){
		$start = $start * $limit;
		$res = $this->db->query('SELECT id,id_cat,alt,articul FROM gallery WHERE visibility = 1 AND alt LIKE "%'.$word.'%" GROUP BY articul LIMIT '.$start.','.($limit+1));
		return $res->result();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////TEXTURA
	
    
    public function getTextura($id = 0){
		if($id){
			return $this->db->query('SELECT * FROM textura WHERE id = '.$id)->row().' AND visibility = 1';
		}else{
			return $this->db->query('SELECT * FROM textura WHERE visibility = 1 ORDER BY ordering ASC')->result();
		}
	}
    
    public function getMaterial()
    {
       
       
       /* $this->db->order_by('id', 'ASC');
        return $this->db->get('type_material')->result();*/
        
        
return $this->db->query('select * from
(select *
from type_material 
where id!=8 order by id desc) a
union
select *
from type_material 
where id=8')->result();        
        
        
        
    }






/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////MURAL

    public function getOrder($orderId) {
        return $this->db->query('SELECT * FROM lib_order_info WHERE id = '.(int)$orderId.' LIMIT 1')->row();
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////MURAL



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////MURAL
	public function getMural($id = 0){
		if($id){
			return $this->db->query('SELECT * FROM mural WHERE id = '.$id)->row() .' AND visibility = 1';
		}else{
			return $this->db->query('SELECT * FROM mural WHERE visibility = 1')->result();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////PHOTO_INTERIOR
	public function getCountInterior(){
		$type = (int)@$_SESSION['type_interior'];
		if($type){
			return $this->db->query('SELECT id FROM interior WHERE type = '.$type.' AND visibility = 1')->num_rows();
		}else{
			return $this->db->query('SELECT id FROM interior WHERE visibility = 1')->num_rows();
		}
	}
	public function getInterior($start = 0)
	{
		$sort  = '';
		if(@$_SESSION['type_interior']){
			$sort = ' AND type = '.(int)$_SESSION['type_interior'].' ';
		}

		$limit = 18;
		$start = $limit * ($start = $start > 1 ? $start -1 : $start);
		$limit = ' LIMIT '.$start.','.$limit.' ';

		$sql = 'SELECT * FROM interior WHERE visibility = 1' . $sort . $limit;

		$res = $this->db->query($sql);

		return $res->result();
	}
	public function getTypeInterior($id = 0)
	{
		if($id){
			return $this->db->query('SELECT * FROM type_interior WHERE id = '.$id)->row();
		}else{
			return $this->db->query('SELECT * FROM type_interior')->result();
		}
	}
	public function getInteriorOfImage($articul = 0)
	{
		$articul = mysql_real_escape_string(trim($articul));
		$sql = 'SELECT * FROM interior WHERE articul_parent = "'.$articul.'"';

		return $this->db->query($sql)->result();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////get popular wallpapers
	public function getPopular()
	{
		return $this->db->query('SELECT * FROM gallery WHERE visibility=1 ORDER BY hits2 DESC LIMIT 102')->result();
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////get new wallpapers
	public function getNewImages()
	{
		return $this->db->query('SELECT * FROM gallery WHERE visibility=1 GROUP BY articul ORDER BY dt DESC LIMIT 102')->result();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////IVAN
	public function getSimilarImage($alt='', $language='alt')
	{
	   preg_match("/^\W{6}-/", $alt, $matches);
	   if(!empty($matches))
	   {
		$res = $this->db->query('SELECT * FROM `gallery` WHERE visibility = 1 AND '.$language.' LIKE \'%'.$alt.'%\' GROUP BY articul LIMIT 60');
		return $res->result();
		exit;
	   }
	   else
	   {
		$res = $this->db->query('SELECT * FROM `gallery` WHERE visibility = 1 AND MATCH('.$language.') AGAINST("'.$alt.'" IN BOOLEAN MODE) GROUP BY articul LIMIT 90');
		return $res->result();
		exit;
	   }
	}
        
	/*счетчик кликов заказа*/
	public function mCountOrders()
	{
		$this->db->query('UPDATE number_orders SET number_order =number_order+1 WHERE id = 1');
		return;
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////  SELECT ALL IMAGES FOR SALE
	public function getImagesForSale()
	{
		return $this->db->query('SELECT * FROM sale WHERE 1')->result();
	}
	public function getPageSale()
	{
		return $this->db->query('SELECT * FROM pages WHERE url = \'super-order\' ')->row();
	}
        public function m_sitemap()
        {
            return $this->db->query('SELECT p.name, p.url
                                     FROM pages AS p
                                     WHERE p.visibility = 1 AND p.url <> "karta-sajta"
                                     UNION
                                     SELECT c.name, c.url
                                     FROM category AS c
                                     WHERE c.visibility = 1 ')->result();
        }
        
        /********** Ivan 24.07.2013 ********/
        public function FetchAllReviews()
        {
            $fetchedReviews = $this->db->query('SELECT * FROM reviews WHERE visibility = 1 ORDER BY pub_date DESC');
            return $fetchedReviews->result();
        }
        
        /*********** Ivan 29.07.2013 *******/
        public function mInsertReviews($name, $review, $date, $phone, $email)
        {
            $this->db->query('INSERT INTO reviews(name, create_date, pub_date, comments, visibility, phone, email) 
                                VALUES ("'.$name.'", '.$date.', '.$date.', "'.$review.'", 0, "'.$phone.'", "'.$email.'")');
            return;
        }
         public function getTextDescription($id)
        {
            return $this->db->query("SELECT * FROM subcategory WHERE id = {$id}")->row();
        }
        
        
        
        
        
/*moi_vstavki_dlia_bazu*/

public function getBigstockCat ($data)
{
$car_arr = array();
foreach ($data['all_category'] as $value)
{
 /*  echo "<pre>";
    $car_arr = $value->name;    
    echo "</pre>";  */     
$diff1[] = $value->name;     
}


$query = $this->db->get('bigstock_cat_id');
foreach ($query->result() as $row)
{
    //$car_sec = $row->name;
$diff[] = $row->name;
} 



$differ = array_diff_assoc($diff1,$diff);




//print_r($differ); 
//var_dump($differ);



if (sizeof($differ)>0 ){
    
echo "Надо заносить";

$this->db->query('DELETE  FROM bigstock_cat_id');
$this->db->query('ALTER TABLE bigstock_cat_id AUTO_INCREMENT=0');
foreach ($data["all_category"] as $value)
{           
    $value->name;
    $this->db->query('INSERT INTO bigstock_cat_id (name) VALUES ("'.$value->name.'")');
}    
}
else {
//echo "Все и так ок";        
}

$data = array(
'mass_bigstok_bd'=>$diff

);
return $data;




//die();





/*primer*/
/*
 foreach($data['all_category'] as $value=>$vv)
                    {
                        $query = $this->db->get('bigstock_cat_id');
                        foreach($query->result() as $value2=>$vv2)
                        {
                            $diff[]=array_intersect($vv,$vv2);
                          
                        }
                    } 
                    
  print_r($diff);     */               
                    /*end_primer*/







/*
$query = $this->db->get('bigstock_cat_id');

foreach ($query->result() as $row)
{
    $car_sec = $row->name; 
    
    
    echo "<br>";
}*/
//return $car_sec;







/*$this->db->query('INSERT INTO bigstock_cat_id(id_cat, name) 
                                VALUES ("'.$car_arr.'", '.$car_arr.'")');*/
            
            







//$this->db->query('INSERT INTO bigstock_cat_id (name) VALUES ("'.$yt.'")');
//$yt.'")');



/*
$test = $this->db->query('select id_cat from bigstock_cat_id');

while ($row = mysql_fetch_assoc($test)) {
    print_r($row);
}*/




/*foreach ($test as $te) {
print_r($te);    
    
    
}*/









/*рабоч скрипт на удаление данных массива и внесения его в таблицу без повторений*/
/*
$this->db->query('DELETE  FROM bigstock_cat_id');
$this->db->query('ALTER TABLE bigstock_cat_id AUTO_INCREMENT=0');


foreach ($data["all_category"] as $value)
{           
    $value->name;
    $this->db->query('INSERT INTO bigstock_cat_id (name) VALUES ("'.$value->name.'")');
}*/

/*end_рабоч скрипт на удаление данных массива и внесения его в таблицу без повторений*/





//return $this->db->insert('bigstock_cat_id', $blo);
 
 /*
$data = array(
'adr'=>$new_arr,
); */
 
 
 
 
 
 



 
 

 
 
 /*
 
$da = array(
		'name' => $this->input->post('title'),

	);

	return $this->db->insert('bigstock_cat_id', $data); 
*/


 


//.'."');
            
            //return;






    
    
    
    
} /*end_getBigstockCat*/


public function m_sel_all($urll='',$nex='',$nex_start='')
{
    

//print_r($urll);

/*echo $nex;
echo $urll;
*/

  $da = array();
    $this->db->select('id_cat');
    $this->db->where('name',$urll);
    $query = $this->db->get('bigstock_cat_id');
   
   
    if ($query->num_rows()>0){
     $row = $query->row_array();
     $da = $row['id_cat'];
    
    }
    $query->free_result();

 
 /*echo $da;*/
 
 
 
 //$n_start = 0;
 
 
 
//$query_sec = $this->db->query('SELECT id_img, url, prew_url, title from bigstock_img WHERE id_cat = "'.$da.'" ');

//$query_sec = $this->db->get('bigstock_img', 0, 5);
//$query_sec = $this->db->get_where('bigstock_img', 'id_img', $n_start, $nex);

/*$query_sec = $this->db->get->select('id_img','url','prew_url','title')->from('bigstock_img')->where('id_cat', $da)->limit($n_start, $nex);


$query = $this->db->get('mytable', 10, 20);
print_r($query_sec);*/
/*
$query_sec = $this->db->get();*/
//print_r($query_sec);









$query_sec = $this->db->query('SELECT id_img, url, prew_url, title from bigstock_img WHERE id_cat = "'.$da.'" LIMIT '.$nex_start.', '.$nex   );

/*
$query_sec = $this->db->query('
SELECT id_img, url, prew_url, title from bigstock_img, (SELECT count(*) 
       WHERE id_cat = "'.$da.'")  as kolvo
WHERE id_cat = "'.$da.'" 
LIMIT '.$nex_start.', '.$nex);
*/




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
        //echo "В этой категории картинки есть"; 

//print_r($diffs); 
 
 

 

 
 
 
 //die();
 
 
 /* if ($query_sec->num_rows()>0){


foreach ($query_sec as $ff){
$difd1[] = $query_sec;     
    
    
}
print_r($difd1);*/
/*

     $data = $roww['url'];
        print_r($data);
  */      
        
        
//print_r($query->num_rows);
        
  /*   $row = $query->row_array();
     $data = $row['id_cat'];
    */ 
 
 
    } else {
  $diffs = 0;     
echo "В этой категории картинок нет";        
    }
 

 
 
$data = array(
'select_fhot_cate'=>$diffs

);

//die();
return $data; 
 
 
 
//$quer_sel = $this->db->query('SELECT url from bigstock_img WHERE id_cat ="'.$query->num_rows.'"');
 
 
 

 





  
}/*m_sel_all*/        



public function m_podcat_all ()

{
    


$da = array();
    //$this->db->select('crumb');
    $query = $this->db->query("select name from category ORDER BY name ASC");
    //$this->db->where('name',$urll);
    //$query = $this->db->get('category');
   


foreach ($query->result() as $row)
{
$diffs[] = $row->name;    

    
}
///print_r($row->crumb); 

   /*
  if ($query->num_rows()>0){
     
     $row = $query->row_array();
    // $da = $row['crumb'];
    
    }*/
    
    
    //$query->free_result();
//print_r($diffs);
 //return $diffs;
 //echo $da;

return $diffs;   
    
}/*end_m_podcat_all*/        
        
        

public function m_sel_kol ($urll='')

{



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
 
 //echo $da;
 
 

$query_sec = $this->db->query('SELECT count(*) as kolvo from bigstock_img
WHERE id_cat = "'.$da.'" ');

 
 
  foreach ($query_sec->result() as $roww)
{
    //$car_sec = $row->name;
//$diffs[] = $roww->url; 



$diffs[] = $roww;


} 
 //print_r($diffs);
 
 
 $data = array(
'sel_count'=>$diffs

);

//die();
return $data; 
     
    
    
    
    
    
}/*m_sel_kol*/




        

}//END

?>