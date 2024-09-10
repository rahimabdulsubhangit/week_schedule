<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    // Path to the static Excel file
    private $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/excel-files/my-file.xlsx');
    }

    // Method to read data from the Excel file
    public function readExcel()
    {
        // Load the Excel file
        $spreadsheet = IOFactory::load($this->filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Get all data as an array
        $data = $worksheet->toArray();

        // Return data as JSON
        return response()->json($data);
    }

    // Method to write data to the Excel file
    public function writeExcel(Request $request)
    {
        // Validate request
        $request->validate([
            'column' => 'required|string',
            'value' => 'required|string',
        ]);

        $column = $request->input('column');
        $value = $request->input('value');

        // Load the existing Excel file
        $spreadsheet = IOFactory::load($this->filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Update the column with the new value
        foreach ($worksheet->getRowIterator() as $row) {
            $cell = $worksheet->getCell($column . $row->getRowIndex());
            $cell->setValue($value);
        }

        // Save the updated Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save($this->filePath);

        return response()->json(['message' => 'Excel file updated successfully.']);
    }
}
