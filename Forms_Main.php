<?php 
####################################################################################
# Модуль выводит на экран форму для добавления данных в любую таблицу              #
# Если модуль вызывается по ссылке href="Forms_Main.php?formtype=Staff", в этом    #
# случае работает Get.                                                             #
# Однако модуль может вызываться и в случае обновления данных в таблице, тогда     #
# см. например Staff_Handler.php ...if  (isset($_POST["Update"]))... строка ~147   #             
# в полях формы появляются данные для обновления                                   #
#                                                                                  #
####################################################################################
if          ($_GET['formtype'])             //!!!//
 $FormType = $_GET['formtype']; 
require_once       'DB_Tables_Fields.php';  //!!!// 
# В этой версии формируется программой 'DB_Tables_Fields.php'
//require_once     'FormTypes.php';         //!!!//
#
require_once       'FormMsgs.php';
#
# Форма для добавления, удаления, обновления данных по подразделениям,
# сотрудникам, приборам, изделиям, результатам испытаний и пр.  
# Формируются исходные данные для формы и вызывается универсальный
# построитель форм такого вида Universal_Forms_Builder.php
###
# В случае вызова модуля для заполнения включаются эти include-ы
include_once   'Header.php';                 // Общий заголовок веб-страниц проекта
include_once   'Table_Headers.php';          // Заголовки таблиц и форм таблиц
# В этой версии Table_Headers_DB формируется программой 'DB_Tables_Fields.php'
//include_once   'Table_Headers_DB.php';     // Заголовки таблиц базы данных
include_once   'Any_Table_HTML_New.php';     // Класс для построения таблиц по 
                                             // заголовкам и содержанию
#
$handler      = 'Tables_Handler.php?FormType='.$FormType;
                                             // обработчик настоящей формы
//$handler      = $FormType.'_Handler';      // обработчик настоящей формы
$headers      = $Table_Headers   [$FormType];// наименования столбцов таблиц 
$headers_db   = $Table_Headers_DB[$FormType];// наименования доменов в таблице 
$head_color   = "silver";                    // Staff БД и input name's в формах
$form_headers = array(' Наименования полей',
                      ' Заносимые или обновляемые данные'
                      );
# Создаем объекты класса для вывода таблиц, вызываем конструктор
#                        
$Form_view   =  new HTML_Table($form_headers  , $head_color);
# Заголовок формы страницы
print    '<p><font color= "red" ><strong>'                 
            .$FormMsgs[$FormType][0].
            '</strong></font>
         </p>';                             // Заголовок формы страницы
#
# построитель простых форм такого вида Universal_Forms_Builder.php
#
$News      = $_GET[News];
$Autor     = $_GET[Autor];
include 'Universal_Forms_Builder.php';
?> 
<p></p>
</body>
</html>
