<?php

$input_text ="";
$input_text = $_POST['text_input'];  // text to decrypt
$privateKey = $_POST['private_key_field']; // private key

if (isset($_POST['asym_decryption'])) {

  $firstKey = explode(' ', $privateKey)[0]; // first number of open key
  $secondKey = explode(' ', $privateKey)[1]; // second number

  $out = mb_str_split($_POST['text_input']); // splitting the input string into characters
  $date = idate('d');

  set_error_handler(function ($severity, $message, $file, $line) {
    throw new  \ErrorException($message, $severity, $severity, $file, $line);
  });

  try{
    for ($i = 0; $i < count($out); $i++) {
      $out[$i] = mb_ord("$out[$i]", "utf8");
    } 
    
    for ($i = count($out) - 1; $i > 0 ; $i--) { // untangling
      $out[$i] = $out[$i] - $out[$i - 1];

    } 

    for ($i = 0; $i < count($out) - 1; $i++) {
      ///  magic number 33 ===================================================================================
      $out[$i + 1] = $out[$i + 1] - $date - 33;
      
      $out[$i + 1]  = bcmod(bcpow($out[$i + 1], $firstKey), $secondKey); // asymmetric decryption
      
    }

    for ($i = 1; $i < count($out); $i++) {
      $out[$i] = mb_chr($out[$i], "utf8");
    }  
    array_shift($out);
    $outstring = implode("", $out);
    
    echo "<br><div class = 'mt-10', id = 'text_out' >$outstring<div>";
    
    require('connection.php');

    $sqlPrivateKey = "INSERT INTO history (text_encrypted, text_decrypted) VALUES ('$input_text', '$outstring')";
    if (mysqli_query($connection, $sqlPrivateKey)) {
    } else {
        echo "Error: " . $sqlPrivateKey . "<br>" . mysqli_error($connection);
    }

  }catch (Throwable  $e) {
  echo  '<br>' . $e->getMessage() .  ". Wrong key";
  }
} 
?>