<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (isset($row[0]) && strtolower($row[0]) === 'name') {
            return null; 
        }
        return new Student([
            'name' => $row[0],  
            'grade' => $row[1]
        ]);
    }
}
