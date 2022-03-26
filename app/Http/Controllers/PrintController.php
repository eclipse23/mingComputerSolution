<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sold;
use Illuminate\Http\Request;
use App\Http\Resources\Sold\SoldCollection;

class PrintController extends Controller
{
    public function dateReport($date)
    {
        $sold = Sold::whereDate('created_at', '=', Carbon::parse($date))->with('product')->get();
        $data = new SoldCollection($sold);

        return view('print', ['data' => $data->resource]);
    }

    public function monthReport($month, $year)
    {
        $sold = Sold::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->with('product')->get();
        $data = new SoldCollection($sold);
        
        return view('print', ['data' => $data->resource]);
    }

    public function yearReport($year)
    {
        $sold = Sold::whereYear('created_at', '=', $year)->with('product')->get();
        $data = new SoldCollection($sold);
        
        return view('print', ['data' => $data->resource]);
    }
}
