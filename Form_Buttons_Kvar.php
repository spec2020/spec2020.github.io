<!--без таблиц //--> 
<h4>Введите данные для поиска по ключам&nbsp;</h4>
<p></p>
  <form name="del" action="Equip_Search.php?FormType=<?php print $FormType;?>" method=post>
   &nbsp&nbspКод товара&nbsp&nbsp        
    <input type="text"   name="Id" size=10 maxlength=8          value="">
    &nbsp;
    &nbsp&nbsp;Наименование компании &nbsp&nbsp         
    <input type="text"   name="client" size=10 maxlength=10     value="">
    &nbsp;
    &nbsp&nbsp; Наименование товара  &nbsp&nbsp        
    <input type="text"   name="material" size=10 maxlength=10   value="">
    <INPUT TYPE="submit" NAME="SEARCH" VALUE="   Найти    ">
    &nbsp; 
  </form>