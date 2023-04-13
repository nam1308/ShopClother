<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $data;
    private $product;
    public function __construct($data, $product)
    {
        $this->data = $data;
        $this->product = $product;
    }
    public function collection()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        return $this->data;
    }
    public function map($data): array
    {
        $list = [];
        $index = 0;
        // dd($data->Customers->name);
        foreach ($data->OrderDetail as $item) {
            if ($index == 0) {
                $list[] = [
                    $data->Customers->name,
                    $data->quantity,
                    $data->price,
                    $data->note,
                    $data->phone,
                    $data->email,
                    $data->city,
                    $data->district,
                    $data->created_at,
                    $this->product[$item->id_product],
                    $item->quantity,
                    $item->price
                ];
                $index = 1;
            } else {
                $list[] = [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $data->created_at,
                    $this->product[$item->id_product],
                    $item->quantity,
                    $item->price
                ];
            }
        }

        return $list;
    }
    public function headings(): array
    {
        return [
            'Tên',
            'Tổng số lượng sản phẩm trong hóa đơn',
            'Tổng giá trị hóa đơn',
            'Ghi chú',
            'Số điện thoại',
            'Email',
            'Thành Phố',
            'Tỉnh/Quận',
            'Ngày tạo',
            'Tên sản phẩm',
            'Sô lượng từng sản phẩm trong hóa đơn',
            'Giá bán của sản phẩm'
        ];
    }
    public function registerEvents(): array
    {
        return [AfterSheet::class => function (AfterSheet $event) {
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
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
            ];
            foreach ($arrayAlphabet as $alphabet) {
                $event->sheet->getColumnDimension($alphabet)->setAutoSize(true);
            }

            // title
            $cellRange = 'A1:K1';
            $active_sheet->getStyle($cellRange)->applyFromArray($default_font_style);
            $active_sheet->getStyle($cellRange)->getFont()
                ->getColor()->setRGB('000000');
            $active_sheet->getStyle($cellRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00d6d6c2');
            $active_sheet->getStyle($cellRange)->getAlignment()->applyFromArray(
                array('horizontal' => 'center', 'vertical' => 'center')
            );
            $active_sheet->getStyle($cellRange)->getFont()->setBold(true);
        },];
    }
}
