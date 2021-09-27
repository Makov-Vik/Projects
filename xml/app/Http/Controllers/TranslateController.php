<?php

namespace App\Http\Controllers;
use App\Models\xml;

use Illuminate\Http\Request;

class TranslateController extends Controller {

    public function translate() {

        $servername = "work2";
        $database = "xml";
        $username = "mysql";
        $password = "";

        // set connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully <br>";

        $xmlfile = simplexml_load_file(resource_path('/views/file.xml'));


        $yml_catalog = $xmlfile['date'];

        //add currency
        $currency = $xmlfile->shop->currency;
        $currency_code = $currency['code'];


        // add categories to table
        $categories = $xmlfile->shop->categories->category;

        foreach($categories as $item) {
            $id = $item['id'];

            if($item['parentId']) {
                $parentId = $item['parentId'];
                $sql = "INSERT INTO xmls (category, id, parentId, currency, currency_code) VALUES ('$item', '$id', '$parentId', '$currency', '$currency_code')";
            } 
            else $sql = "INSERT INTO xmls (yml_catalog, category, id) VALUES ('$yml_catalog', '$item', '$id')";

            
            
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully <br>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        unset($item);


        // add offers to table
        $offers = $xmlfile->shop->offers->offer;

        foreach($offers as $offer) {
            $attr=$offer->attributes();

            $offer_id = $attr['id'];
            
            // check checking the record for existence and update price, available, date
            $query = "SELECT * FROM xmls WHERE offer_id = '$offer_id'"; 
            $pull = mysqli_query($conn, $query); 
            
            $result = mysqli_fetch_object($pull);

            if (isset($result)) {
                //$id = $result->offer_id;

                $price = $offer->price;
                $available = $attr['available'];
                $sync_date = $attr['sync_date'];
                
                $sql = "UPDATE xmls SET price = '$price' , offer_available = '$available', offer_sync_date = '$sync_date' WHERE offer_id = '$offer_id'";
                
                if (mysqli_query($conn, $sql)) {
                    echo "New changes update successfully <br><br>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

            }
            else {
                
                $offer_available = $attr['available'];
                //$offer_id = $attr['id'];
                $offer_external_id = $attr['external_id'];
                $offer_sync_date = $attr['sync_date'];
                $offer_saler_price = $attr['saler_price'];

                $url = $offer->url;
                $categoryId = $offer->categoryId;
                $pn = $offer->pn;
                $price = $offer->price;
                $picture = $offer->picture;

                // collecting an array with possible characters: '"', '&', '>', '<', "'"
                $str = $offer->vendor;
                $str .= '@' . $offer->model;
                $str .= '@' . $offer->description;
                $str .= '@' . $offer->short_description;

                // add a few parameters
                $str .= '@';
                foreach($offer->param as $parameter) {
                    $str .= $parameter['name'] . ':' . $parameter . '; '; 
                }
                unset($parameter);


                // translate symbols
                $new = htmlspecialchars($str, ENT_QUOTES);

                // separate string to array
                $pieces = explode("@", $new);

                // add the rest items
                $vendor = $pieces[0];
                $model = $pieces[1];
                $description = $pieces[2];
                $short_description = $pieces[3];
                $param = $pieces[4];


                $sql = "INSERT INTO xmls (offer_available, offer_id, offer_external_id, offer_sync_date, offer_saler_price, url, categoryId, pn, price, picture, vendor, model, description, short_description, param) 
                VALUES ('$offer_available', '$offer_id', '$offer_external_id', '$offer_sync_date', '$offer_saler_price', '$url', '$categoryId', '$pn', '$price', '$picture', '$vendor', '$model', '$description', '$short_description', '$param' )";
                
                if (mysqli_query($conn, $sql)) {
                    echo "New record created successfully <br><br>";
                } else {
                    echo "Error: " . $sql . "<br><br>" . mysqli_error($conn) . '<br><br>';
                }
            }
        }
        unset($offer);

        mysqli_close($conn);

        
    }
    
}
