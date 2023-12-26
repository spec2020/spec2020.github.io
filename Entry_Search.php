<?php
include      'Header.php';
print "
<p></p>
<table bgcolor='#999999' border='0' height='8' width='1240' cellpadding='1' cellspacing='1' align='center'>
  <tr>
  <td align='center'  bgcolor='#FFFFFF'> 
";
/*
$areaname  =$_GET["areaname"];
$username  =$_SERVER["PHP_AUTH_USER"];
$passwd    =$_SERVER["PHP_AUTH_PW"];
$Status    ='Руководитель';
$username=$_SERVER['REMOTE_USER'];
*/
#
if (!$msq)
     print "<br><strong>Добро пожаловать ".$username.'!</strong>';
else print "<br><strong>$msq</strong>";
//print "<br><strong>Hello ".$name.'<br>You have been successfully authorized!</strong>';
//print "<br><strong>Hello ".$server_remote_user.'<br>You have been successfully authorized!</strong>';
print "<br><br><img src = '../../RealEstateDB/Pictures/search.png'>&nbsp;";
include 'Form_Buttons_Dom.php'; 
print   '<strong><font color="Silver"> ( Примеры: 1. Район: Долг(Все дома Догопрудный) 
                                                  2. То же и Площадь: более 150 м.кв.
                                       )           
         </font></strong>';
/*
print   "<br><br><img src = '../../RealEstateDB/Pictures/lock_gre.gif'>&nbsp;";
include 'Form_Buttons_Kvar.php'; 
print   '<strong><font color="Silver"> ( Примеры: 1. Строй - все товары компании Строинвест 
                                                  2. Кирп, продающие кирпич
                                       )
         </font></strong>';
*/
print   "<br><br><img src = '../../RealEstateDB/Pictures/search.png'>&nbsp;";
include 'Form_Buttons_AllDB.php'; 
print   '<strong><font color="Silver"> ( Примеры: 1. Панель  - все наименования с этим значением 
                                          
                                       )
         </font></strong>';
    
print   "
</td>
</tr>
</table>";
include 'Footer.php';
?>