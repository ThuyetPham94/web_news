<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Auth;

use App\Jobs\ImportExcel;

class WordImport implements OnEachRow
{
  public function onRow(Row $row)
  {
    $rowIndex = $row->getIndex();
    if ($rowIndex == 1)
      return;
    $row      = $row->toArray();
    ImportExcel::dispatch($row, Auth::guard()->user()->id)->onQueue('processing');
  }
}