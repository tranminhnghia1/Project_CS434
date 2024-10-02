<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            '',
            'Tên sản phẩm',
            'Giá',
            'Danh mục',
            'Thời gian',
            'Người tạo',
            'Trạng thái',
            '',
        ];
    }
}
