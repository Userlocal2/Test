<section>

   <?php require_once '_box_callback.php'; ?>

	<div class="crumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		<a itemprop="url"  href="/"><span itemprop="title">Main</span></a>
		/
		<span itemprop="title">получить скидку</span>
	</div>
<style>
   .table-questions{
      width: 100%;

   }
   .question{
      font-weight: bold;
   }
   .version-answer{
      padding: 8px 19px;
   }
   .hidden-select{
      display: none;
   }
   .check{
      display: block;
   }
</style>
<form  action="<?=$lang?>/interview.html" enctype="multipart/form-data" method="POST" id="target">
   <table class="table-questions">
      <tr>
         <td class="question">1. Пол</td>
      </tr>
      <!-- 1 -->
      <tr>
         <td class="version-answer">
             <select name="sex" class="select-interview">
                 <option value="женщины">женщины</option>
                 <option value="мужчины">мужчины</option>
             </select>
         </td>
      </tr>
      <!-- 2 -->
      <tr>
         <td class="question">2. Возраст</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="age" class="select-interview">
                 <option value="меньше 25 или 25">меньше 25 или 25</option>
                 <option value="26-30">26-30</option>
                 <option value="31-35">31-35</option>
                 <option value="больше 35">больше 35</option>
             </select>
         </td>
      </tr>
      <!-- 3 -->
      <tr>
         <td class="question">3. Территориальная единица</td>
      </tr>
      <tr>
         <td class="version-answer">
         <?php 
            $oblast = array( '------- Республики -------',
							'Адыгея',
							'Алтай',
							'Башкортостан',
							'Бурятия',
							'Дагестан',
							'Ингушетия',
							'Кабардино-Балкария',
							'Калмыкия',
							'Карачаево-Черкесия',
							'Карелия',
							'Коми',
							'Марий Эл',
							'Мордовия',
							'Саха (Якутия)',
							'Северная Осетия — Алания',
							'Татарстан',
							'Тыва (Тува)',
							'Удмуртия',
							'Хакасия',
							'Чечня',
							'Чувашия',
							'------- Края -------',
							'Алтайский край',
							'Забайкальский край',
							'Камчатский край',
							'Краснодарский край',
							'Красноярский край',
							'Пермский край',
							'Приморский край',
							'Ставропольский край',
							'Хабаровский край',
							'------- Области -------',
							 'Амурская область',
							 'Архангельская область',
							 'Астраханская область',
							 'Белгородская область',
							 'Брянская область',
							 'Челябинская область',
							 'Иркутская область',
							 'Ивановская область',
							 'Калининградская область',
							 'Калужская область',
							 'Кемеровская область',
							 'Кировская область',
							 'Костромская область',
							 'Курганская область',
							 'Курская область',
							 'Ленинградская область',
							 'Липецкая область',
							 'Магаданская область',
							 'Московская область',
							 'Мурманская область',
							 'Нижегородская область',
							 'Новгородская область',
							 'Новосибирская область',
							 'Омская область',
							 'Оренбургская область',
							 'Орловская область',
							 'Пензенская область',
							 'Псковская область',
							 'Ростовская область',
							 'Рязанская область',
							 'Сахалинская область',
							 'Самарская область',
							 'Саратовская область',
							 'Смоленская область',
							 'Свердловская область',
							 'Тамбовская область',
							 'Томская область',
							 'Тверская область',
							 'Тульская область',
							 'Тюменская область',
							 'Ульяновская область',
							 'Владимирская область',
							 'Волгоградская область',
							 'Вологодская область',
							 'Воронежская область',
							 'Ярославская область',
							 '------- Автономная область -------',
							 'Еврейская АО',
							 '------- Автономные округи -------',
							 'Ненецкий АО',
							'Ханты-Мансийский АО — Югра',
							'Чукотский АО',
							'Ямало-Ненецкий АО');
         ?>
             <select name="oblast" class="select-interview">
                <?php foreach ($oblast as $val):?>
				<?php if(preg_match('/^-{7}/', $val)): ?>
                <option disabled style="font-weight:bold;"><?=$val?></option>
				<?php else: ?>
                 <option value="<?=$val?>"><?=$val?></option>
				<?php endif;?>
                <?php endforeach;?>
             </select><br><br>
             <input name="city" placeholder="Введите город" style="width: 278px;">
         </td>
      </tr>
       <!-- 4 -->
      <tr>
          <td class="question">4. Повлияло бы на Ваше решение, если бы Вам необходимо было внести предоплату заказа?</td>
      </tr>
      <tr>
          <td class="version-answer">
              <input type="radio" name="type_pyament" value="да" id="type_pyament_yes"><label for="type_pyament_yes">да</label>
              <input type="radio" name="type_pyament" value="нет" id="type_pyament_no"><label for="type_pyament_no">нет</label>
          </td>
      </tr>
      <!-- 5 -->
      <tr>
         <td class="question">5. Есть ли семья и сколько человек?</td>
      </tr>
      <tr>
         <td class="version-answer" >
            <input type="radio" value="1" name="family" id="amount-member-yes" onClick="SelectRadio(1)"><label>Есть</label>
            <input type="radio" value="0" name="family" id="amount-member-no" onClick="SelectRadio(0)"><label>Нет</label>
            <select name="family1" class="hidden-select" id="hidden-select">
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
               <option value="4">4</option>
               <option value="5">5</option>
               <option value="более 5">более 5 человек</option>
            </select>
            <!--<input type="text" name="family">-->
         </td>
      </tr>
      <!-- 6 -->
      <tr>
         <td class="question">6. Первый ли раз будете клеить фотообои, какой?</td>
      </tr>
      <tr>
         <td class="version-answer">
            <select name="amlount_glue" class="select-interview">
               <option value="Да">Да</option>
               <option value="Нет">Нет</option>
               <option value="Я профессионал">Я профессионал</option>
            </select>
         </td>
      </tr>
      <!-- 7 -->
      <tr>
         <td class="question">7. Почему решили клеить фотообои? </td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="reason" class="select-interview">
                 <option value="0">-</option>
                 <option value="Это красиво">Это красиво</option>
                 <option value="Это модно">Это модно</option>
                 <option value="Хочетсся чего-то оригинального">Хочетсся чего-то оригинального</option>
                 <option value="Необходимо заклеить стену">Необходимо заклеить стену</option>
             </select>
             <br><br>
             <textarea name="reason" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 8 -->
      <tr>
         <td class="question">8. Как к этому пришли?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="how_decided" class="select-interview">
                 <option value="0">-</option>
                 <option value="Кто-то посоветовал">Кто-то посоветовал</option>
                 <option value="В интернете">В интернете</option>
                 <option value="Увидели в журнале, ТВ">Увидели в журнале, ТВ</option>
                 <option value="Увидели в магазине">Увидели в магазине</option>
                 <option value="У кого-то увидели">У кого-то увидели</option>
             </select>
             <br><br>
             <textarea name="how_decided" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      
      
      <!-- 9 -->
      <tr>
         <td class="question">9. Как долго принимали решение перед покупкой(дней)?</td>
      </tr>
      <tr>
         <td class="version-answer">
            <select name="day_before" class="select-interview">
               <?php for($i=1; $i<31; $i++):?>
                  <option value="<?=$i; ?>"><?=$i;?></option>
               <?php endfor;?>
                  <option value="более 30">более 30</option>
            </select>
         </td>
      </tr>
      
      <!-- 10 -->
      <tr>
         <td class="question">10. Где еще кроме Интернета смотрели фотообои? (рынок, магазины)</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="where_looking" class="select-interview">
                 <option value="0">-</option>
                 <option value="Нигде, только у нас">Нигде, только у нас</option>
                 <option value="Магазин-салон и т.д.">Магазин-салон и т.д.</option>
                 <option value="Журналы">Журналы</option>
             </select>
             <br><br>
             <textarea name="where_looking" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 11 -->
      <tr>
         <td class="question">11. Какие торговые марки фотообоев знаете?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <input name="tm" id="tm" type="checkbox" value="0"><label for="tm">Никаких</label>
             <br><br>
             <textarea name="tm" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 12 -->
      <tr>
         <td class="question">12. Почему выбрали именно нас?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="why_we" class="select-interview">
                 <option value="0">-</option>
                 <option value="Большой выбор">Большой выбор</option>
                 <option value="Удобно пользоваться сайтом">Удобно пользоваться сайтом</option>
                 <option value="Посоветовали друзья/знакомые">Посоветовали друзья/знакомые</option>
                 <option value="Увидел рекламу">Увидел рекламу</option>
             </select>
             <br><br>
             <textarea name="why_we" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 13 -->
      <tr>
         <td class="question">13. Перечень наиболее важных для Вас характеристик в фотообоях</td>
      </tr>
      <tr>
         <td class="version-answer">
            <input type="checkbox" name="characteristic[]"  value="картинка"> картинка <br>
            <input type="checkbox" name="characteristic[]" value="нужный размер"> нужный размер  <br>
            <input type="checkbox" name="characteristic[]" value="цена"> цена  <br>
            <input type="checkbox" name="characteristic[]" value="торговая марка"> торговая марка  <br>
            <input type="checkbox" name="characteristic[]" value="качество печати"> качество печати  <br>
            <input type="checkbox" name="characteristic[]" value="нужный рисунок"> нужный рисунок <br>
            <input type="checkbox" name="characteristic[]" value="время изготовления"> время изготовления  <br>
            <input type="checkbox" name="characteristic[]" value="время доставки"> время доставки  <br>
            <input type="checkbox" name="characteristic[]" value="страна производитель"> страна производитель 
            <br><br>
            <textarea name="characteristic" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 14 -->
      <tr>
         <td class="question">14. Каким ТМ доверяют?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="producer" class="select-interview">
                 <option value="Национальным">Национальным</option>
                 <option value="Иностранным">Иностранным</option>
             </select>
         </td>
      </tr>
      <!-- 15 -->
      <tr>
         <td class="question">15. Какие опасения связанные с фотообоями (чего боитесь)?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="your_fears" class="select-interview">
                 <option value="0">-</option>
                 <option value="Не совпадает с интерьером">Не совпадает с интерьером</option>
                 <option value="Высокая цена">Высокая цена</option>
                 <option value="Обои расходятся сложность со стыками">Обои расходятся сложность со стыками</option>
                 <option value="Плохое качество">Плохое качество</option>
                 <option value="Некачественная поклейка">Некачественная поклейка</option>
             </select> 
            <br><br>
            <textarea name="your_fears" placeholder="Свой вариант" style="resize: none;" rows="5" cols="32"></textarea>
         </td>
      </tr>
      <!-- 16 -->
      <tr>
         <td class="question">16. Как часто делаете ремонт?</td>
      </tr>
      <tr>
         <td class="version-answer">
             <select name="how_often" class="select-interview">
                 <option value="меньше 5 лет">&lsaquo; 5 лет включительно</option>
                 <option value="больше 5 лет">&rsaquo; 5 лет</option>
                 <option value="Профессиональная деятельность">Профессиональная деятельность</option>
             </select>
         </td>
      </tr>
      <!-- 17 -->
      <tr>
         <td class="question">17. Будете клеить в доме или квартире?</td>
      </tr>
      <tr>
         <td class="version-answer">
            <select name="accommodation" class="select-interview">
                 <option value="дом">дом</option>
                 <option value="квартира">квартира</option>
                 <option value="Профессиональная деятельность">Профессиональная деятельность</option>
             </select>
         </td>
      </tr>
      <!-- 17 -->
      <tr>
         <td class="question">17. Будете клеить сами или с помощью наемных работников</td>
      </tr>
      <tr>
         <td class="version-answer">
            <select name="worker" class="select-interview">
                 <option value="Сами">Сами</option>
                 <option value="Рабочие">Рабочие</option>
             </select>
         </td>
      </tr>
      
      <!-- Contact information -->
      <tr>
         <td class="question">Введите свои контактные данные (телефон или email, или номер заказа)</td>
      </tr>
      <tr>
          <td class="version-answer"><span  class="question" >Телефон:</span><br><input type="text" name="phone" style="width: 277px;"></td>
      </tr>
      <tr>
         <td class="version-answer"><span  class="question">Email:</span> <br><input type="text" name="email" style="width: 277px;"></td>
      </tr>
      <tr>
         <td class="version-answer"><span  class="question">Номер заказа:</span> <br><input type="text" name="num_order" style="width: 277px;"></td>
      </tr>
      <tr>
          <td><span style="font-weight: bold; color: red;"><sup>*</sup>Все поля обязательные для заполнения, кроме Email и Номер заказа</span></td>
      </tr>
      <tr>
          <td class="version-answer"><input type="button" name="send_result" value="Отправить ответы" class="submit-button"></td>
      </tr>
   </table>
