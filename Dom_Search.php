<?php 
####################################################################################
# Модуль производит расширенный поиск по полям - наименование региона (района),    #
# площадь дома, площадь участка                                                    #
# можно унифицировать программу для любых таблиц)                                  #
#                                                                                  #
####################################################################################
#
$Arr_w        = array();
$Row_w        = array();
$FormType     ='3_doma';    // таблица оборудования в базе данных 
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
if     (!($_POST["region"]))                   // наименование, можно сокращенно
       $KeyValue1    = '%';                    // может быть пустым   
else   
       {
       $KeyValue1    = trim($_POST["region"]); 
       $KeyValue1    = '%'.$KeyValue1.'%';
       }
#
if     (!($_POST["ploshad"]))                  // площадь дома
       $KeyValue2    = '0';                    //   
else                                           // может быть пустым
       {
       	$KeyValue2    = trim($_POST["ploshad"]);
//      $KeyValue2    = '0'; 
//      $KeyValue2    = '%'.$KeyValue2.'%'; 
       }
#
if     (!($_POST["uchastok"]))  
       $KeyValue3     = '0';
else   
       {
       	$KeyValue3    = trim($_POST["uchastok"]);// может быть пустым
//      $KeyValue3    = '0';                     // площадь участка
//      $KeyValue3    = '%'.$KeyValue3.'%';      // 
       }
# 
if     (!($_POST["price"]))  
       $KeyValue4     = '100000';
else   
       {
       	$KeyValue4    = trim($_POST["price"]);   // может быть пустым
                                                 // стоимость
//     	$KeyValue4    = '%'.$KeyValue4.'%';      // 
       }
# 
//print        $KeyValue1;
//print '<br>'.$KeyValue2;
//print '<br>'.$KeyValue3;
//print '<br>'.$KeyValue4;

if (($KeyValue1=="%")&&($KeyValue2=="0")&&($KeyValue3=="0")&&($KeyValue4=="100000"))
   {
	$msq  ='<font color="Red"> Ошибка! Введите данные для поиска</font>'; 
	include_once 'Entry_Search.php';        //!!!!!//
	exit;
   }
# поиск по нескольким ключам
else
   { 
   	 $KeyName0  =  $headers_db[0];
   	 $KeyName1  =  $headers_db[2];
   	 $KeyName2  =  $headers_db[6];
   	 $KeyName3  =  $headers_db[8];
   	 $KeyName4  =  $headers_db[10];
	 $$FormType = $dbObj->query("SELECT * FROM  $dbtable 
	                                      WHERE $KeyName1 LIKE '$KeyValue1'
	                                      AND   $KeyName2 >    '$KeyValue2'
                                              AND   $KeyName3 >    '$KeyValue3'
                                              AND   $KeyName4 <    '$KeyValue4'     
	                                      ORDER BY '$KeyName0' ");	                                      

   }
#   
### Это структура таблицы оборудования БД. Имена полей справа. Слева имена столбцов на русском 
#  
/*
    '3_doma' => Array                            # ДОМА 
        (
            'КОД ОБЪЯВЛЕНИЯ'                 ,   # [0] => Dom_Id
            'АДРЕС ДОМА'                     ,   # [1] => Dom_Address            
            'ГОД ПОСТРОЙКИ'                  ,   # [2] => Dom_Year
            'КОЛИЧЕСТВО ЭТАЖЕЙ'              ,   # [3] => Dom_Levels
            'МАТЕРИАЛ СТЕН'                  ,   # [4] => Dom_Walls 
            'ОБЩАЯ ПЛОЩАДЬ'                  ,   # [5] => Dom_Total           
            'КОЛИЧЕСТВО КОМНАТ'              ,   # [6] => Dom_Komnat
            'ПЛОЩАДЬ УЧАСТКА'                ,   # [7] => Dom_Uchastok
            'ДРУГОЕ'                         ,   # [8] => Dom_Other
            'СТОИМОСТЬ<br>(Т.РУБ.)'          ,   # [9] => Dom_Price
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
    //print '$NC='.$NC;
    //print '<pre>'; print_r($$FormType); print '</pre>'; 
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
print "<p><font color='red'><strong>РЕЗУЛЬТАТ ПОИСКА ДОМОВ</strong>&nbsp$msg1&nbsp</font></p>";
$Table_view -> PrintArr();          // таблица
include 'Form_Buttons_Dom.php';
//print "<p><a href=\"Tables_Handler.php?FormType=$FormType\">Просмотр всей таблицы</a>";
include 'Footer.php';               // стандартная нижняя строка каждой страницы
#        
?>