<section>

	<?php require_once '_box_callback.php'; ?>
	
	<div class="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<a href="/">Main</a>
		/
		<span itemprop="title"><?=$name ?></span>
	</div>

        <article>
            <style>
                .general-block-for-reviews{
                    background: #edecd7;
                    padding: 8px 14px;
                }
                .unit-comment{
                    margin: 0 auto 9px;
                    background: #fff;
                    border: 1px solid #d5d4be;
                    padding: 8px; 
                    border-radius: 3px;
                    width: 100%;
                    color: #777;
                }
                .unit-comment tr td{
                    vertical-align: top;
                    padding: 0;
                    line-height: 1.6em;
                }
                .text-reviews{
                    margin-bottom: 106px;
                }
                .form-for-reviews{
                    padding: 12px 0;
                    color: #777;
                }
                .form-for-reviews form input, textarea{
                    width: 365px;
                    margin: 8px 0 16px 0;
                }
            </style>
            <h1 class="title"><?=$name?></h1>
            <?=$text;?>
            <div class="general-block-for-reviews">
                <div class="text-reviews">
                    <?php foreach ($fetched_reviews as $value): ?>
                            <table class="unit-comment">
                                <tr>
                                    <td style="width: 104px;">Имя:</td>
                                    <td><?= $value->name; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; width: 104px;">Дата:</td>
                                    <td style="padding: 10px 0;"><?= $value->pub_date; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 104px;">Комментарий:</td>
                                    <td><?= $value->comments; ?></td>
                                </tr>
                                <?php if(!empty($value->answers)):?>
                                <tr>
                                    <td style="width: 104px; padding-right: 15px; ">Ответ администратора:</td>
                                    <td><?= $value->answers; ?></td>
                                </tr>
                                <?php endif;?>
                            </table>
                    <?php endforeach;?>
                </div>
                <hr style="border: 1px solid #c0c1a2; margin: 0;">
            
                <div class="form-for-reviews">
                    <h3 style="font-size: 20px; margin:0 0 15px 0;">
                        Оставьте Ваш комментарий
                    </h3>
                    <form >
                        <span>*Имя:</span><br>
                        <input name="name_customer" type="text"><br>
                        <span>Телефон:</span><br>
                        <input name="phone" type="text"><br>
                        <span>Email:</span><br>
                        <input name="email" type="text"><br>
                         <span>*Комментарий:</span><br>
                        <textarea rows="8" name="text_review"></textarea>
                        <a class="butt_" rel="nofollow" onclick="send_review()" style="width:195px;padding:0;display: block; margin-left: 174px;"> Отправить </a>
                        <p>* Поля обязательные для заполнения</p>
                    </form>
                </div>
            </div>
        </article>
		
        <div style="text-align:center;padding:10px 0;clear:both;">
                <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,gplus"></div> 
        </div>
</section>