</form>
<script>
function SelectRadio(val)
{
   if(val == 1)
   {
      document.getElementById('hidden-select').style.display = "block";
   }
   else if(val == 0)
   {
      document.getElementById('hidden-select').style.display = "none";
   }
}
   
$(document).ready(function (){
    
    containerForTextareTrigger();
      
    /**   Button sends answers of interview.
    *     By click button is checking whether all fields are completed or not. 
    *     If one of the set of fields doesn't have value, then we change color of question text to red
    */
    $('.submit-button').
        click(
            function () 
            {
                var jqObj = $('.table-questions :input:not(.submit-button)');
                var flag = true;
                if( !jqObj.eq(4).is(':checked') && !jqObj.eq(5).is(':checked') ) //question 4
                {
                      $('.question').eq(3).css( {'color':'red'} );
                      flag = false;
                }
                if( !jqObj.eq(6).is(':checked') && !jqObj.eq(7).is(':checked') ) //question 5
                {
                      $('.question').eq(4).css( {'color':'red'} );
                      flag = false;
                }
                
                /**
                 *  Sets red color of text questions, which has empty value.
                 *  Checks value of tag option of the `.select-interview` elements. 
                 *  If option has value equal 0 and textarea with own variant is empty, then set color question to red
                 */
                $('.select-interview').
                    each(
                        function(index) 
                        {
                            if($(this).val() == '0' && $('textarea[name="'+$(this).attr('name')+'"]').val().trim().length == 0) 
                            {
                                //sets color of text questions to red, 
                                //if they don't have value in select and textarea for owner question
                                $('.select-interview').eq(index).parent().parent().prev().children().css({'color':'red'});
                                flag = false;
                            }
                        }
                    );// end block selects with owner answers

                /**
                 *  Sets color of text to red for question 10, if checkbox is not checked and textarea is empty
                 */
                if( !$('#tm').is(':checked') && $('textarea[name=tm]').val().trim().length == 0 ) 
                {
                    $('#tm').parent().parent().prev().children().css( {'color':'red'} );
                    flag = false;
                }
                
                /**
                 *  question 12
                 *  Sets red color for text question 12, if checkbox is not checked or textarea is empty
                 */
                if( !$('input[name^="characteristic"]').is(':checked') && $('textarea[name=characteristic]').val().trim().length == 0 )
                {
                    $('input[name^="characteristic"]').parent().parent().prev().children().css( {'color':'red'} );
                    flag = false;
                }
                /**
                 * Check input of phone whether empty or filled
                 */
                if($('input[name="phone"]').val().trim().length == 0)
                {
                    $('input[name="phone"]').siblings('span').css( {'color' : 'red'} );
                    flag = false;
                }
                
                if( flag )
                {
                    $('#target').submit();
                }
            } 
        );// end event handler click submit button
        
    
    //event makes change of color question text from red to black, if it is red
    $('input[name=family]').
        click( 
            function() 
            {
                if($('.question').eq(4).css('color') == 'rgb(255, 0, 0)') 
                {
                   $('.question').eq(4).css({'color' : '#555'});
                }
            }
        );
            
    //event makes change of color question text from red to black, if it is red
    $('input[name=type_pyament]').
        click( 
            function() 
            {
                if($('.question').eq(3).css('color') == 'rgb(255, 0, 0)') 
                {
                   $('.question').eq(3).css({'color' : '#555'});
                }
            }
        );

    //change color of the select input from red to default color
    $('.select-interview').
        click( 
            function() 
            {
                setDefaultColorQuestions( $(this) );
            }
        );

    //event handler for event click on the textarea own variant
    $('td.version-answer textarea').
        click( 
            function() 
            {
                setDefaultColorQuestions( $(this) );
            }
        );

    //change color of text question to black
    $('#tm').
        change( 
            function() 
            {
                setDefaultColorQuestions( $(this) );
            }
        );
    
    //set color of text above input PHONE by default
    $('input[name="phone"]').
        click(
            function()
            {
                $(this).siblings('span').css( {'color':'#555'} );
            }
        );
    });
    
    
 
