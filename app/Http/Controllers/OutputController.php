<?php

namespace App\Http\Controllers;

use App\Jobs\MainJob;
use App\Jobs\GetDateJob;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    public function out(){

        $job = new MainJob();
        
        dispatch($job);
        echo "Data has gone for processing";
        
    }
}
