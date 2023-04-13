<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TestEport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    private $data;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    public function map($data): array
    {
        return [
            $data->name,
            $data->phone,
            $data->email
        ];
    }
    public function headings(): array
    {
        return [
            'TT',
            'TÊN HÀNG',
            'SỐ LƯỢNG',
            'ĐƠN GIÁ',
            'THÀNH TIỀN',
        ];
    }
    public function startCell(): string
    {
        return 'A8';
    }
    public function registerEvents(): array
    {
        // dd($this->data->count());
        $count = $this->data->count() + 10;
        return [AfterSheet::class => function (AfterSheet $event) use ($count) {
            $default_font_style = [
                'font' => [
                    'name' => 'Times New Roman', 'size' => 12, 'color' => ['argb' => '#FFFFFF'],
                    'background' => [
                        'color' => '#5B9BD5'
                    ]
                ]
            ];

            $active_sheet = $event->sheet->getDelegate();
            $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);
            $arrayAlphabet = [
                'A', 'B', 'C'
            ];
            foreach ($arrayAlphabet as $alphabet) {
                $event->sheet->getColumnDimension($alphabet)->setAutoSize(true);
            };
            $cellRange = 'A1:E1';
            $active_sheet->mergeCells($cellRange);
            $active_sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $active_sheet->setCellValue('A1', 'MULTI SHOP');
            $active_sheet->mergeCellsByColumnAndRow(1, 2, 5, 3)->getStyle('A2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $active_sheet->setCellValue('A2', 'HÓA ĐƠN BÁN HÀNG');
            $active_sheet->mergeCells('A5:C5');
            $active_sheet->setCellValue('A5', 'Tên Khách Hàng: ');
            $active_sheet->mergeCells('A6:C6');
            $active_sheet->setCellValue('A6', 'Địa Chỉ: ');
            $endRange = "A$count:E$count";
            $active_sheet->mergeCells($endRange);
            $active_sheet->setCellValue("A$count", 'Tổng Tiền: ');
            $active_sheet->getStyle($endRange)->getFont()->setBold(true);
            // $active_sheet->getStyle($cellRange)->applyFromArray($default_font_style);
            // $active_sheet->getStyle($cellRange)->getFont()
            //     ->getColor()->setRGB('000000');
            // $active_sheet->getStyle($cellRange)->getFill()
            //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            //     ->getStartColor()->setARGB('00d6d6c2');
            // $active_sheet->getStyle($cellRange)->getAlignment()->applyFromArray(
            //     array('horizontal' => 'center', 'vertical' => 'center')
            // );
            // $active_sheet->getStyle($cellRange)->getFont()->setBold(true);
        },];
    }
}
