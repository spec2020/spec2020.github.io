<?php 
####################################################################################
# Модуль производит поиск по полю - Id                                             #
#                                                                                  #
####################################################################################
#
$Arr_w                  = array();
$Row_w                  = array();
#
# в ранних версиях был файл require_once 'Table_Headers_DB.php';
# Заголовки всех таблиц БД проекта, на английском формируются динамически
#
require_once 'DB_Tables_Fields.php';
#                 
# Класс для построения таблиц по заголовкам и содержанию таблиц
require_once 'Any_Table_HTML_New.php';
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

#******************************* Поиск ключу ********************************
$KeyName         = $headers_db[0];
$QueryResult     = $dbObj->query("SELECT * FROM $FormType WHERE $KeyName ='$KeyValue' ORDER BY '$KeyName' ");
if ($QueryResult==false)
   {
    $msg1        ='Запись не найдена в таблице';
//  $QueryResult = $dbObj->query("SELECT * FROM $dbtable ORDER BY '$KeyName' ");
   }
else 
   {
//    print '<pre>'; 
//    print_r($QueryResult); 
//    print '</pre>'; 
//    $msg1        ='<br>Запись с сотрудником найдена в базе данных';
	  $Nm      =$QueryResult[0][$headers_db[$IndSearch]];
   }
print $msg1;       
?>