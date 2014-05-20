<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Cache-Control: no-store, no-cache, must-revalidate");
setlocale(LC_ALL, 'en_US.utf8');
session_start();

class Manager extends CI_Controller {
    
 /*   private $idAccount  = '301039';
    private $secretKey  = '4b98047030fd2482900d6834bf40261327211d9d';*/

  private $idAccount  = '568004';
    private $secretKey  = '5886a8a276942070d58db8534b8a098fe7581085';




    public function __construct()
    {
       parent::__construct();
    }

    public function index()
    {
        if (!isset($_SESSION['manager'])) {
           $this->load->view('manager/a_login');
           return;
        }
        $this->load->view('manager/manager_home');
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('/manager/');
            exit;
        }
        $this->load->model('adminModel');
        $this->adminModel->auth();
        redirect('/manager/');
        exit;
    }
    
    public function logout()
    {
        session_destroy();
        redirect('/manager/');
        exit;
    }
    
    private function valid()
    {
        if (!isset($_SESSION['manager'])) {
                redirect('/manager/');
                exit;
        }
    }
    
    public function purchase()
    {
        $this->valid();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imageId    = $this->input->post('idImage', true);
            $sizeCode   = $this->input->post('sizeCode', true);

            // Example PHP code to generate auth_key for purchase request
            $auth_key   = sha1($this->secretKey . $this->idAccount . $imageId);
            $request    = @file_get_contents(
                "http://api.bigstockphoto.com/2/{$this->idAccount}/purchase?image_id={$imageId}&size_code={$sizeCode}&auth_key={$auth_key}"
            );
            if ($request === false) {
                echo json_encode(array('error' => 1));
                exit;
            }

            $purchase = json_decode($request);
            if ($purchase->response_code == 200) {
                //get link to image file
                $respone = array(
                    'link'              => $this->download($purchase->data->download_id),
                    'currency_amount'   => $purchase->data->currency_amount,
                    'currency_code'     => $purchase->data->currency_code,
                );
                echo json_encode($respone);
                exit;
            } else {
                echo json_encode(array('error' => "Error!"));
                exit;
            }
        } else {
            redirect('/manager');
            exit;
        }
    }
    
    private function download($downloadId)
    {
        $this->valid();
        // Example PHP code to generate auth_key for purchase request
        $auth_key   = sha1($this->secretKey . $this->idAccount . $downloadId);
        return $request = "http://api.bigstockphoto.com/2/{$this->idAccount}/download?auth_key={$auth_key}&download_id={$downloadId}";
    }



}
