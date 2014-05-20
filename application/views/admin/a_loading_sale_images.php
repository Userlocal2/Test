<section>
    <h1 class="title"><?=$info?><a class="link_add" href="<?=base_url(); ?>/administrator/loading_sale_images/?add" title="добавить"></a></h1>
    <!-- ADD start -->
    <?php if($act == 'add'):?>
    <form enctype="multipart/form-data" method="post" id="input_file_for_sale_form" action="<?=base_url(); ?>/administrator/loading_sale_images">
        <span>Выберите файл:&nbsp;</span><div><input type="file" name="image" onchange="tmp_upload($(this))"></div><br><br>
        <span>Введите номер изображения:&nbsp;</span><input type="text" name="article_image" size="5" ><br><br>
        <span>Ширина:&nbsp;</span><input type="text" name="width" size="5" style="margin-right: 12px;">
        <span>Высота:&nbsp;</span><input type="text" name="height" size="5">&nbsp;&nbsp;(мм)<br><br>
        <span>Текстура:&nbsp;</span><input type="text" name="texture" size="25"><br><br>
        <span>Старая цена:&nbsp;</span><input type="text" name="old_price" size="21"><br><br>
        <span><strong>Новая цена:&nbsp;</strong></span><input type="text" name="new_price" size="22"><br><br>
        <span>Описание(alt):&nbsp;</span><input type="text" name="alt" size="20"><br><br>
        <input type="submit" name="download" value="Добавить товар">
        <input type="hidden" value="add" name="type_act">
    </form> 
    <!-- end ADD -->
    
    <!-- EDIT start -->
    <?php elseif($act == 'edit'):?>
    <form enctype="multipart/form-data" method="post" id="input_file_for_sale_form" action="<?=base_url(); ?>/administrator/loading_sale_images">
        <span>Выберите файл:&nbsp;</span><div><input type="file" name="image" onchange="tmp_upload($(this))"></div><br><br>
        <span>Введите номер изображения:&nbsp;</span><input type="text" name="article_image" size="5" value="<?=$sale->article;?>"><br><br>
        <span>Ширина:&nbsp;</span><input type="text" name="width" size="5" style="margin-right: 12px;" value="<?=$sale->width;?>">
        <span>Высота:&nbsp;</span><input type="text" name="height" size="5" value="<?=$sale->height;?>">&nbsp;&nbsp;(мм)<br><br>
        <span>Текстура:&nbsp;</span><input type="text" name="texture" size="25" value="<?=$sale->texture;?>"><br><br>
        <span>Старая цена:&nbsp;</span><input type="text" name="old_price" size="21" value="<?=$sale->old_price;?>"><br><br>
        <span><strong>Новая цена:&nbsp;</strong></span><input type="text" name="new_price" size="22" value="<?=$sale->new_price;?>"><br><br>
        <span>Описание(alt):&nbsp;</span><input type="text" name="alt" size="20" value="<?=$sale->alt;?>"><br><br>
        <input type="submit" name="download" value="Добавить товар">
        <input type="hidden" value="edit" name="type_act">
        <input type="hidden" value="<?=$sale->id;?>" name="id_img">
    </form> 
    
    <!-- end EDIT -->
    <?php else: ?>
        <?php foreach ($sale as $val):?>
        <div style="display: inline-block; text-align: center; padding:5px;margin:5px 2px;border:1px solid #ccc;position:relative;background:#f1f1f1;border-radius:2px;">
            <a href="<?=base_url(); ?>/administrator/loading_sale_images/?edit=<?=$val->id?>">
                <img alt="<?=$val->alt;?>" src="<?=base_url(); ?>/img/sale/<?=$val->article?>.jpg"><br>
                <span><strong><?=$val->article;?></strong><a style="margin-left: 20px;" href="<?=base_url(); ?>/administrator/loading_sale_images/?del=<?=$val->id?>&article=<?=$val->article?>">удалить</a></span>
            </a>
        </div>    
        <?php endforeach;?>
    
    <?php endif;?>
</section>