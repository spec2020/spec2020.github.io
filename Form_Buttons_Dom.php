<!--без таблиц //--> 
<h4>Введите данные для поиска по ключам&nbsp;</h4>
<p></p>
  <form name="del" action="Dom_Search.php?FormType=<?php print $FormType;?>" method=post>
   &nbsp;&nbsp;Район (сокращ.)&nbsp;&nbsp;        
    <input type="text"   name="region" size=10 maxlength=10     value="">
    &nbsp;
    &nbsp;&nbsp;Площадь более&nbsp;&nbsp;         
    <input type="text"   name="ploshad" size=10 maxlength=10    value="">
    &nbsp;
    &nbsp;&nbsp; Участок более&nbsp;&nbsp;        
    <input type="text"   name="uchastok" size=10 maxlength=10   value="">
    &nbsp;
    &nbsp;&nbsp; Цена менее&nbsp;&nbsp;        
    <input type="text"   name="price" size=10 maxlength=10      value="">
    <INPUT TYPE="submit" NAME="SEARCH" VALUE="   Найти    "> 
    &nbsp;
  </form>