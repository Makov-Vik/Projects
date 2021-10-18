<?php

namespace App\Jobs;

use DOMDocument;
use RedBeanPHP\R;
require_once "app\Jobs\StartXml.php";

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddOffers extends AbstractJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load('storage/outfile.xml');

        $alloffers = R::count('xml');

        // how many offers are in the request
        $per_request = 2;

        // the number of offers in the last request
        $rest = ($alloffers - 4) % $per_request;

        $offers = $dom->getElementsByTagName('offers')->item(0);

        // there are no suggestions made right now, but the suggestion line starts in 5
        $offer_done = 4;

        while($offer_done < $alloffers){
            
            $part_offers = R::findLike('xml', [ 'id' => range($offer_done + 1, $offer_done + $per_request) ]);
            for($item = $offer_done + 1; $item <= ($offer_done + $per_request); $item++){

                $offer = $dom->createElement('offer');
    
                $attr_offer_available = $dom->createAttribute('available');
                $attr_offer_available->value =  $part_offers["$item"]['offer_available'];

                $attr_id = $dom->createAttribute('id');
                $attr_id->value =  $part_offers["$item"]['id_offer'];
                
                $attr_external_id = $dom->createAttribute('external_id');
                $attr_external_id->value =  $part_offers["$item"]['external_id_offer'];

                $attr_sync_date = $dom->createAttribute('sync_date');
                $attr_sync_date->value =  $part_offers["$item"]['sync_date_offer'];

                $attr_saler_price = $dom->createAttribute('saler_price');
                $attr_saler_price->value =  $part_offers["$item"]['saler_price_offer']; 

                $offer->appendChild($attr_offer_available);
                $offer->appendChild($attr_id);
                $offer->appendChild($attr_external_id);
                $offer->appendChild($attr_sync_date);
                $offer->appendChild($attr_saler_price);

                $url = $dom->createElement('url', $part_offers["$item"]['url_offer']);
                $category = $dom->createElement('category', $part_offers["$item"]['categoryId_offer']);
                $pn = $dom->createElement('pn', $part_offers["$item"]['pn_offer']);
                $price = $dom->createElement('price', $part_offers["$item"]['price_offer']);
                $picture = $dom->createElement('picture', $part_offers["$item"]['picture_offer']);
                $vendor = $dom->createElement('vendor', $part_offers["$item"]['vendor_offer']);
                $model = $dom->createElement('model', $part_offers["$item"]['model_offer']);
                $description = $dom->createElement('description', $part_offers["$item"]['description_offer']);
                $short_description = $dom->createElement('short_description', $part_offers["$item"]['short_description_offer']);
                
                $offer->appendChild($url);
                $offer->appendChild($category);
                $offer->appendChild($pn);
                $offer->appendChild($price);
                $offer->appendChild($picture);
                $offer->appendChild($vendor);
                $offer->appendChild($model);
                $offer->appendChild($description);
                $offer->appendChild($short_description);
                                
                $param = explode(":", $part_offers["$item"]['param_offer']);
                for($j = 1; $j < count($param); $j +=2){
                    $param_element = $dom->createElement('param', $param[$j]);
                    $attr_param =  $dom->createAttribute('name');
                    $attr_param->value =   $param[$j - 1];
                    $param_element->appendChild($attr_param);
                    $offer->appendChild($param_element);
                }

                $offers->appendChild($offer);

                $dom->save('storage/outfile.xml');
            }
           
            $offer_done += $per_request;
            if(($alloffers - $offer_done) == $rest) $per_request = $rest;
        }
    }
}
