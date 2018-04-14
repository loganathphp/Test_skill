<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class StockController extends Controller
{
    public function index()
    {
        $this->data['data'] = "";
        $files = File::allFiles(public_path() . "/json/");
		foreach ($files as $file)
		{
			 $json[] = json_decode(file_get_contents($file), true);
		}
		if(!empty($json))
		{$this->data['data'] = $json;}
        return view('form')->with($this->data);
    }

    public function save(Request $request)
    {
        $data = json_encode($request->all());
        $fileName = time() . '_file.json';
	  	$file = File::put(public_path('json/'.$fileName),$data);
        if($file){return 1;}
        	else{return 0;}
    }
}
