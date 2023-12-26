<?php 
####################################################################################
# Модуль выводит на экран содержимое базы данных любых таблиц                      #
#                                                                                  #
####################################################################################
#
session_start();
$Status       = $_SESSION['Status']; 
if ($_GET[FormType])
$FormType     = $_GET[FormType];
$Arr_acc      =  array();
$Row          =  array();
require_once 'DB_Tables_Fields.php';                 //!!!//
#
//require_once 'FormTypes.php';                      //!!!//
require_once 'FormMsgs.php';
$dbtable   = $FormType;
# Класс для построения таблиц по заголовкам и содержанию таблиц
require_once 'Any_Table_HTML_New.php';

# Класс для работы с базой данных MySQL, описание в теле модуля   
require_once 'DB_Class.php';                         //???//
# 
# Заголовки всех таблиц веб проекта, которые появляются на экране 
include_once 'Table_Headers.php';
#
# Заголовки всех таблиц БД проекта, на английском 
//require_once 'Table_Headers_DB.php';               //!!!//
#
# Так мы делаем софт более независимым от конкретных таблиц БД
#
$headers    = $Table_Headers   [$FormType];// наименования столбцов таблицe 
$headers_db = $Table_Headers_DB[$FormType];// наименования доменов в таблице 
#                                          // БД и <input name's в формах
# Создаем объекты класса для вывода таблиц, вызываем конструктор
#$handler     = $FormType.'_Handler';      // обработчик настоящей формы
$head_color   = 'silver';
$Table_view   =  new HTML_Table($headers , $heard_color);
#
# Объект класса работы с базой данных создается внутри модуля DB_Class.php
//$dbObj                 =  new MySQL_DB(DB_HOST, DB_USER, DB_PWD, DB_NAME); 
#
#include 'Client_form_valid.php  // проверяет введенные данные
#************************ Добавление Обновление **************************
#
#    Добавление записи в таблицу БД. Данные передаются методом POST из 
# Forms_Main.php. Нажата кнопка Добавить.
# При обновлениии данных, просто удаляется предыдущая и заносится новая.
#    Кнопки тоже вписываются в таблицы; Особенность в NAME='UpdPro'Первый раз 
# пользователь нажимает кнопку Update, под списком всех строк таблицы,
# например, сотрудников. Предполагается обновление только одной записи.
# А в форме Forms_Main происходит повторное нажатие "изменить", обрабатывает
# один и тот же _Handler. Он "должен знать" откуда запрос на обработку. 
#
if ($_GET["staffsearch"])
    $Staff_Search =true;
if ((isset($_POST["Add"]))||(isset($_POST["UpdPro"])))
   { 
   	                                           // "UpdPro" - это после обновления                       
     $i=0;                                     // данных в форме Forms_Main.php
   	 foreach ($headers_db as $element)
   	 {
   	  $$headers_db[$i] = $_POST[$headers_db[$i]];	
   	  // first key forming	
   	  if ($FormType=='Questions'){$$headers_db[0]=$_POST[$headers_db[2]].$_POST[$headers_db[4]].$_POST[$headers_db[1]];}	
   	  $Str2.=",'".$$headers_db[$i]."'";
   	  $i++;	
   	 }
   	 $Str2=substr($Str2,1);
     $$headers_db[0]  = substr($$headers_db[0],0,10);    // в первой колонке всегда первичный ключ 
     if (isset($_POST["UpdPro"]))
        {
         $KeyName = $headers_db[0];
         $KeyValue= $$headers_db[0];	
    	 $Del     = $dbObj->query("DELETE FROM $dbtable WHERE $KeyName='$KeyValue'");
	 	 if ($Del == false) $msg1= 'Ошибка обновления данных! ';
        }
     foreach ($FormTypes as $current) 
        {
         if ($FormType==$current){
 	        include 'Request_SQL.php';        //The result in $QueryResult 
            }                                 //
        }   
    if ($QueryResult==1)  $msg1  = 'Новые данные успешно добавлены '; 
    else                  $msg1  = "При вводе данных произошла ошибка! 
                                    Данные уже есть в таблице ";
//  echo                $msg1;
  } 

#******************************* Поиск-Удаление ********************************
# Если данные передаются методом POST из _Handler.php при нажатии кнопки "Найти",
# то только записи соответствующие ввденному ключу будут надены и выданы на экран 
# в данном примере
#
if ( (isset($_POST["Search"]))||
     (isset($_POST["Delete"]))||
     (isset($_POST["Update"])))
   {
     $KeyValue = $_POST["$headers_db[0]"];
   } 
