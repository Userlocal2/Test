				<div class="clear"></div>
			</section>
			<footer>
				<ul style="float:left; margin:5px 110px 0 0;">
					<?php foreach($all_pages as $k):?>
						<?php if($k->type == 'bottom-menu'):?>
							<li><a href="<?=$lang?>/<?=$k->url?>.html"><?=$n = $lang == '/ua' ? $k->ua_name : $k->name?></a></li>
						<?php endif;?>
					<?php endforeach;?>
				</ul>
				<ul style="float:left; margin:5px 100px 0 0;">
					<li><?=$i->tel_1?></li>
					<li><?=$i->tel_2?></li>
					<li><?=$i->tel_3?></li>
				</ul>
				<ul style="float:left;margin:5px 0 0 0;">
					<li>после 18:00 и в воскресенье:</li>
					<li><?=$i->tel_4?></li>
				</ul>
				<ul style="float:right; margin:5px 0 0 0;">
					<li>
						<a href="http://vk.com/club31971594" class="soc vk" target="_blank" rel="nofollow"></a>
						<a href="http://www.facebook.com/pages/Арт-обои/215125655225899" class="soc fb" target="_blank" rel="nofollow"></a>
						<a href="http://www.odnoklassniki.ru/group/54331596210203" class="soc od" target="_blank" rel="nofollow"></a>
						<a href="https://plus.google.com/116076101865289593495?rel=author" class="soc gp" target="_blank" rel="publisher"></a>
						<a href="https://twitter.com/Art_oboi" class="soc tw" target="_blank" rel="nofollow"></a>
						<a href="http://www.youtube.com/user/artoboivideo?feature=guide" class="soc yt" target="_blank" rel="nofollow"></a>
                                                <a href="http://www.pinterest.com/artwallmural/" class="soc pin" target="_blank" rel="nofollow"></a>
					</li>
				</ul>
				<div class="copy"><?=$lang == '/ua'? ' Арт-шпалери™ Всі права захищені':'Арт-обои™ Все права защищены'?> © 2011-<?=date('Y', time());?></div>
			</footer>
		</div>
            <!-- Yandex.Metrika counter -->
			<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter10077769 = new Ya.Metrika({id:10077769,
								webvisor:true,
								clickmap:true,
								trackLinks:true,
								accurateTrackBounce:true,
								trackHash:true});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
			</script>
			<noscript><div><img src="//mc.yandex.ru/watch/10077769" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->
			
			
			<script type="text/javascript">
				var google_conversion_id = 1020272120;
				var google_conversion_label = "kdmMCOjNkgQQ-LvA5gM";
				var google_custom_params = window.google_tag_params;
				var google_remarketing_only = true;
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
			<noscript>
				<div style="display:inline;">
					<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1020272120/?value=0&amp;label=kdmMCOjNkgQQ-LvA5gM&amp;guid=ON&amp;script=0"/>
				</div>
			</noscript>	
		
	</body>
</html>