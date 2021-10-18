<?php

namespace App\Jobs;

use DOMDocument;
use RedBeanPHP\R;
//require_once "C:\OpenServer\domains\work\public\index.php";
R::setup( 'mysql:host=localhost;dbname=xml','mysql', '' );

use XMLWriter;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

//  class RedBean_SimpleModel extends \RedBeanPHP\SimpleModel {};
// class R extends \RedBeanPHP\Facade{};

class StartXml extends AbstractJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // /**
    //  * Create a new job instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     //
    // }

    // /**
    //  * Execute the job.
    //  *
    //  * @return void
    //  */
    public function handle()
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0','UTF-8');
        $writer->setIndent(4);
        
        
        $db = R::find('xml', 'id <= 4');
        $writer->startElement('yml_catalog');
        $yml_catalog = $db[1]["yml_catalog"];
        $writer->writeAttribute('date', "$yml_catalog");
        
        $writer->writeElement('shop', '');
        $writer->endElement();
        $writer->endDocument();
        $filename = "storage/outfile.xml";
        $file = $writer->outputMemory();
        file_put_contents($filename,$file);
        

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load('storage/outfile.xml');

        $shop = $dom->getElementsByTagName('shop')->item(0);
        $categories = $dom->createElement('catgories');

        for($i = 2; $i <= 3; $i++){
            $date = $db[$i]['category_'];
            $date_id = $db[$i]['category_id']; 
            $date_parent_id = $db[$i]['parent_id']; 
            $category = $dom->createElement('category', $date);

            $category->setAttribute('id', "$date_id");
            if ($date_parent_id != null) {
                
                $category->setAttribute('parentId', "$date_parent_id");
            }
            $categories->appendChild($category);
        }
        $shop->appendChild($categories);

        $date_currency = $db[4]['currency_'];
        $date_currency_code = $db[4]['currency_code'];

        $currency = $dom->createElement('currency', "$date_currency");
        $currency->setAttribute('code', "$date_currency_code");
        $shop->appendChild($currency);

        $offers = $dom->createElement('offers');
        $shop->appendChild($offers);
        $dom->save('storage/outfile.xml');

    }
}
