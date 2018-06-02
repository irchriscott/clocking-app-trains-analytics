<?php 

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserCheckIn;


class CheckinsExport implements FromCollection, Responsable, WithMultipleSheets{
    
    use Exportable;

    private $fileName = 'checkins.xlsx';

    public function collection()
    {
        return UserCheckIn::all();
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach(User::all() as $user){
            $sheets[] = new CheckinSheet($user->id);
        }
        return $sheets;
    }

}