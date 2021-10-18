<?php

$conn = mysqli_connect('work2', 'mysql', '', 'xml');
mysqli_select_db($conn, 'xml');

$sql = "SELECT * FROM xmls limit 2";
$res = mysqli_query($conn, $sql);


$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

// pull date from table
$row = mysqli_fetch_assoc($res);

$yml_catalog = $xml->createElement('yml_catalog' );
$date = $xml->createAttribute('date');
$date->value = $row['yml_catalog'];
$yml_catalog->appendChild($date);


$shop = $xml->createElement('shop');
$offers = $xml->createElement('offers');

  foreach($res as $row2) {

    $category = $xml->createElement('category', $row2['category']);
    $attr_category = $xml->createAttribute('id');
    $attr_category->value = $row2['id'];  

    if($row2['parentId'] != ''){
      $attr_category_id = $xml->createAttribute('parentId');
      $attr_category_id->value = $row2['parentId'];
      $category->appendChild($attr_category_id);

      $currency = $xml->createElement('currency', $row2['currency']);
      $currency_code = $xml->createAttribute('code');
      $currency_code->value = $row2['currency_code'];  
      
      $shop->appendChild($currency);
    }    
    
    $category->appendChild($attr_category);
    $shop->appendChild($category);
  }

// Cycle of offers

// use limit, because OFFSET dont working
$query = "SELECT * FROM xmls LIMIT 2,100";

if ($result = mysqli_query($conn, $query)) {

  /* Получим информацию обо всех столбцах */
  while ($finfo = mysqli_fetch_array($result)) {

    $offer = $xml->createElement('offer');
 
    $attr_offer_available = $xml->createAttribute('available');
    $attr_offer_available->value =  $finfo['offer_available'];

    $attr_id = $xml->createAttribute('id');
    $attr_id->value =  $finfo['offer_id'];
    
    $attr_external_id = $xml->createAttribute('external_id');
    $attr_external_id->value =  $finfo['offer_external_id'];

    $attr_sync_date = $xml->createAttribute('sync_date');
    $attr_sync_date->value =  $finfo['offer_sync_date'];

    $attr_saler_price = $xml->createAttribute('saler_price');
    $attr_saler_price->value =  $finfo['offer_saler_price'];


    $url = $xml->createElement('url', $finfo['url']);
    $category = $xml->createElement('category', $finfo['categoryId']);
    $pn = $xml->createElement('pn', $finfo['pn']);
    $price = $xml->createElement('price', $finfo['price']);
    $picture = $xml->createElement('picture', $finfo['picture']);
    $vendor = $xml->createElement('vendor', $finfo['vendor']);
    $model = $xml->createElement('model', $finfo['model']);
    $description = $xml->createElement('description', $finfo['description']);
    $short_description = $xml->createElement('short_description', $finfo['short_description']);
    $param = $xml->createElement('param', $finfo['param']);


    $offer->appendChild($attr_offer_available);
    $offer->appendChild($attr_id);
    $offer->appendChild($attr_external_id);
    $offer->appendChild($attr_sync_date);
    $offer->appendChild($attr_saler_price);

    $offer->appendChild($url);
    $offer->appendChild($category);
    $offer->appendChild($pn);
    $offer->appendChild($price);
    $offer->appendChild($picture);
    $offer->appendChild($vendor);
    $offer->appendChild($model);
    $offer->appendChild($description);
    $offer->appendChild($short_description);
    $offer->appendChild($param);


    $offers->appendChild($offer);
  }
  mysqli_free_result($result);
}


$shop->appendChild($offers);

$yml_catalog->appendChild(($shop));

$xml->appendChild($yml_catalog);


$xml->save('C:\OpenServer\domains\work\resources\views\outfile.xml');
echo 'Okey baby';

?><?php /**PATH C:\OpenServer\domains\work\resources\views/output.blade.php ENDPATH**/ ?>