<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

class LocationsExports implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query(): mixed
    {
        return $this->query;
    }
    

     public function headings(): array
    {
        return [
            '#',
            'name',

        ];
    }


    public function map($location): array
    {
        static $sn = 0;
        $sn++;

        return [
            $sn,
            $location->name,

        ];
    }


}
