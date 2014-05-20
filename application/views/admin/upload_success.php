<?php

/**
 * @author Oleg Pamfilov
 * @copyright 2014
 */



?>

<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Файл успешно загружен</h3>

<ul>
<?php foreach($upload_data as $item => $value):
/*echo "<pre>";
print_r($upload_data);
echo "<pre>";*/
?>
<li><?php 

echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('administrator/images', 'Перейти к загрузке других файлов!'); ?></p>

</body>
</html>