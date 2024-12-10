<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class LeadImport implements ToArray
{

    public static function fields(): array
    {
        return array(
            array('id' => 'name', 'name' => __('Lead Name'), 'required' => 'No'),
            array('id' => 'email', 'name' => __('Email'), 'required' => 'No'),
            array('id' => 'mobile', 'name' => __('Mobile'), 'required' => 'Yes'),
            array('id' => 'notes', 'name' => __('Notes'), 'required' => 'No'),
        );
    }

    public function array(array $array): array
    {
        return $array;
    }

}
