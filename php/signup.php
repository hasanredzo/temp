<?php
@session_start();

$db = new SQLite3('/www/temp/control4.db') or die('Unable to open database');

$isUser = "0";

$myusername=$_POST['username']; 
$mypassword=$_POST['password'];

#echo "Total number of rows " . $total;

if(isset($_GET['login'])){

  $statement = $db->prepare('SELECT count(*) FROM C4users WHERE username=? and passwrd=?;');
  $statement->bindValue(1, $myusername, SQLITE3_TEXT);
  $statement->bindValue(2, $mypassword, SQLITE3_TEXT);
  $result = $statement->execute();

  $row = $result->fetchArray();

  $total = $row[0];
  if($total > 0){

    $statement = $db->prepare('SELECT * FROM C4users WHERE username=? and passwrd=?;');
    $statement->bindValue(1, $myusername, SQLITE3_TEXT);
    $statement->bindValue(2, $mypassword, SQLITE3_TEXT);
    $result = $statement->execute();
  
    $row = $result->fetchArray();

    $_SESSION['user'] = $row['username'];
    $_SESSION['passwrd'] = $row['passwrd'];
    $_SESSION['lvl'] = $row['lvl'];
  }else{
    $isUser = "-2";
  }
 
}elseif(isset($_GET['reg'])){

  $statement = $db->prepare('SELECT count(*) FROM C4users WHERE username=?;');
  $statement->bindValue(1, $myusername, SQLITE3_TEXT);
  $result = $statement->execute();

  $row = $result->fetchArray();
  if($total > 0){
    $isUser = "-1";
  
  }else{
    $statement = $db->prepare("INSERT INTO C4users VALUES (NULL, ?,?, 3);");
    $statement->bindValue(1, $myusername, SQLITE3_TEXT);
    $statement->bindValue(2, $mypassword, SQLITE3_TEXT);
    $result = $statement->execute();
    $isUser = "1";
  }
}


$_SESSION['isUser'] = $isUser;
header("location:../index.php");
?>