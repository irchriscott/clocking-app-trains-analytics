<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CheckinsExport;
use Excel;


class ExportController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function exportExcelFile(){
        return Excel::download(new CheckinsExport(), 'checkins.xlsx');
    }

    public function exportCSVFile(){
        return Excel::download(new CheckinsExport(), 'checkins.csv');
    }
}
