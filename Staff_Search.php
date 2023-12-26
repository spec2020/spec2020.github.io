<?php 
####################################################################################
# Модуль производит расширенный поиск по полям - Id_s, Post(должность), Date_End   #
# можно унифицировать программу для любых таблиц)                                  #
# При клике на ссылке "расширенный поиск" Form_Buttons.php вызывается обработчик   #
# Staff_Handler.php с меню расширенного поиска Form_Buttons_Staff.php              #
#                                                                                  #
####################################################################################
#
$Arr_w                  = array(); 
$Row_w                  = array();
$FormType               ='Employes';
$Staff_Search           = true;
$dbtable                = $FormType;
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
if     (!($_POST["post"]))                     // должность, можно сокращенно
       $KeyValue1    = '%';                    // может быть пустым   
else   
       {
       $KeyValue1    = trim($_POST["post"]); 
       $KeyValue1    = '%'.$KeyValue1.'%';
       }
#
if     (!($_POST["sert"]))                     // наличие сертификата
       $KeyValue2    = '%';                    // да или нет  
else                                           // может быть пустым
       {
       	$KeyValue2    = trim($_POST["sert"]);
       	$KeyValue2    = '%'.$KeyValue2.'%'; 
       }
#
if     (!($_POST["year"]))  
       $KeyValue3     = '%';
else   
       {
       	$KeyValue3    = trim($_POST["year"]);// может быть пустым
                                             // год получения сертификата
       	$KeyValue3    = '%'.$KeyValue3.'%';  // 2013 - например 
       }
# 
if (($KeyValue1=="%")&&($KeyValue2=="%")&&($KeyValue3=="%"))
   {
	$msq  ='<font color="Red"> Ошибка! Введите данные для поиска</font>'; 
	include_once 'Entry_Search.php';
	exit;
   }
# поиск по нескольким ключам
else
   { 
   	 $KeyName0  =  $headers_db[0];
   	 $KeyName1  =  $headers_db[3];
   	 $KeyName2  =  $headers_db[6];
   	 $KeyName3  =  $headers_db[7];
	 $$FormType = $dbObj->query("SELECT * FROM  $dbtable 
	                                      WHERE $KeyName1 LIKE '$KeyValue1'
	                                      AND   $KeyName2 LIKE '$KeyValue2'
                                          AND   $KeyName3 LIKE '$KeyValue3'
	                                      ORDER BY '$KeyName0' ");	                                      

   }
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
print "<p><font color='red'><strong>Сотрудники</strong>&nbsp$msg1&nbsp</font></p>";
$Table_view -> PrintArr();          // таблица 'Staff' - все назначения на текущий момент
include 'Form_Buttons_Staff.php';
print "<p><a href='Tables_Handler.php?FormType=$FormType'>Просмотр всей таблицы персонала</a>";
include 'Footer.php';               // стандартная нижняя строка каждой страницы
#        
?>