<section>
    <h1 class="title">
        <?= $info; ?>
        <a title="добавить" class="link_add" href="<?=base_url(); ?>/administrator/reviews/?action=add"></a>
    </h1>
    <div id="gallery_box">
        <table id="gb">
            <tr class="gb_f">
                <td class="td_c1" style="width:1%; ">№</td>
                <td class="td_c1" style="width:9%; ">Имя клиента</td>
                <td class="td_c1" style="width:9%; ">Дата публикации</td>
                <td class="td_c1" style="width:9%;">Дата создания</td>
                <td class="td_c1" style="width:9%; ">Телефон</td>
                <td class="td_c1" style="width:9%;">Email</td>
                <td class="td_c1">Комментарий</td>
                <td class="td_c1">Опубликовать</td>
                <td class="td_c1" style="width:2%; ">Редактировать</td>
                <td class="td_c1" style="width:2%; ">Удалить</td>
            </tr>
            <?php $i=1; foreach($all_reviews as $val):?>
            <tr>
                <td class="td_c1" > <?= $i ?> </td>
                <td class="td_c1" > <?= $val->name; ?> </td>
                <td class="td_c1" > <?= $val->pub_date; ?> </td>
                <td class="td_c1" > <?= $val->create_date; ?> </td>
                <td class="td_c1" > <?= $val->phone; ?> </td>
                <td class="td_c1" > <?= $val->email; ?> </td>
                <td class="td_c1" style="white-space: normal;"> <?= $val->comments; ?> </td>
                <td class="td_c1">
                    <a class="vis_ <?=$val->visibility == 1 ? ' visible' : ' hidden'?>" tb="reviews" i="<?=$val->id?>" title="изменить - один клик"></a>
                </td>
                <td class="td_c1"><a title="редактировать" class="link_edit" href="<?=base_url(); ?>/administrator/reviews/?action=edit&id=<?=$val->id?>"></a></td>
                <td class="td_c1"><a title="удалить" class="link_del" onclick="del(<?=$val->id?>, 'reviews', '<?=$val->name?>')"></a></td>
            </tr>
            <?php $i++; endforeach;?>
        </table> 
    </div>
</section>