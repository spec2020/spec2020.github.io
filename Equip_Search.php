<?php 
####################################################################################
# Модуль производит расширенный поиск по полям - наименование тренажера,           #
# Год Завершения Срока службы, Количество поломок                                  #
# можно унифицировать программу для любых таблиц)                                  #
# При клике на ссылке "расширенный поиск" Form_Buttons.php вызывается обработчик   #
# Таbles_Handler.php с меню расширенного поиска Form_Buttons_Equip.php  затем      #    
# Обработку поиска производит модуль Equip_Search                                  #                                
#                                                                                  #
#################################################################################### 
#
$Arr_w        = array();
$Row_w        = array();
$FormType     ='4_products';    // таблица оборудования в базе данных
$Staff_Search = true;         //!!!///
$dbtable      = $FormType;
#
# в ранних версиях был файл require_once 'Table_Headers_DB.php';
# Заголовки всех таблиц БД проекта, на английском формируются динамически
require_once 'DB_Tables_Fields.php';
#                 
# Класс для построения таблиц по заголовкам и содержанию таблиц
require_once 'Any_Table_HTML_New.php';

# Класс для работы с базой данных MySQL, описание в теле модуля   
require_once 'DB_Class.php';             
# 
# Заголовки всех таблиц веб проекта, которые появляются на экране 
include_once 'Table_Headers.php';
#
# Так мы делаем софт более независимым от конкретных таблиц БД
#
$headers    = $Table_Headers   [$FormType];// наименования столбцов таблицe 
$headers_db = $Table_Headers_DB[$FormType];// наименования доменов в таблице 
#                                          // БД и <input name's в формах
# Создаем объекты класса для вывода таблиц, вызываем конструктор
#$handler     = $FormType.'_Handler';      // обработчик настоящей формы

#
# Объект класса работы с базой данных создается внутри модуля DB_Class.php
//$dbObj                 =  new MySQL_db(DB_HOST, DB_USER, DB_PWD, DB_NAME); 
#
#include 'Client_form_valid.php  // проверяет введенные данные

#******************************* Поиск по ключам ********************************
# то только записи соответствующие ввденным ключам будут найдены и выданы на экран 
#
if     (!($_POST["Id"]))                       // наименование, можно сокращенно
       $KeyValue1    = '%';                    // может быть пустым   
else   
       {
       $KeyValue1    = trim($_POST["Id"]); 
       $KeyValue1    = '%'.$KeyValue1.'%';
       }
#
if     (!($_POST["client"]))                   // компания
       $KeyValue2    = '%';                    //   
else                                           // может быть пустым
       {
       	$KeyValue2    = trim($_POST["client"]);
       	$KeyValue2    = '%'.$KeyValue2.'%'; 
       }
#
if     (!($_POST["material"]))  
       $KeyValue3     = '%';
else   
       {
       	$KeyValue3    = trim($_POST["material"]);// может быть пустым
                                                 // наименование материала
       	$KeyValue3    = '%'.$KeyValue3.'%';      // 
       }
# 
if (($KeyValue1=="%")&&($KeyValue2=="%")&&($KeyValue3=="%"))
   {
	$msq  ='<font color="Red"> Ошибка! Введите данные для поиска</font>'; 
	include_once 'Entry_Search.php';        //!!!!!//
	exit;
   }
# поиск по нескольким ключам
else
   { 
   	 $KeyName0  =  $headers_db[0];
   	 $KeyName1  =  $headers_db[0];
   	 $KeyName2  =  $headers_db[1];
   	 $KeyName3  =  $headers_db[2];
	 $$FormType = $dbObj->query("SELECT * FROM  $dbtable 
	                                      WHERE $KeyName1 LIKE '$KeyValue1'
	                                      AND   $KeyName2 LIKE '$KeyValue2'
                                          AND   $KeyName3 LIKE '$KeyValue3'
	                                      ORDER BY '$KeyName0' ");	                                      

   }
#   
### Это структура таблицы оборудования БД. Имена полей справа. Слева имена столбцов на русском 
#  
/*
    'products' => Array                          # материалы-товары
        (
            'КОД МАТЕРИАЛА (ТОВАРА)'         ,   # [0] => Prod_Id
            'КОД КОМПАНИИ'                   ,   # [1] => Client_Id            
            'НАИМЕНОВАНИЕ МАТЕРИАЛА'         ,   # [2] => Prod_Nm
            'ЦЕНА МАТЕРИАЛА'                 ,   # [3] => Prod_Price
            'ОПИСАНИЕ'                       ,   # [4] => Prod_Detail            
        ),
*/   
# возвращает массив ассоциативных массивов (см. класс DB_Class.php)   
# по сути двумерный массив, поэтому используем конструкцию foreach
# это можно увидеть убрав знак # перед print см. ниже. Таким образом
# формируются массивы для вывода на экран, даже если таблица состоит
# из одной строки (как в случае поиска)
#
if ($$FormType==false)
   {
	$msq  ='<font color="Red"> Запись не найдена в таблице</font>'; 
	include_once 'Entry_Search.php';                   //!!!!!//
	exit;
   }
else              
   {       
    $NC  = count($$FormType);
//  print '$NC='.$NC;
//  print '<pre>'; print_r($$FormType); print '</pre>'; 
   } 
$head_color   = 'silver';
$Table_view   =  new HTML_Table($headers , $head_color);         
foreach ($$FormType as $row    => $Arr_w)
    	{
    	 $i=0;	
    	 foreach ($headers_db as $element) 
    	         {
    	 	      $Row_w = array_merge($Row_w, array($headers[$i] => $Arr_w[$headers_db[$i]]) );
    	 	      $$headers_db[$i] = $Arr_w[$headers_db[$i]];
    	 		  $i++;
    	 	     }	
    	 $Table_view ->  AddRowAssArr($Row_w);
        }
#                     
include'Header.php';                // общий заголовок для всех страниц проекта 
print "<p><font color='red'><strong>РЕЗУЛЬТАТ ПОИСКА</strong>&nbsp$msg1&nbsp</font></p>";
$Table_view -> PrintArr();          // таблица
include 'Form_Buttons_Equip.php';
//print "<p><a href=\"Tables_Handler.php?FormType=$FormType\">Просмотр всей таблицы домов</a>";
include 'Footer.php';               // стандартная нижняя строка каждой страницы
#        
?>