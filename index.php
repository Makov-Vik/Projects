<?php


$input_text ="";
$input_text = $_POST['text_input'];

$openKey = '';
$openKey = $_POST['open_key_field'];

$privateKey = '';
$privateKey = $_POST['private_key_field'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>сipher_HUB</title>
    <link rel="stylesheet" href="cipher.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="adaptive.css">
</head>
<body>
  <header>
    <h1 align='center'>cipher <mark>hub</mark></h1>
    <h3 id = 'motto' align='center'><q>In God we trust</q></h3>
  </header>
 
  <nav>
    <ul>
      <li><a href="index.php">Encrypt</a></li>
    </ul>
  </nav>



<form method="POST">
  <input id = "button" type = 'submit' name='unicode' value = 'Unicode' class='button'>
  <input id = 'asym_cipher' type = 'submit' name='asym_cipher' value = 'Asymmetrical cipher' class='button'>
  <input id = 'asym_decryption' type = 'submit' name='asym_decryption' value = 'Asymmetrical decryption'>
  <input id = 'get_history' type = 'submit' value = 'History'  name='get_history'>

  <input type='text' name='text_input' id='text_input' size="40" value="<?=$input_text?>">
   
<?php
 require('unicode.php');
 require('openKey.php');
 require('privateKey.php');
?> 


<br /><br /><br /><br /><br /><br /><br />
<h3 id = 'open_inscription'>Your Open Key </h3>

<input type='text' name='open_key_field' id='open_key_field' size="40" value="<?=$openKey?>">

<br />

<h3 id = 'private_inscription'>Your Private Key  </h3>

<input type='text' name='private_key_field' id='private_key_field' size="40" value="<?=$privateKey?>">
</form>
</body>
</html>

<?php

require('connection.php');

if (isset($_POST['get_history'])) {

  $sql = "SELECT * FROM history";
  if($result = $connection->query($sql)){
      echo '<br>';
      while($row = $result->fetch_array()){
          
          $id = $row["id"];
          $text_encrypted = $row["text_encrypted"];
          $text_decrypted = $row["text_decrypted"];

          echo  $id . '. ' . $text_encrypted  . "<br>";
          echo str_repeat('&nbsp;', 6); 
          echo   $text_decrypted . "<br><br>" ;

      }
  }
}
?>
