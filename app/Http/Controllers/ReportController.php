<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Type;

class ReportController extends Controller
{
    /**
     * Export on‑demand via Spout CSV writer.
     */
    public function export()
    {
        // 1) Siapkan direktori dan nama file
        $dir      = storage_path('exports');
        $filename = 'export_' . now()->format('Ymd_His') . '.csv';
        $filePath = $dir . DIRECTORY_SEPARATOR . $filename;

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // 2) Buat writer CSV
        $writer = WriterEntityFactory::createCSVWriter();
        $writer->openToFile($filePath);

        // 3) Tulis header
        $header = ['ID','Date','Region','Disease','Count'];
        $writer->addRow(WriterEntityFactory::createRowFromArray($header));

        // 4) Ambil data dan tulis per baris
        DB::table('case_records')
            ->select('case_records.id','case_records.date_reported','case_records.count','regions.name as region','diseases.name as disease')
            ->join('regions','regions.id','=','case_records.region_id')
            ->join('diseases','diseases.id','=','case_records.disease_id')
            ->orderBy('case_records.id')
            ->cursor()
            ->each(function($row) use ($writer) {
                $writer->addRow(
                    WriterEntityFactory::createRowFromArray([
                        $row->id,
                        \Carbon\Carbon::parse($row->date_reported)->format('Y-m-d'),
                        $row->region,
                        $row->disease,
                        $row->count,
                    ])
                );
            });

        $writer->close();

        // 5) Download
        return Response::download($filePath, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Tampilkan daftar scheduled reports
     */
    public function scheduled()
    {
        $reports = DB::table('scheduled_reports')->orderBy('id')->get();
        return view('reports.scheduled', compact('reports'));
    }

    /**
     * Unduh hasil scheduled report via Spout
     */
    public function download($id)
    {
        $rep = DB::table('scheduled_reports')->find($id);

        if (! $rep || ! $rep->file_path || ! File::exists($rep->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Asumsikan file CSV, langsung download
        return Response::download($rep->file_path, "{$rep->name}.csv", [
            'Content-Type' => 'text/csv',
        ]);
    }
}
