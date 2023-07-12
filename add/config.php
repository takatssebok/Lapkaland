<?php  
  ob_start();
  session_start();

  //database details
  define('DBHOST','localhost');
  define('DBUSER','root');
  define('DBPASS','');
  define('DBNAME','blogDB');

  $db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Main URL 
  $base_url = "http://localhost/Lapkaland/";

  //set timezone  
  date_default_timezone_set('Europe/Budapest');

  // load class when needed
  function my_autoloader($class) 
  {
    
      $class = strtolower($class);
  
      //if call from within assets adjust the path
      $classpath = 'class/'.$class . '.php';
      if ( file_exists($classpath)) {
        require_once $classpath;
      }   
      
      //if call from within admin adjust the path
      $classpath = '../class/'.$class . '.php';
      if ( file_exists($classpath)) {
        require_once $classpath;
      }       
      
      //if call from within admin adjust the path
      $classpath = '../../class/'.$class . '.php';
      if ( file_exists($classpath)) {
        require_once $classpath;
      }       
          
  }

  my_autoloader('classUser');
  //spl_autoload_register('my_autoloader');
  $user = new User($db); 
  include("functions.php"); 
?>