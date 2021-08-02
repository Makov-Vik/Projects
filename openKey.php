<?php

$input_text ="";
$input_text = $_POST['text_input'];  // text to encrypt
$openKey = $_POST['open_key_field']; // open key

if (isset($_POST['asym_cipher'])) {

  $firstKey = explode(' ', $openKey)[0]; // first number of open key
  $secondKey = explode(' ', $openKey)[1]; // second number

  $out = str_split($_POST['text_input']); // splitting the input string into characters
  $date = idate('d');

  
  for ($i = 0; $i < count($out); $i++) {
    $out[$i] = mb_ord("$out[$i]", "utf8");
  } 

  array_unshift($out, $date + 33); // create the first element to obfuscate the message


  set_error_handler(function ($severity, $message, $file, $line) {
    throw new  \ErrorException($message, $severity, $severity, $file, $line);
  });

  try{
    for ($i = 0; $i < count($out) - 1; $i++) {
      
      $out[$i + 1]  = bcmod(bcpow($out[$i + 1], $firstKey), $secondKey);  // asymmetric encryption
      $out[$i + 1] = $out[$i + 1]+ $date + 33;
      
      $out[$i + 1] += $out[$i]; // entanglement
      
    }

    for ($i = 0; $i < count($out); $i++) {
      $out[$i] = mb_chr($out[$i], "utf8");
    }  

    $outstring = implode("", $out);

    echo "<br><div class = 'mt-10', id = 'text_out' >$outstring<div>";

    require('connection.php');

    $sqlOpenKey = "INSERT INTO history (text_encrypted, text_decrypted) VALUES ('$input_text', '$outstring')";
    if (mysqli_query($connection, $sqlOpenKey)) {
    } else {
        echo "Error: " . $sqlOpenKey . "<br>" . mysqli_error($connection);
    }
  } catch (Throwable  $e) {
    echo  '<br>' . $e->getMessage() .  ". Wrong key";
  }
} 

?>