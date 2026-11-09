<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromQuery, WithEvents, WithHeadings, WithMapping, WithStyles
{
    protected Request $request;

    private int $rowNumber = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * =========================================================
     * QUERY UTAMA
     * =========================================================
     */
    public function query()
    {
        return $this->filteredQuery()
            ->orderBy(
                $this->getSortColumn(),
                $this->getSortDirection()
            );
    }

    /**
     * =========================================================
     * QUERY DENGAN FILTER
     * Dipakai bersama untuk detail dan rekap
     * =========================================================
     */
    private function filteredQuery()
    {
        $request = $this->request;

        return Sale::with([
            'outlet',
            'user',
        ])

            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('no_tabung', 'like', "%{$search}%")
                        ->orWhere('seri_tabung', 'like', "%{$search}%")
                        ->orWhere('item', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhere('bulan', 'like', "%{$search}%")

                        ->orWhereHas('outlet', function ($outlet) use ($search) {

                            $outlet->where(
                                'nama_outlet',
                                'like',
                                "%{$search}%"
                            )
                                ->orWhere(
                                    'nama_area',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'nama_spv',
                                    'like',
                                    "%{$search}%"
                                );
                        });
                });
            })

            ->when($request->filled('bulan'), function ($query) use ($request) {

                $query->where(
                    'bulan',
                    $request->bulan
                );
            })

            ->when($request->filled('outlet_id'), function ($query) use ($request) {

                $query->where(
                    'outlet_id',
                    $request->outlet_id
                );
            })

            ->when($request->filled('date_in'), function ($query) use ($request) {

                $query->whereDate(
                    'date_in',
                    $request->date_in
                );
            })

            ->when($request->filled('item'), function ($query) use ($request) {

                $query->where(
                    'item',
                    $request->item
                );
            })

            ->when($request->filled('keterangan'), function ($query) use ($request) {

                $query->where(
                    'keterangan',
                    $request->keterangan
                );
            })

            ->when(
                $request->filled('date_in_start'),
                function ($query) use ($request) {

                    $query->whereDate(
                        'date_in',
                        '>=',
                        $request->date_in_start
                    );
                }
            )

            ->when(
                $request->filled('date_in_end'),
                function ($query) use ($request) {

                    $query->whereDate(
                        'date_in',
                        '<=',
                        $request->date_in_end
                    );
                }
            );
    }

    /**
     * =========================================================
     * SORTING
     * =========================================================
     */
    private function getSortColumn()
    {
        $allowed = [
            'id',
            'bulan',
            'date_in',
            'item',
            'tekanan',
            'no_tabung',
            'seri_tabung',
            'date_end',
            'sales_tabung',
            'keterangan',
            'outlet_id',
        ];

        return in_array(
            $this->request->sort,
            $allowed
        )
            ? $this->request->sort
            : 'date_in';
    }

    private function getSortDirection()
    {
        return $this->request->direction === 'asc'
            ? 'asc'
            : 'desc';
    }

    /**
     * =========================================================
     * HEADINGS DETAIL
     * =========================================================
     */
    public function headings(): array
    {
        return [
            'No',
            'Bulan',
            'Date IN',
            'Item',
            'Tekanan (PSI)',
            'No Tabung',
            'Seri Tabung',
            'Date END',
            'Sales Tabung (Rp)',
            'Keterangan',
            'Outlet',
            'SPV',
            'Area',
            'Distributor',
            'Inflator',
            'Regulator',
            'Input Oleh',
            'Catatan',
            'Nama Operator',
        ];
    }

    /**
     * =========================================================
     * MAPPING DETAIL
     * =========================================================
     */
    public function map($sale): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,

            $sale->bulan,

            $sale->date_in
                ? $sale->date_in->format('d/m/Y')
                : '-',

            $sale->item,

            $sale->tekanan,

            $sale->no_tabung,

            $sale->seri_tabung ?? '-',

            $sale->date_end
                ? $sale->date_end->format('d/m/Y')
                : '-',

            $sale->sales_tabung,

            $sale->keterangan,

            $sale->outlet->nama_outlet ?? '-',

            $sale->outlet->nama_spv ?? '-',

            $sale->outlet->nama_area ?? '-',

            $sale->outlet->distribusi_by ?? '-',

            $sale->outlet->merk_inflator ?? '-',

            $sale->outlet->merk_regulator ?? '-',

            $sale->user->name ?? '-',

            $sale->catatan ?? '-',

            $sale->nama_operator ?? '-',
        ];
    }

    /**
     * =========================================================
     * STYLES
     * =========================================================
     */
    public function styles(Worksheet $sheet)
    {
        return [];
    }

    /**
     * =========================================================
     * EVENTS
     * =========================================================
     */
    public function registerEvents(): array
    {
        return [AfterSheet::class => function (AfterSheet $event) {
            $detail = $event->sheet->getDelegate();
            $detail->setTitle('Detail Sales');
            $detail->insertNewRowBefore(1, 4);
            $lastRow = max(5, $detail->getHighestDataRow());
            $this->formatSheet($detail, 'S', $lastRow, 'DETAIL DATA SALES', [
                7, 16, 15, 18, 16, 20, 22, 15, 23, 24, 32, 24, 24, 26, 24, 24, 26, 40, 28,
            ]);
            if ($lastRow > 5) {
                $detail->getStyle("E6:E{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.###');
                $detail->getStyle("I6:I{$lastRow}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
            } else {
                $detail->mergeCells('A6:S6')->setCellValue('A6', 'Tidak ada data sales sesuai filter yang dipilih.');
                $detail->getRowDimension(6)->setRowHeight(30);
            }
            $detail->freezePane('D6');

            // Separate sheets keep summary widths independent from the 19 detail columns.
            $summary = $detail->getParent()->createSheet(0);
            $summary->setTitle('Rekap Sales');
            $summary->fromArray([
                'Bulan', 'Outlet', 'Total Tekanan (PSI)', 'Total Qty Tabung',
                'Total Sales (Rp)', 'Avg Sales / Tabung (Rp)',
            ], null, 'A5');
            $rows = $this->getSummaryData();
            $row = 6;
            foreach ($rows as $item) {
                $summary->fromArray(array_values($item), null, "A{$row}", true);
                $row++;
            }
            $lastSummary = max(5, $row - 1);
            $this->formatSheet($summary, 'F', $lastSummary, 'REKAP DATA SALES', [
                18, 38, 25, 23, 28, 30,
            ]);
            if ($rows) {
                $summary->getStyle("C6:C{$lastSummary}")->getNumberFormat()->setFormatCode('#,##0.###');
                $summary->getStyle("D6:D{$lastSummary}")->getNumberFormat()->setFormatCode('#,##0');
                $summary->getStyle("E6:F{$lastSummary}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
                $totalRow = $row + 1;
                $summary->mergeCells("A{$totalRow}:B{$totalRow}");
                $summary->setCellValue("A{$totalRow}", 'TOTAL');
                foreach (['C', 'D', 'E'] as $column) {
                    $summary->setCellValue("{$column}{$totalRow}", "=SUM({$column}6:{$column}{$lastSummary})");
                }
                $summary->setCellValue("F{$totalRow}", "=IFERROR(E{$totalRow}/D{$totalRow},0)");
                $summary->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray($this->headerStyle());
                $summary->getStyle("C{$totalRow}")->getNumberFormat()->setFormatCode('#,##0.###');
                $summary->getStyle("E{$totalRow}:F{$totalRow}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
                $summary->getRowDimension($totalRow)->setRowHeight(30);
            } else {
                $summary->mergeCells('A6:F6')->setCellValue('A6', 'Tidak ada data sales sesuai filter yang dipilih.');
                $summary->getRowDimension(6)->setRowHeight(30);
            }
            $summary->getPageSetup()->setPrintArea('A1:F'.($rows ? $row + 1 : 6));
            $detail->getParent()->setActiveSheetIndex(0);
        }];
    }

    private function headerStyle(): array
    {
        return [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '024E7F']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
    }

    private function formatSheet(Worksheet $sheet, string $endColumn, int $lastRow, string $title, array $widths): void
    {
        $sheet->setShowGridlines(false);
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);
        $sheet->mergeCells("A1:{$endColumn}2")->setCellValue('A1', 'GoTube | '.$title);
        $sheet->getStyle("A1:{$endColumn}2")->applyFromArray($this->headerStyle());
        $sheet->getStyle('A1')->getFont()->setSize(18);
        $sheet->getRowDimension(1)->setRowHeight(24);
        $sheet->getRowDimension(2)->setRowHeight(18);
        $sheet->mergeCells("A3:{$endColumn}3")->setCellValue('A3', 'Monitoring sales tabung • Data mengikuti filter yang dipilih');
        $sheet->getStyle("A3:{$endColumn}3")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('64748B'));
        $sheet->getRowDimension(3)->setRowHeight(24);
        $sheet->getStyle("A5:{$endColumn}5")->applyFromArray($this->headerStyle());
        $sheet->getRowDimension(5)->setRowHeight(36);
        foreach ($widths as $index => $width) {
            $sheet->getColumnDimension(chr(65 + $index))->setAutoSize(false)->setWidth($width);
        }
        for ($row = 6; $row <= $lastRow; $row++) {
            $range = "A{$row}:{$endColumn}{$row}";
            $sheet->getStyle($range)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $row % 2 ? 'F0F7FC' : 'FFFFFF']],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'borders' => ['bottom' => ['borderStyle' => Border::BORDER_HAIR, 'color' => ['rgb' => 'D9E2E8']]],
            ]);
            // Estimate wrapped lines so long outlet names and notes remain visible.
            $lines = 1;
            foreach ($widths as $index => $width) {
                $value = (string) $sheet->getCell(chr(65 + $index).$row)->getValue();
                $cellLines = 0;
                foreach (explode("\n", $value) as $line) {
                    $cellLines += max(1, (int) ceil(mb_strlen($line) / max(1, $width - 3)));
                }
                $lines = max($lines, $cellLines);
            }
            $sheet->getRowDimension($row)->setRowHeight(max(30, $lines * 16 + 10));
        }
        $sheet->setAutoFilter("A5:{$endColumn}{$lastRow}");
        $sheet->freezePane('C6');
        $sheet->getSheetView()->setZoomScale($endColumn === 'S' ? 80 : 90);
        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3)
            ->setFitToWidth(1)->setFitToHeight(0)
            ->setRowsToRepeatAtTopByStartAndEnd(1, 5)
            ->setPrintArea("A1:{$endColumn}".max(6, $lastRow));
        $sheet->getHeaderFooter()->setOddFooter('&LGoTube | Sales&RHalaman &P / &N');
    }

    private function getSummaryData()
    {
        $sales = $this->filteredQuery()
            ->with('outlet')
            ->get();

        return $sales
            ->groupBy(function ($sale) {

                return
                    $sale->bulan.
                    '|'.
                    ($sale->outlet->nama_outlet ?? '-');
            })

            ->map(function ($group) {

                $first = $group->first();

                $totalTekanan = $group->sum(function ($sale) {

                    return (float) ($sale->tekanan ?? 0);
                });

                $totalQty = $group->count();

                $totalSales = $group->sum(function ($sale) {

                    return (float) ($sale->sales_tabung ?? 0);
                });

                $avgSales = $totalQty > 0
                    ? $totalSales / $totalQty
                    : 0;

                return [

                    'bulan' => $first->bulan ?? '-',

                    'outlet' => $first->outlet->nama_outlet ?? '-',

                    'total_tekanan' => $totalTekanan,

                    'total_qty' => $totalQty,

                    'total_sales' => $totalSales,

                    'avg_sales' => $avgSales,
                ];
            })

            ->sortBy([
                ['bulan', 'asc'],
                ['outlet', 'asc'],
            ])

            ->values()
            ->toArray();
    }
}