#             
#запрос на выдачу всей таблицы или результата поиска, если поиска нет
if (!$KeyValue)
   {
   	 $KeyName     = $headers_db[0];
     $QueryResult = $dbObj->query("SELECT * FROM $dbtable ORDER BY '$KeyName' ");
   }
else
# если поиск с целью поиска, удаления или обновления
   {
   	 $KeyName         = $headers_db[0];
	 $QueryResult     = $dbObj->query("SELECT * FROM $dbtable WHERE $KeyName ='$KeyValue' ORDER BY '$KeyName' ");
	 if ($QueryResult==false)
	    {
	     $msg1        ='Запись не найдена в таблице';
	     $QueryResult = $dbObj->query("SELECT * FROM $dbtable ORDER BY '$KeyName' ");
	    }
	 else
	    {
	     if ($_POST["Delete"])	
	 	     $del  = $dbObj->query("DELETE FROM $dbtable WHERE $KeyName='$KeyValue'");
	 	 if ($del != false) $msg1= 'Запись удалена ';
	    }
   }
# возвращает массив ассоциативных массивов (см. класс DB_Class.php)   
# по сути двумерный массив, поэтому используем конструкцию foreach
# это можно увидеть убрав знак # перед print см. ниже. Таким образом
# формируются массивы для вывода на экран, даже если таблица состоит
# из одной строки (как в случае поиска)
#
if ($QueryResult==false)  
   {
    $msg = 'Нет записей в базе данных!';
   }
else              
   {       
    $NC  = count($QueryResult);
    //print '$NC='.$NC;
    //print '<pre>'; print_r($QueryResult); print '</pre>'; 
   }        
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
if  (isset($_POST["Update"]))
    {
	 include 'Forms_Main.php';
	 exit;
    }
#                     
include'Header.php';                // общий заголовок для всех страниц проекта 
print "<p></p><font color='blue'><strong>$All_Tables_Names_Acc[$FormType]</strong>&nbsp$msg1&nbsp</font>";
$Table_view -> PrintArr();          // таблица 'Staff' - все назначения на текущий момент
if ($Staff_Search){
    include 'Form_Buttons_Staff.php';
    exit;	
}
                                    // продумать более эффективный, универсальный метод !!!
# запрос на выдачу всей таблицы или результата поиска, если поиска нет
# и определение какие кнопки вставлять к таблице
#                                    
//if (!$KeyValue){                   
	if (($FormType=='3_Priem')&&($Status =='Пациент')) {
		 include 'Form_Buttons_Select.php';
		 include 'Footer.php';
	     exit;		
	} 
	if (($FormType=='1_Doctors')&&($Status =='Пациент')){
		 $FormType='3_Priem';
		 print   "<p><a href=\"Tables_Handler.php?FormType=$FormType\"><strong>Перейти к выбору врача и времени посещения</strong></a></p>";
		 include 'Footer.php';
	     exit;		
	} 
	if (($FormType=='1_Doctors')&&($Status =='Врач')){
		 include 'Form_Buttons_Doctor.php';
		 $FormType='3_Priem';
		 print   "<p><a href=\"Tables_Handler.php?FormType=$FormType\"><strong>Перейти к просмотру назначений и времени посещения</strong></a></p>";
		 include 'Footer.php';
	     exit;		
	} 
	if (($FormType=='3_Priem')&&($Status =='Врач')){
		 include 'Form_Buttons_Doctor.php';
		 $FormType='1_Doctors';
		 print   "<p><a href=\"Tables_Handler.php?FormType=$FormType\"><strong>Перейти к просмотру списка врачей и графикам приема</strong></a></p>";
		 include 'Footer.php';
	     exit;		
	} 
//}                                  
	if ($Status =='Admin') {
        include 'Form_Buttons.php';         // простая форма для работы с таблицей; с кнопками   
        print   '<p><a href="All_Tables.php"><strong>Просмотр структуры всех таблиц&nbsp</strong></a>';
        print   "<a href=\"Forms_Main.php?formtype=$FormType\"><strong>Добавить новую запись&nbsp</strong></a>";
//      print   '<a href="Tables_Handler.php?staffsearch=Yes"><strong>Расширенный поиск&nbsp</a></strong></p>';
        include 'Footer.php';               // стандартная нижняя строка каждой страницы
	}
#        
?>