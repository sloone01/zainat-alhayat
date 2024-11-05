<?php

namespace App\Exports;

use App\Models\WorkLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;
use \Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Sheet;
use PhpParser\ErrorHandler\Collecting;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class WorkLogaExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private Collection $logs;
    public function __construct(Collection $logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'size' => 12]],
            2    => ['border' => ['bold' => true,'size' => 12]],

        ];
    }
    
    public function headings(): array
    {
        return ["ID", "Tech", "Planet","Job Type","Obs","Repairing", "MWO Number", "Equip No","Spares Consumed", "Time Taken", "Job Date"];
    }


    public function registerEvents(): array
    {
            return [
                AfterSheet::class => [self::class, 'afterSheet']
            ];
    }

    public static function afterSheet(AfterSheet $event){
        //Single Column


        $event->sheet->styleCells(
                    'A1:K1',
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' =>  "c0c0c0"]
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '#808080'],
                            ],
                        ]
                    ]
                );
        
    
        }


    public function map($log): array
    {
        return [
            $log->id,
            $log->tech->name,
            $log->planet->name,
            $log->jobType->title,
            $log->observation,
            $log->repairing,
            $log->mwo_number,
            $log->equip_no,
            $log->spare_consumed,
            $log->time_taken,
            $log->job_date
            
        ];
    }

}
