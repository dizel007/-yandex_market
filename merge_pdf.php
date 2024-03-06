<?php

require_once 'libs/PDFMerger/PDFMerger.php';
use PDF_Merger\PDFMerger;
$pdf = new PDFMerger;

foreach ( $arr_files_name as $pdf_file) {
    $pdf->addPDF("$pdf_file", '1');
}

 $pdf->merge('file', __DIR__."\\".$dir."_merge\\".$items['offerId']."(".$count_items." шт).pdf");