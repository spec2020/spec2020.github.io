<!--без таблиц //--> 
<p></p>
  <form action="Tables_Handler.php?FormType=<?php print $FormType?>" method=post>
  <!--form action="<?php //print $FormType;?>_Handler.php" method=post/-->
   <strong>Введите Id код для удаления, поиска или обновления&nbsp;</strong>      
    <input type="text"   name  ="<?php print  $headers_db[0];?>" size=10 maxlength=10  
                         value ="<?php print $$headers_db[0];?>">
    <INPUT TYPE="submit" NAME="Delete" VALUE="Удалить">
    &nbsp;
    <INPUT TYPE="submit" NAME="Search" VALUE="Найти">
    &nbsp;
    <INPUT TYPE="submit" NAME="Update" VALUE="Обновить"> 
    &nbsp;
  </form>