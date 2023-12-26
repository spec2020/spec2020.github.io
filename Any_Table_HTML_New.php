<?php 
class Any_Table 
         {
          var $table_array = array(); 
          var $headers     = array();
          var $domns;
          function  Any_Table ($headers)
                           {
                            $this->headers = $headers;
                            $this->domns   = count($headers);
                           }

          function AddRow ($row)
                           {
                            If  ( count ($row) != $this->domns)
                                 return false;
                            array_push( $this -> table_array,  $row);
                            return true;
                           }
          function SetArr($Arr)
	                       {
	                        $this -> table_array = $Arr; 
	                        return true;
	                       } 	                           
          function  AddRowAssArr ($row_ass)
                           {
                            $row=array();
                            foreach ($this -> headers as $header) 
                            { if (!isset($row_ass[$header]))
                                   $row_ass[$header]=''; 
                              $row[ ]=$row_ass[$header];          
                            }
                            array_push( $this -> table_array,  $row);
                            return true;
                           }
          function PrintArr ()
                           { 
                           	print "<pre>";
                           	foreach ($this -> headers as $header)
                           	         print '  '."<strong>$header</strong>".' ';
                           	print "\n"; 
                           	foreach ($this -> table_array as $string)
                                 	{
                           	         foreach ($string as $elemnt) 
                           	 		          print '   '."$elemnt".'   ';
                           	         print "\n";
                           	        }
                           }	                
         } 
class HTML_Table extends Any_Table 
      {
	   var $bgcolor;
	   var $bgcolor_h = "#FFCCCC";
	   var $bgcolor_c = "#FFFFFF";
	   var $cellpadding = "5";
	   function HTML_Table($headers, $bg='#ffffff' )
	            {
	   	         Any_Table::Any_Table($headers);
	             $this->bgcolor=$bg;	        
	            }
	   function SetCellPadding ($padding)
	            {
	   	         $this -> cellpadding = $padding; 
	            }
	   function PrintArr()
	            {
	   	         print "<table bgcolor=\"#999999\" cellspacing=\"1\"  cellpadding=\"$this->cellpadding\" border=0>";
	   	         print "<tr>";
	   	         foreach ($this -> headers as $header)
                         print "<td align=\"center\" bgcolor=\"$this->bgcolor_h\">
                         &nbsp<font size=\"4\" color=\"Blue\">$header</font>
                         </td>";
                 print "</tr>";
                 foreach ($this -> table_array as $row=>$cells)
                         {
                          print "<tr>";	
        	              foreach ($cells as $elemnt)
        	                       print "<td align='center' bgcolor=\"$this->bgcolor_c\" >
        	                       &nbsp<font size='4'>$elemnt</font>
        	                       </td>"; 
        	              print "</tr>";         
                         }	
                 print '</table>';           	
	            }         
       function OutForm($handler)
                {
                 $width_h = array(170, 360);	
   	             print "<form name='uniform' action=\"$handler\" method=post>";
	             print "<table width=\"99%\" bgcolor=\"#999999\" cellspacing=\"1\"  cellpadding=\"$this->cellpadding\" border=0>";
	             print "<tr>";
	             $i=0;
	   	         foreach ($this -> headers as $header){
	   	         	      print "<td width='".$width_h[$i]."' align=\"left\" bgcolor=\"$this->bgcolor_h\">
	   	         	                 &nbsp<font size='4' color='Blue' >$header</font>
	   	         	             </td>";
	   	         	      $i++;
	   	                 }
                 print "</tr>";
                 $i=0;
                 foreach ($this -> table_array as $row=>$cells)
                         {
                          print "<tr>";	
        	              foreach ($cells as $elemnt)
        	                      {
        	                       print "<td width='".$width_h[$i]."' align='left' bgcolor=\"$this->bgcolor_c\" >$elemnt</td>";
        	                       if ($i==0) $i++; else $i--;
        	                      } 
        	              print "</tr>";         
                         }	
                 print '</table>'; 
                 print '</form>';    	
                }  
      } 
                                
?>
