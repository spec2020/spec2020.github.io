<?php 
####################################################################################
# Модуль производит поиск по полю - Id                                             #
#                                                                                  #
####################################################################################
# 
session_start();
$Status          = $_SESSION['Status'  ]; 
$username        = $_SESSION['username'];
$FIO             = $_SESSION['FIO'     ];  // FIO влвдельца кабинеты
#
$FormType        = $_GET [FormType  ];
$IndSearch       = $_GET [IndSearch ];
$KeyValue        = $_GET [KeyValue  ];
if               (!$_GET [KeyValue  ]) 
$KeyValue        = $_POST[KeyValue  ];    // это если после кнопки
/* 
print              "<br>FormType   =$FormType";
print              "<br>IndSearch =$IndSearch";
print              "<br>KeyValue   =$KeyValue";
*/
#
$Arr_acc         = array();
$Row             = array();
$dbtable         = $FormType;
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

#******************************* Поиск ключу ********************************
#
$KeyName         = $headers_db[$IndSearch];
$QueryResult     = $dbObj->query("SELECT * FROM $dbtable WHERE $KeyName ='$KeyValue' OR $KeyName ='$FIO' ORDER BY '$KeyName' ");
if ($QueryResult==false)
   {
    $msg1        ='Запись не найдена в таблице';
//  $QueryResult = $dbObj->query("SELECT * FROM $dbtable ORDER BY '$KeyName' ");
   }
else 
   {
/*    print '<pre>'; 
    print_r($QueryResult); 
    print '</pre>'; */
   }
$head_color   = 'silver';
$Table_view   =  new HTML_Table($headers , $heard_color);
foreach ($QueryResult as $row    => $Arr_acc)
    	{
    	 $i=0;	
    	 foreach ($headers_db as $element) 
    	         {
    	 	      $Row = array_merge($Row, array($headers[$i] => $Arr_acc[$headers_db[$i]]) );
    	 	      $$headers_db[$i] = $Arr_acc[$headers_db[$i]];
    	 		  $i++;
    	 	     }	
    	 $Table_view ->  AddRowAssArr($Row);
        }
include'Header.php';                // общий заголовок для всех страниц проекта 
print "<p></p><font color='blue'><strong>РЕЗУЛЬТАТ ПОИСКА</strong>&nbsp$msg1&nbsp</font>";        
$Table_view -> PrintArr();
#
if (($Status=='Менеджер')&&($FormType=='Clients')){
	include 'Form_Buttons.php';     // простая форма для работы с таблицей; с кнопками 
                                    // удаления,поиска, обновл.,если просмативается вся таблица
    print "&nbsp&nbsp&nbsp<a href=\"Forms_Main.php?formtype=$FormType\">Добавить новую запись</a>";
    print '<p><a href="../../Control_FitClub/Trener/index_trener.php">Возврат в кабинет</a>';    
}    
#
#
if (($Status=='Тренер')&&($FormType=='TrenerNaznach')){
	include 'Form_Buttons.php';     // простая форма для работы с таблицей; с кнопками 
                                    // удаления,поиска, обновл.,если просмативается вся таблица
    print "&nbsp&nbsp&nbsp<a href=\"Forms_Main.php?formtype=$FormType\">Добавить новую запись</a>";
    print '<p><a href="../../Control_FitClub/Trener/index_trener.php">Возврат в кабинет</a>';    
}    
#
if (($Status=='Тренер')&&($FormType=='z_comments')){
	include 'Form_Buttons.php';     // простая форма для работы с таблицей; с кнопками 
                                    // удаления,поиска, обновл.,если просмативается вся таблица
    $Item   =$$headers_db[1];
    print "<a href=\"Forms_Main.php?formtype=$FormType&News=$Item&Autor=$FIO\">Добавить новую запись</a>";
    print '<p><a href="../../Control_FitClub/Trener/index_trener.php">Возврат в кабинет</a>';
}   
#
if (($Status=='Клиент')&&($FormType=='z_comments')){
	include 'Form_Buttons.php';     // простая форма для работы с таблицей; с кнопками 
                                    // удаления,поиска, обновл.,если просмативается вся таблица
    print "<a href=\"Forms_Main.php?formtype=$FormType&News=$Item&Autor=$FIO\">Добавить новую запись</a>";
    print '<p><a href="../../Control_FitClub/Clients/index_member.php">Возврат в кабинет</a>';    
}               
?>