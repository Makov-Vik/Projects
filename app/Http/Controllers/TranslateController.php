<?php

namespace App\Http\Controllers;

use App\Models\xml;

use Illuminate\Http\Request;

use R;
use XMLReader;

use function PHPSTORM_META\type;

class TranslateController extends Controller
{

    public function translate()
    {
        $xml_file = new XMLReader;

        $path = 'C:\OpenServer\domains\work\resources\views\file.xml';
        $xml_file->open($path);

        while ($xml_file->read()) {
            if ($xml_file->nodeType == XMLReader::ELEMENT) {
                $tag = $xml_file->name;
                switch ($tag) {
                    case 'yml_catalog':
                        $xml_db = R::dispense('xml');
                        $yml_catalog = $xml_file->getAttribute('date');
                        $xml_db->yml_catalog = $yml_catalog;
                        R::store($xml_db);
                        break;

                    case 'categories':
                        // works until it sees the end tag "</categories>"
                        while ($xml_file->read() && $xml_file->name != 'categories') {
                            if ($xml_file->nodeType == XMLReader::ELEMENT && $xml_file->name === 'category') {
                                $xml_db = R::dispense('xml');

                                $category = $xml_file->readInnerXml();
                                $category_id = $xml_file->getAttribute('id');
                                $xml_db->category_ = $category;
                                $xml_db->category_id = $category_id;

                                if ($xml_file->getAttribute('parentId')) {
                                    $parent_id = $xml_file->getAttribute('parentId');
                                    $xml_db->parent_id = $parent_id;
                                }
                                R::store($xml_db);
                            }
                        }
                        break;

                    case 'currency':
                        $xml_db = R::dispense('xml');
                        $currency_ = $xml_file->readInnerXml();
                        $currency_code = $xml_file->getAttribute('code');
                        $xml_db->currency_ = $currency_;
                        $xml_db->currency_code = $currency_code;

                        R::store($xml_db);
                        break;

                    case 'offers':
                        while ($xml_file->read() && $xml_file->name != 'offers') {
                            if ($xml_file->nodeType == XMLReader::ELEMENT && $xml_file->name === 'offer') {
                                $xml_db = R::dispense('xml');

                                // get attributes from offer
                                while ($xml_file->MoveToNextAttribute()) {
                                    $item = $xml_file->name;
                                    $value = $xml_file->value;
                                    $xml_db->{$item . '_offer'} = "$value";
                                }

                                // cycle for processing offers
                                while ($xml_file->read() && $xml_file->name != 'offer') {
                                    if ($xml_file->nodeType == XMLReader::ELEMENT) {

                                        $item = $xml_file->name;
                                        $sense = $xml_file->readInnerXml();

                                        // parse special symbols
                                        $sense = htmlspecialchars($sense, ENT_XML1 | ENT_QUOTES);

                                        if ($item === 'param') {
                                            $attr = $xml_file->getAttribute('name');
                                            $xml_db->{$item . '_offer'} .= "$attr:$sense:";
                                        } else {
                                            $xml_db->{$item . '_offer'} = "$sense";
                                        }
                                    }
                                }
                                R::store($xml_db);
                            }
                        }
                        break;
                }
            }
        }
        echo "Okey :)";
        $xml_file->close();
    }
}
