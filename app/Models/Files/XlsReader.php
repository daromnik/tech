<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;

class XlsReader extends Model
{
    private $_reader;
    private $_file;

    public function __construct(string $filePath)
    {
        $this->_file = $filePath;
        $inputFileType = IOFactory::identify($this->_file);
        $this->_reader = IOFactory::createReader($inputFileType);
    }

    /**
     * метод загружает содержимое файла и возвращает коллекцию значений ячеек
     *
     * @return \PhpOffice\PhpSpreadsheet\Collection\Cells
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function readFile()
    {
        $spreadsheet = $this->_reader->load($this->_file);
        return $spreadsheet->getActiveSheet()->getCellCollection();
    }

    /**
     * Метод возвращает значение ячейки
     *
     * @param $cells \PhpOffice\PhpSpreadsheet\Collection\Cells
     * @param $col
     * @param $row
     * @return string | null
     */
    public function getCellValue($cells, $col, $row)
    {
        $cell = $cells->get($col.$row);
        if(!is_null($cell))
        {
            return trim($cell->getValue());
        }
        return $cell;
    }
}
