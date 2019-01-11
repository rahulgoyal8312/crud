<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Example;
use PDF;

class ExampleController extends Controller
{
 	public function export_pdf(){
 		$data="Some data";
 		// dd($data);
		$pdf = PDF::loadView('pdf', compact('data'));
      	return $pdf->download('invoice.pdf');	
	}   
}
