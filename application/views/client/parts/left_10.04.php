<aside id="left">
	<ul class="menu">
<?php 

echo "<pre>";
print_r($bd_sel_cat);
echo "</pre>";
print_r($_REQUEST);
?>    
    
    
	<?php foreach($all_category as $value):?>        
		<li>
            <a <?=$cat_id == $value->name ? 'class="tmp-current-link"' :''?> href="<?=base_url(); ?><?=strtolower($value->name); ?>.html">
				<span><?=$value->name; ?></span>
			</a>
		</li>
      <?php endforeach;?>
      
      
      
	</ul>
</aside><!--LEFT-->