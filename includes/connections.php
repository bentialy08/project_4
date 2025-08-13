   <?php 
  
    $server="localhost"; 
    $user="bsaintju"; 
    $pass="Zavot.1992"; 
    $db="bsaintju"; 
      
    // connect to mysql 
      
    mysql_connect($server, $user, $pass) or die("Sorry, can't connect to the mysql."); 
      
    // select the db 
      
    mysql_select_db($db) or die("Sorry, can't select the database."); 
  
?>