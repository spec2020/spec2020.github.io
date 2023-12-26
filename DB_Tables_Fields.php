<?php
####################################################
# Пример использования SHOW COLUMNS и SHOW COLUMNS #
#################################################### 
# 
require_once        'DB_Class.php'; 
$Arr_acc_tables    = array();
$Arr_acc_fields    = array();
$Tables            = array();
$Fields            = array();
$Fields_1          = array();
$Work              = array();
$Table_Headers_DB  = array();
$SQL_String1       = array();
$SQL_String2       = array();
#
$Tables_DB_Name     = 'Tables_in_'.DB_NAME;
#
$QueryResult = $dbObj->query("SHOW TABLES");
# ассоциированный массив с именами таблиц 
# Array
# (
#    [0] => Array
#        (
#            [Tables_in_control_clients_adv] => Clients
#        )
#...
#
#    print '<pre>'; 
#    print_r($QueryResult); 
#    print '</pre>'; 
#
$i=0; 
foreach ($QueryResult as $row_tables    => $Arr_acc_tables)
    	{
         $Tables[$i]   = $Arr_acc_tables[$Tables_DB_Name];
         $QueryResult  = $dbObj->query("SHOW COLUMNS FROM $Tables[$i]");
#
#         
# 
# Array
# (
#     [0] => Array
#         (
#             [Field] => Id_Client
#             [Type] => char(10)
#             [Null] => NO
#             [Key] => PRI
#             [Default] => 
#             [Extra] => 
#         )
         $j=0;
         $string =''; 
         $string1='';
         $string2='';  
         foreach ($QueryResult as $row_fields    => $Arr_acc_fields)
    	         {
                  $Fields[$i][$j]   = $Arr_acc_fields[Field];
                  $Fields_1  [$j]   = $Arr_acc_fields[Field];
                  $string.= ','  .$Fields[$i][$j];
                  $string1.=","  .$Fields[$i][$j];
                  $string2.=",$".$Fields[$i][$j];
                  $j++;
    	         }
//    	 print '<br>'.$Tables[$i].$string;
//    	 print '<br>'.$Tables[$i].$string1;
//    	 print '<br>'.$Tables[$i].$string2;
 
//       print '<pre>'; 
//       print_r($QueryResult); 
//       print '</pre>'; 
         $string1           = substr($string1,1);
         $string2           = substr($string2,1);
         $Table_Headers_DB  = array_merge($Table_Headers_DB,array($Tables[$i] => $Fields_1));
         $SQL_String1       = array_merge($SQL_String1     ,array($Tables[$i] => $string1 ));
         $SQL_String2       = array_merge($SQL_String2     ,array($Tables[$i] => $string2 ));
         $Fields_1          = $Work;
         $i++;
}
$FormTypes=$Tables; 
### Эту часть только при первом запуске, пока не созданы заголовки Table_Headers.php
include_once 'Table_Headers.php';
if (!$Table_Headers)
   {
    $Table_Headers   =$Table_Headers_DB;
     print '<br>***** $Table_Headers *****';
     print '<pre>'; 
     print_r($Table_Headers); 
     print '</pre>';
   }  
//print '<br>***** $Fields *****';
//print '<pre>'; 
//print_r($Fields); 
//print '</pre>';
//print '<br>***** $Table_Headers_DB *****';
//print '<pre>'; 
//print_r($Table_Headers_DB); 
//print '</pre>';
//print '<pre>'; 
//print_r($SQL_String1); 
//print '</pre>';
//print '<pre>'; 
//print_r($SQL_String2); 
//print '</pre>';
#
?> 