<?php
#
# построитель форм состоящих из двух (но можно и больше столбцов). Принимает массив.
# Елементы массива выводятся затем в левую часть формы, в правую вводятся баллы,
# например, баллы по проделанной студентом/школьником работы
#

### Кнопки тоже вписываются в таблицы; Особенность в NAME='UpdPro'. Первый раз 
# пользователь нажимает кнопку Update, под списком всех строк таблицы,
# например, сотрудников. Предполагается обновление только одной записи.
# В этой форме происходит повторное нажатие "изменить", а обрабатывает
# один и тот же _Handler. Он "должен знать" откуда запрос на обработку.  
#
$button_add               =  "<INPUT TYPE='submit' NAME='Add' STYLE='font-size: 10 pt; 
	 background: font-family: arial,verdana,helvetica,sansserif' VALUE=' Добавить'>";
$button_del               =  "<INPUT TYPE='submit' NAME='Delete' STYLE='font-size: 10 pt; 
	 background: font-family: arial,verdana,helvetica,sansserif' VALUE='Удалить   '>";
$button_upd               =  "<INPUT TYPE='submit' NAME='UpdPro' STYLE='font-size: 10 pt; 
	 background: font-family: arial,verdana,helvetica,sansserif' VALUE='  Изменить '>";
$button_view              =  "<INPUT TYPE='submit' NAME='View'   STYLE='font-size: 10 pt; 
	 background: font-family: arial,verdana,helvetica,sansserif' VALUE='Просмотр '>";
###
#    Создаем объекты класса для вывода таблиц, вызываем конструктор
#$handler      = $FormType.'_Handler';          // обработчик настоящей формы
#$headers      = $Table_Headers   [$FormType];  // наименования столбцов таблицe 
#$headers_db   = $Table_Headers_DB[$FormType];  // наименования доменов в таблице 
#                                               // Staff БД и input name's в формах
$i=0;
foreach ($Form_Fields as $element)
        {
         $j=$i+1;
       //print "<br>Universal:Form_Fields_Code[$i]=$Form_Fields_Code[$i]";
         $element1         =  "<input type='text'    name ='".$Form_Fields_Code[$i].
                              "'size=40 maxlength=40 value='".$Form_Values[$i]."'>";	
                                                // наименования доменов в таблице 
#                                                                           
	     $Form_view -> AddRowAssArr
    	                     (array($form_headers [0] => $j.'. '.$element,
    	                            $form_headers [1] => $element1
    	                            )
    	                      ); 
     	 $i++;                          
        }
//buttons Add && Delete        
$Form_view -> AddRowAssArr
    	(array($form_headers [0] => $button_add,
    	       $form_headers [1] => $button_del
    	       )
    	);
//buttons Update && View       	 
$Form_view -> AddRowAssArr
    	(array($form_headers [0] => $button_upd ,
    	       $form_headers [1] => $button_view
    	       )
    	); 
// вывод формы на экран    	     	        
$Form_view ->OutForm($handler); 
?>