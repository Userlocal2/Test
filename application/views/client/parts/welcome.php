<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {




function __construct()
	{
		parent::__construct();
         if(!isset($_SESSION))
       {session_start();}
	}




	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
public function index($data = array())
	{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_news();
		$this->load->view('header');
        /*$this->load->library('Javascript');*/ 
        $this->load->view('main_top');
        $this->load->view('main_page',$data);
        $this->load->view('footer');
	}




public function regist()


{

$this->load->view('header_sec');
$this->load->view('main_top');
$this->load->view('main_page_common');
$this->load->view('footer');


}



public function news ()

{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_news();     
        
}







public function street ()
{

$this->load->model('m_user_date');
$data = $this->m_user_date->m_street();      
    
}


public function house ()
{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_house();       
    
    
}




public function street_id ()
{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_street_id();       
    
    
}



public function kv ()
{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_kv();      
    
    
}


public function fio ()
{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_fio();     
    
}










public function insert ($data = array())

{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_insert();   

if ($data['ins'] == 1)
{
$this->load->view('header_sec');
$this->load->view('main_top');
$this->load->view('main_page_message');
$this->load->view('footer');





    
}


             
}

/*
public function test ()
{    
$this->load->view('header_sec');
$this->load->view('main_top');
$this->load->view('main_page_message');
$this->load->view('footer');
    
}
*/





public function about ()
{
$this->load->view('header_sec');
$this->load->view('main_top');
$this->load->view('main_page_about');
$this->load->view('footer');    
    
    
}



public function news_all ($data = array(), $dat=array())

{
    
$this->load->model('m_user_date');
$data = $this->m_user_date->m_news_all();      

$this->load->view('header');     
$this->load->view('main_top',$data);
//$this->load->view('menu_in_cab',$data);
$dat = array(
               'flag_count' => '2'                              
);  


$this->load->view('main_page_question',$dat);
$this->load->view('footer');
    
    
}/*news_all*/





public function news_full ($data = array(), $dat=array())
{
//print_r($_GET);    

$this->load->model('m_user_date');
$data = $this->m_user_date->m_news_full(); 
$this->load->view('header');     
$this->load->view('main_top',$data);
$dat = array(
               'flag_count' => '4'                              
);


$this->load->view('main_page_question',$dat);
$this->load->view('footer');  
    
    
} /*news_full*/





public function subs ()
{




$data = array(
               'flag_count' => '5'                              
          );
    
    
$this->load->view('header_sec');
$this->load->view('main_top');


$this->load->view('main_page_question',$data);


$this->load->view('footer'); 





    
}/*subs*/





public function tarif ($data = array(), $dat=array())
{

/*
$this->load->model('m_user_date');
$data = $this->m_user_date->m_news_full();*/ 


$data = array(
               'flag_count' => '6'                              
          );
    
    
$this->load->view('header_sec');
$this->load->view('main_top');


$this->load->view('main_page_question',$data);


$this->load->view('footer'); 

    
    
}/*tarif*/


public function get_tarif ($data = array(), $dat=array())
{
    
$this->load->model('m_user_date');
$data = $this->m_user_date->m_get_tarif();



    
    
}



public function contakts ($data = array())

{
$data = array(
               'flag_count' => '3'                              
          ); 


$this->load->view('header_sec');
$this->load->view('main_top');


$this->load->view('main_page_question',$data);


$this->load->view('footer');           
             
    
}/*contakts*/



public function question ($data = array())

{
$data = array(
               'flag_count' => '0'                              
          );
    
    
$this->load->view('header_sec');
$this->load->view('main_top');


$this->load->view('main_page_question',$data);


$this->load->view('footer'); 
}








public function edit_data ($data = array(), $dat=array())

{
//print_r($_SESSION);echo "<br>";    
//print_r($_GET);
    
  

$this->load->model('m_user_date');
$data = $this->m_user_date->m_user();

//print_r($data['block_user']);


$this->load->view('header_in_cab',$data);     
$this->load->view('menu_in_cab',$data);
$dat = array(
               'flag_count' => '1'                              
);  
        

//print_r($data);
        
/*$this->load->view('header_sec',$data);
$this->load->view('main_top',$data);*/



$this->load->view('main_page_question',$dat);
$this->load->view('footer');        
    
}


public function update_edit ($data = array())

{
//print_r($_SESSION);
//print_r($_GET);
$this->load->model('m_user_date');
$data = $this->m_user_date->m_update();

if ($data['reg'] == 1)
{

/*
$this->load->view('header_sec');
$this->load->view('main_top');
$this->load->view('main_page_message');
$this->load->view('footer');*/




$this->load->view('header_in_cab',$data);     
$this->load->view('menu_in_cab',$data);


$this->load->view('main_page_in_cab_message',$data);
$this->load->view('footer',$data);
    
}
 
    
    
} 





public function send ()

{
    
echo "Hello";
print_r($_REQUEST);


 /* Здесь проверяется существование переменных */
 if (isset($_POST['name'])) {$name = $_POST['name'];}
 if (isset($_POST['e-mail'])) {$email = $_POST['e-mail'];}
 if (isset($_POST['subj'])) {$sub = $_POST['subj'];}
 if (isset($_POST['message'])) {$body = $_POST['message'];}

echo $name;
echo $email;
echo $sub;
echo $body;


/* Сюда впишите свою эл. почту */
 $address = "xxxx@ua.fm";

/* А здесь прописывается текст сообщения, \n - перенос строки */
 $mes = "Имя: $name \nE-mail: $email \nТема: $sub \nТекст: $body";

/* А эта функция как раз занимается отправкой письма на указанный вами email */
 $send = mail ($address,$sub,$mes,"Content-type:text/plain; charset = windows-1251\r\nFrom:$email");
 
 if ($send == 'true')
 {
 echo "Сообщение отправлено";
 }
 else 
 {
 echo "Сообщение не отправлено";
 }





    
    
}










public function account ()

{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_account();        
    
    
}



public function fiocount ()

{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_fiocount();    
    
    
}




public function checkLogin ()

{
$this->load->model('m_user_date');
$data = $this->m_user_date->m_checkLogin();    
    
}








public function getplat($data = array())
{
    
    
//print_r($_REQUEST);
    
//echo "Hello";
$this->load->model('m_user_date');
$data = $this->m_user_date->getplats();








//echo $data['plat'];

//print_r($data);
}



public function dubl_plat ($data = array())

{     
$this->load->model('m_user_date');
$data = $this->m_user_date->dublplats();    
    
     
}








public function logout(){        
session_unset();
//redirect('welcome/index','refresh');    
redirect('welcome');

}


public function plat_href ($data = array())
{
//print_r($_GET);

//echo "hell";    
$this->load->view('header_in_cab',$data);
//echo 'Kuku';

$this->load->view('menu_in_cab',$data);
/*$this->load->model('m_user_date');
$data = $this->m_user_date->privat();*/
$this->load->view('main_page_in_cab_plat');
$this->load->view('footer');
}

    
public function in_cabinet($data = array())
{



$this->load->view('header_in_cab',$data);     
$this->load->view('menu_in_cab',$data);


$this->load->model('m_user_date');
$data = $this->m_user_date->privat();



//print_r($data[2]);
//echo $data['0'];
//print_r($data[0]);
 
$this->load->view('main_page_in_cab',$data[0]);
$this->load->view('footer',$data);


/*        
$this->load->view('header');
$this->load->view('main_top');  
$this->load->view('footer');*/        
    }
    
public function user_validate ($data = array())

{

//print_r($_SESSION);

/*$this->load->model('m_user_date');
$da = $this->m_user_date->choice();
echo $da['sib'];
die;*/

$this->load->model('m_user_date');
$data = $this->m_user_date->user_valid();

if ($data != 0)
/**/
{
       
$da = $this->m_user_date->choice();
/*echo "<br>"; 
echo $da['sib'];
echo "<br>";*/
if ($da['sib'] == 1)
{
$this->load->view('header_in_cab',$data);
$this->load->view('menu_in_cab',$data);
$this->load->model('m_user_date');
$dat = $this->m_user_date->privat();



$this->load->view('main_page_in_cab',$dat);
$this->load->view('footer',$data);


}/*Первый иф на постгресс*/
else {

//echo "Вывод для сайбейз";


$this->load->model('m_user_date');
$dat = $this->m_user_date->sybase();
//print_r($dat);

$this->load->view('header_in_cab',$dat);     
$this->load->view('menu_in_cab',$dat);
$this->load->view('main_page_in_cab_syb',$dat);
$this->load->view('footer',$data);
        
}
}
else {

echo "Нет данных по пользователю";

}    
}/***/
    



public function testlogin ()

{
    

$this->load->model('m_user_date');
$dat = $this->m_user_date->m_testlogin();    
    
    

    
    
    
}




function schet ()
{
include ('config.php'); // РїРѕРґРєР»СЋС‡Р°РµРј С„Р°Р№Р» РєРѕРЅС„РёРіСѓСЂР°С†РёРё

header('');


if (isset($_REQUEST["f_user"]) && isset($_REQUEST["s_month"])) {
   $uid = (int)preg_replace("[^0-9]","",$_REQUEST["f_user"]);
   //$month = (int)preg_replace("[^0-9]","",$_REQUEST["s_month"]);   
   $month = $_REQUEST["s_month"];   
   $god = (int)preg_replace("[^0-9]","",$_REQUEST["s_year"]);

//echo $uid;echo "<br>";
//echo $month;echo "<br>";

//echo $god;echo "<br>";

   
$strLength = iconv_strlen($month);


if ($strLength == 1) {
$nol = 0;    
$month_sec = $nol.$month;

//echo $month_sec;
}
else {    
$month_sec = $month;
//echo $month_sec;    
}
   

$all_date = $god.$month_sec;
 //echo "$all_date";
    $file = '';
$name = $uid;
//echo $all_date;
$filename = $_SERVER['DOCUMENT_ROOT'].'/schet.pdf/'.$all_date.'/'.$name.'.pdf';


//echo $filename;
//echo $name;
//die();
//echo $filename;

if (file_exists($filename)) {
//echo "The file $filename exists";    




    
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="rahunok.pdf"');
                                		
$file =  readfile("schet.pdf/$all_date/$name.pdf");
         
} else {
//echo "The file $filename does not exist";

    
//echo 2;    

    //echo $file;
echo "Данного рахунку не існує";
}
 
die();

                                                
                                                
                                                
                                		
                                          
                                                
                                                

                                                
                                                
                                                
/*                                     
$filename = ("schet.pdf/$all_date/$name.pdf");
if (file_exists($filename)) {
  print "Файл <b>$filename</b> существует";
} else {
  print "Файл <b>$filename</b> 
        НЕ существует";
}*/
                                                            
                                               
                                                die();




    if ($lastmonth < $thismonth){
         // Header('Location: user_mes.php?mes=auth_err');
            exit('tvoy mat'); 
    }
    
   
      if ($uid <= 0 && $mn <=0) {      
            Header('Location: user_mes.php?mes=auth_err');
            exit(); 
      }
                     
}
else {
	Header('Location: user_mes.php?mes=auth_err');                        
	exit();
}

 //fopen("/schet.pdf/$name.pdf", "w");


	if (ibase_connect($ibase_host, $ibase_user, $ibase_pwd, $ibase_charset)==NULL) {
		Header('Location: user_mes.php?mes=con_err');
		exit();
	}
                                 
$r = ibase_query("select body from schet where webuser_id = $uid and mes = $month and god = $god");
		$f = ibase_fetch_row($r);
        //print_r($f);
                
                
        

                if($f[0] != null) {
                	                
                        $blob_data = ibase_blob_info($f[0]);
                        $blob_hndl = ibase_blob_open($f[0]);
                        
                    
                        
                                	
$file = ibase_blob_get($blob_hndl, $blob_data[0]);
         
                        ibase_blob_close($blob_hndl);
                                		
               	} else $file = '';
                                		
                                		$name = md5($uid);
                                		
                                		$fh = fopen("/tmp/$name.pdf", "w");
						if($fh == null){
							Header('Location: private.php?mes=con_err');
							exit();
						}                                		
						fwrite($fh, $file);
                                		
                                		header('Content-type: application/pdf');
                                		header('Content-Disposition: attachment; filename="rahunok.pdf"');
                                		readfile("/tmp/$name.pdf"); 
                                		
                                		fclose($fh);
                                		unlink("/tmp/$name.pdf");
                                		
                                		
                                		fclose($fh); 
                                		
                                		ibase_close();  
    
    
}

    
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */