<section>
    <h1 class="title"><?=$name?></h1>
    <ul>
    <?php foreach ($sitemap as $val):?>
        <li>
            <a href="<?=base_url(); ?>/<?=$val->url?>.html"><?=$val->name;?></a>
        </li>
    <?php endforeach;?>
    </ul>
</section>