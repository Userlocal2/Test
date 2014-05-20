<?php
//namespace PingHost;
/**
 * @author Ivan Glavatskih <ivan@klever.dp.ua>
 */
class PingHost {
    
    /**
     *  @var string remote host name or IP addres
     */
    private $hostName;
    
    /**
     * @param array $hostName name of main host 
     */
    public function __construct( $hostName = array('smtp_server' => 'rdp.klever.dp.ua') )
    {
        $this->hostName = 'http://' . $hostName['smtp_server'];
    }
    
    /**
     * @return bool|string this method returns whether TRUE or error message 
     */
    public function InitCURLSession()
    {
        $cURLHandle = curl_init($this->hostName);
        if( !curl_errno($cURLHandle) )
        {
            curl_setopt($cURLHandle,CURLOPT_CONNECTTIMEOUT,1);
            curl_setopt($cURLHandle,CURLOPT_NOBODY,true);
            $r = curl_exec($cURLHandle);

            //call method which gets received HTTP_CODE
            return $this->GetHTTPCode($cURLHandle);
        }
        else
        {
            return curl_error($cURLHandle);
        }
    }
    
    /**
     * @return array if server rdp.klever.dp.ua is avaliable, then returns associative array with values "mail" and "upload",
     *               otherwise returns associative array with values "mail2" and "upload2"
     */
    protected function GetHTTPCode($cURLHandle)
    {
        //$httpCode received HTTP code
        $httpCode = curl_getinfo($cURLHandle, CURLINFO_HTTP_CODE);
        
        if( $httpCode == 0)
        {
            return array('mail' => 'mail2', 'upload' => 'upload2');
        }

        return array('mail' => 'mail', 'upload' => 'upload');
    }
}