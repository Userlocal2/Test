<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    class UpdateAltOfImages{
        protected $filename;
        protected $path_to_tmp_file;
        private $path_to_loading_file;
        
        public function __construct($params) {
            $extenstion = explode('.', $params['filename']);
            if($extenstion[1] != 'csv')
            {
                throw new Exception("Файл имеет расширение отличное от CSV");
            }
            $this->filename = $params['filename'];
            $this->path_to_tmp_file = $params['path_to_tmp_file'];
            $this->path_to_loading_file = 'files/alt_image_data.csv';
            copy($this->path_to_tmp_file, $this->path_to_loading_file);
        }
        
        public function readCSVFile()
        {
            $handle = fopen($this->path_to_loading_file, "r");
            while ($string_from_file = fgetcsv($handle, filesize($this->path_to_loading_file), ','))
            {
                $data_from_loaded_file[] = str_getcsv(iconv('Windows-1251','UTF-8',$string_from_file[0]), ';');
            }
            return $data_from_loaded_file;
        }
        
        public function updateDBAltOfImage()
        {
            $CI = &get_instance();
            $array_data_alt = $this->readCSVFile();
            foreach ($array_data_alt as $value)
            {
                if(empty($value[4]) || empty($value[26]))
                {
                    continue;
                }
                else
                {
                    $CI->db->query('UPDATE gallery 
                                        SET alt = "'.htmlspecialchars($value[4]).'",
                                            title_image = "'.htmlspecialchars($value[26]).'"
                                        WHERE id = '.(int)$value[0].' ');
                }
            }
            return 'Обновление описания картинок завершено! Проверьте результат';
        }
    }
?>
