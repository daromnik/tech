<?php

namespace App\Http\Controllers\Projects;

use App\Models\Query;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Files\XlsReader;
use Illuminate\Support\Facades\Storage;

class QueryController extends Controller
{
    /**
     * Загрузка запросов из файла в базу
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function loadQueries(Request $request)
    {
        $this->validate($request, [
            "queryFile" => "required|file|mimes:xls,xlsx"
        ]);

        $groupId = $request->group_id;
        $oldQueries = Query::where("group_id", $groupId)->get();

        $file = $request->file("queryFile");
        $path = $file->store('tmp');
        $reader = new XlsReader(Storage::path($path));
        $cells = $reader->readFile();
        for ($row = 1; $row <= $cells->getHighestRow(); $row++)
        {
            $nameQuery = $reader->getCellValue($cells, "A", $row);

            if(is_null($nameQuery))
            {
                continue;
            }

            $query = $oldQueries->where("name", $nameQuery)->first();

            if(is_null($query))
            {
                $query = new Query();

                $query->group_id = $groupId;
                $query->name = $nameQuery;
            }

            $query->url = $reader->getCellValue($cells, "B", $row);
            $query->title =  $reader->getCellValue($cells, "C", $row);
            $query->description =  $reader->getCellValue($cells, "D", $row);
            $query->h1 =  $reader->getCellValue($cells, "E", $row);
            $query->cost =  $reader->getCellValue($cells, "F", $row);

            $query->save();
        }

        Storage::delete($path);

        return back();
    }
}
