<!--без таблиц //--> 
<?php include 'Header.php';?>
<h4>Введите данные для поиска по ключам.&nbsp;</h4>
<p></p>
  <form name="del" action="Staff_Search.php" method=post>
   &nbsp&nbspДолжность сотрудника&nbsp&nbsp        
    <input type="text"   name="post" size=10 maxlength=8    value="">
    &nbsp;
    &nbsp&nbsp;Наличие сертификата  &nbsp&nbsp         
    <input type="text"   name="sert" size=10 maxlength=10  value="">
    &nbsp;
    &nbsp&nbsp;Год выдачи сертификата&nbsp&nbsp        
    <input type="text"   name="year" size=10 maxlength=10   value="">
    <INPUT TYPE="submit" NAME="SEARCH" VALUE="   Найти    ">
    &nbsp;
  </form> 