<?php 
class MySQL_DB
{
        private $dbObj = null;
        private $result = null; 
 
/* Для конструктора - адрес, имя пользователя, пароль, имя базы данных, порт,  
/*а также кодировку для соединения.
/* По умолчанию используется utf8 */ 
 
        public function __construct($host, $user, $password, $base, $port = null, $charset = 'utf8')
        {
                $this->dbObj = new mysqli($host, $user, $password, $base, $port);
                $this->dbObj->set_charset($charset);
        } 
 
/*основная и единственная функция, которая выполняет запрос и возвращает результат его работы*/ 
 
        public function query($query)
        {
                if(!$this->dbObj)
                        return false; 
 
/*очищаем предыдущий результат*/ 
 
                if(is_object($this->result))
                        $this->result->free(); 
 
/*выполняем запрос*/ 
 
                $this->result = $this->dbObj->query($query); 
 
/*если есть ошибки - выводим их*/ 
 
                if($this->dbObj->errno)
#!!!#              die("mysqli error #".$this->dbObj->errno.": ".$this->dbObj->error); 
                   return $this->dbObj->error; 
 
/*если в результате выполнения запроса (например SELECT...) получены данные - возвращаем их.
/* данные всегда возвращаются в массиве, даже если запрос возвращает одну запись.*/ 
 
                if(is_object($this->result))
                {
                        while($row = $this->result->fetch_assoc())
                                $data[] = $row;
                        
                        return $data;
                } 
 
/*если результат отрицательный - возвращаем false */ 
 
                else if($this->result == FALSE)
                        return false;
                        
/*если запрос (например UPDATE или INSERT) затронул какие-либо строки - возвращаем их количество*/ 
 
                else return $this->dbObj->affected_rows;
        }
}
require_once 'DB_data.php';
$dbObj = new MySQL_DB(DB_HOST, DB_USER, DB_PWD, DB_NAME);
require_once 'DB_Coding.php';
?>
