<?php

namespace App\Jobs;

use StoreXMLReader;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use XMLReader;

class GetDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
      /**
     * Экземпляр подкаста.
     *
     * @var App\Models\Job
     */
    private $XmlStr;
    /**
     * Create a new job instance.
     * @return void
     */

    public function __construct()
    {
        //
        //$this->XmlStr = $xml;
    }

    /**
     * Execute the job.
     * @return void
     */

    public function handle()
    {
        //logs()->info("Create new record [{$this->XmlStr}]");

        // $xw = xmlwriter_open_memory();
        // xmlwriter_set_indent($xw, 1);
        // $res = xmlwriter_set_indent_string($xw, ' ');

        // xmlwriter_start_document($xw, '1.0', 'UTF-8');

        // xmlwriter_start_element($xw, 'tag1');
        // xmlwriter_write_comment($xw, 'This is a comment.');
        //xmlwriter_end_element($xw);

        //xmlwriter_end_document($xw);

        //echo xmlwriter_output_memory($xw);


        // $filename = "storage/outfile.xml";
        // $file = xmlwriter_output_memory($xw);
        // file_put_contents($filename,$file);

    }
}


