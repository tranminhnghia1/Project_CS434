<?php

namespace App\Exports;

use App\Models\Info_order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Info_order::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Mã đơn hàng',
            'Khách hàng',
            'Số lượng sản phẩm',
            'Tổng tiền',
            'Trạng thái',
            'Thời gian',
        ];
    }
}
