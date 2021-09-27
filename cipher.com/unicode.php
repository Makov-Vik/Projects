<?php

$input_text ="";
$input_text = $_POST['text_input'];

function encryptByUnicode(&$item, $prefix, &$key) {

  $item2 = mb_ord("$item", "utf8");
  $rand = mt_rand(200, 1000);
  $item2 = $item2 + $rand;
  array_push($key, $rand);

  $item = mb_chr($item2, "utf8");

}

if (isset($_POST['unicode'])) {

  $key = array();
  $out = str_split($_POST['text_input']); // splitting the input string into characters
  array_walk($out, 'encryptByUnicode', $key);

  $outstring = '';

  $outstring = implode("", $out);

  echo "<br><div class = 'mt-10', id = 'text_out' >$outstring</div>";
  echo "<br><div class = 'mt-10', id = 'text_out' >$input_text</div>";

  require('connection.php');

  $sql = "INSERT INTO history (text_encrypted, text_decrypted) VALUES ('$input_text', '$outstring')";
  if (mysqli_query($connection, $sql)) {
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($connection);
  }
}

?>