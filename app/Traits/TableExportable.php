<?php
namespace App\Traits;
use App\Helpers\Helper;
use Mpdf\Mpdf;

trait TableExportable
{
    public const LOCATIONVIEW = '';
    public const ORIENTATIONL = 'L';
    public const ORIENTATIONP = 'P';
    public const GROUPVIEW = 'exports.locations-pdf';
    public const CATEGORYVIEW = 'exports.categories-pdf';
    public const ASSETVIEW = 'exports.assets-pdf';


    protected $exportKeys =['pdf', 'excel'];


    public function exportFile($key, $query, $view, $name='exported filed', $orientation = self::ORIENTATIONP)
    {
        if (!in_array($key,  $this->exportKeys)) {
            Helper::errorToast('Undefined Export type');
            return;
        }

        if ($key === 'pdf') {
            $data = $query->get();
            $mpdf = new Mpdf([
                'tempDir' => storage_path('app/mpdf'),
                'orientation' => $orientation,
            ]);


            $stylesheet = file_get_contents(public_path('assets/css/pdf.css'));
            $html = view($view, compact('data'))->render();

            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);


             return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output('', 'D');
            }, "{$name}.pdf");
        }

        if ($key === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\GroupsExport($this->getQuery()),
               "{$name}.xlsx"
            );
        }
    }
}
