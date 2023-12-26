<?php
#
# построитель форм такого вида Universal_Forms_Builder.php
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
foreach ($headers as $element)
        {
         $size=80;	$maxlength=140; $type = 'text';
#         
## Эта часть по умолчанию. В дальнейше эти параметры будут динамическими.
## Их можно поместит в контейнер или базу данных
#    
         if (($i==0)&&($FormType=='z_comments'))      $$headers_db[$i]= date("Y-m-d");
#                
         $element1         =  "<input type='$type'    name ='".$headers_db[$i].
                              "' size='$size' maxlength='$maxlength' value='".$$headers_db[$i]."'>";	
                                                // наименования доменов в таблице 
#                                               // input name's в формах  
         if (($i==1)&&($FormType=='z_comments'))   
            {
/*         	 $element1= $News." <input type='hidden'        name ='".$headers_db[$i].
                                "' value='".$News."'>";	*/
             $element1     = "<input type='$type'    name ='".$headers_db[$i].
                              "'size='$size' maxlength='$maxlength' value='".$News."'>";

            }
#            
         if (($i==2)&&($FormType=='z_comments'))   
            {
         	 $current_date = $element1=date("Y-m-d ");
         	 $element1= $current_date."<input type='hidden' name ='".$headers_db[$i].
                                "' value='".$current_date."'>";	
            }         
         if (($i==3)&&($FormType=='z_comments'))   
            {
         	 $element1     = "<textarea name='".$headers_db[$i]."' rows='10' cols='60' wrap='virtual' value ='
         	                  ".$$headers_db[$i]."'>Заполните это поле вашим комментарием</textarea>";
            }
         if (($i==4)&&($FormType=='z_comments'))   
            { 
/*           $size=80;	$maxlength=140; $type = 'text';            	           
             $element1     = "<input type='$type'    name ='".$headers_db[$i].
                              "'size='$size' maxlength='$maxlength' value='".$$headers_db[$i]."'>";
*/
         	 $element1= $Autor." <input type='hidden'        name ='".$headers_db[$i].
                                "' value='".$Autor."'>";	                              
            }                  	                                 
	     $Form_view -> AddRowAssArr
    	                     (array($form_headers [0] => $element,
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