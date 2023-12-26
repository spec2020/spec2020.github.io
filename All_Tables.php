<?php 
####################################################################################
# Модуль выводит на экран содержимое базы данных 'conrol_clients_adv' по-таблично. #
# Полностью все данные не выводятся на экран, а только первые строки,чтобы показать#
# возможные действия с таблицами базы данных.                                      #
#################################################################################### 
#
require_once              'DB_Tables_Fields.php';  
$Arr_acc                =  array();
$Row                    =  array();
$dbtable                =  $FormTypes;
//$head_color   = 'silver';
# Класс для построения таблиц по заголовкам и содержанию таблиц
require_once 'Any_Table_HTML_New.php';

# Класс для работы с базой данных MySQL, описание в теле модуля   
# require_once 'DB_Class.php';
# Объект класса работы с базой данных создается внутри модуля DB_Class.php
# $dbObj                 =  new MySQL_DB(DB_HOST, DB_USER, DB_PWD, DB_NAME); 
### 
# Так мы делаем софт более независимым от конкретных таблиц БД
#
# Заголовки всех таблиц веб проекта, которые появляются на экране 
include_once 'Table_Headers.php';              //!!!// если уже созданы русские заголовки
#
# Заголовки всех таблиц БД проекта, на английском 
# require_once 'Table_Headers_DB.php';         //!!! В этой версии загружаются из БД
#                                              // на лету рограммой DB_Tables_Fields.php 
require_once 'Header.php';                     // заголовок для страниц проекта 
require_once 'FormMsgs.php';                   // все сообщения программ проекта
#
#
$f=0;    // номер элемента $FormType
foreach ($dbtable as $value) {
#
$headers    = $Table_Headers   [$FormTypes[$f]];// наименования столбцов таблицe 
$headers_db = $Table_Headers_DB[$FormTypes[$f]];// наименования доменов в таблице 
#                                              // БД и <input name's в формах
###
# Создаем объекты класса для вывода таблиц, вызываем конструктор
# $handler     = $FormType.'_Handler'; // обработчик настоящей формы

$Table_view =  new HTML_Table($headers , $heard_color); 
#
#запрос на выдачу всей таблицы  

$QueryResult = $dbObj->query("SELECT * FROM $dbtable[$f] LIMIT 0,2");
# возвращает массив ассоциативных массивов (см. класс DB_Class.php)   
# по сути двумерный массив, поэтому используем конструкцию foreach
# это можно увидеть убрав знак # перед print см. ниже. Таким образом
# формируются массивы для вывода на экран для каждой таблицы
#
if ($QueryResult==false)   
   {
    $msg = 'Нет записей в базе данных!';
   }
else              
   {       
    $NA  = count($QueryResult);
    //print '$NA='.$NA;
    //print '<pre>'; print_r($QueryResult); print '</pre>'; 
   }     
foreach ($QueryResult as $row    => $Arr_acc)
    	{
    	 $i=0;	
    	 foreach ($headers_db as $element) 
    	         {
    	 	      $Row = array_merge($Row, array($headers[$i] => $Arr_acc[$headers_db[$i]]) );
    	 		  $i++;
    	 	     }	
    	 $Table_view   ->  AddRowAssArr($Row);
        }   
print "<p></p><font color= \"blue\" ><strong>$All_Tables_Names[$f]</strong></font>"
     ."$Comment_to_Table_up[$f]";
       $Table_view      ->  PrintArr();
print "<a href=\"Tables_Handler.php?FormType=$FormTypes[$f]\">
       Все данные Таблицы&nbsp\"$All_Tables_Names[$f]\"</a>"
     .'<p></p>';
//print "<a href=\"$FormType[$f]_Handler.php?FormType=$FormType[$f]\">
//       Все данные Таблицы&nbsp\"$All_Tables_Names[$f]\"</a>"     
#
$f++;                             // новое значение $FormType, новая таблица 
}        
#   
include 'Footer.php';             // стандартная нижняя строка каждой страницы
#        
?>