// Make disable or enable textarea for all selector that have fiel for entry own variant answer, 
// also for input characteristics and tm.
// Apply to questions 6, 7, 9, 10, 11, 12, 14
function containerForTextareTrigger()
{
    //enable or disable textares `yourself version`   
    $('.select-interview').
        change(
            function()
            {
                var name_select = $(this).attr('name');   //value attribute of the name from select tag. used to insert value into attribute textarea  
                var value = $(this).children('option:selected').val(); //value the selected option tag
                //if selected value is not equal 0, then attribute disable set in true, else attr disable remove 
                if(value != 0) 
                {
                    disableTextarea(name_select);
                } 
                else 
                {
                    enableTextarea(name_select);
                }
            } 
        );
            
    //question 12. At least one checkebox is selected, then the next textarea is disabled, otherwise textarea is enabled
    $('input[name="characteristic[]"]').
        change(
            function()
            {
                var name = $(this).attr('name').replace(/\W+/, '').trim();
                $('input[name="characteristic[]"]').
                    each(
                        function () 
                        {
                            if( !$(this).is(':checked') ) 
                            {
                              enableTextarea(name);
                            } 
                            else 
                            {
                              disableTextarea(name);
                              return false;
                            }
                        }
                    );
            }
        );

    $('input[name="tm"]').
        change(
            function()
            {
                if($(this).is(':checked')) 
                {
                    disableTextarea($(this).attr('name'));
                } 
                else 
                {
                    enableTextarea($(this).attr('name'));
                }
            }
        );
}
 
// takes jQuery object and sets color of question by default
function setDefaultColorQuestions(obj)
{
    obj.parent().parent().prev().children().css({'color':'#555'});
}
function disableTextarea(name)
{
    //var name_without_brackets = name.replace(/\W+/, '');
    //name = name_without_brackets.trim();
    $('textarea[name="'+name+'"]').val("");
    $('textarea[name="'+name+'"]').attr('disabled', 'true');
}
function enableTextarea(name)
{
    $('textarea[name="'+name+'"]').removeAttr('disabled');
}
</script>
</section>