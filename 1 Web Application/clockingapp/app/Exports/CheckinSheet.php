<?php 

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use App\User;
use App\UserCheckIn;


class CheckinSheet implements FromQuery, WithTitle, WithMapping, WithEvents{
    
    private $user;

    public function __construct(int $id)
    {
        $this->user = User::find($id);
    }

    public function query()
    {
        return UserCheckIn::where('user_id', $this->user->id);
    }

    public function title(): string
    {
        return 'User ' . $this->user->name;
    }

    public function map($check): array
    {
        return [
            date('D j/M/y', strtotime($check->created_at)),
            date('H:i', strtotime($check->time_in)) . ' Hrs',
            date('H:i', strtotime($check->time_out)) . ' Hrs',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class  => function(BeforeSheet $event) {
                $event->sheet->append(["DATE", "TIME IN", "TIME OUT"]);
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->autoSize();
            },
        ];
    }
}