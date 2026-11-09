<?php

use App\Exports\SalesExport;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

beforeEach(function () {
    Schema::create('outlet', function (Blueprint $table) {
        $table->id();
        $table->string('nama_outlet');
    });
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->integer('outlet_id')->nullable();
        $table->integer('user_id')->nullable();
        foreach (['bulan', 'date_in', 'date_end', 'item', 'no_tabung', 'seri_tabung', 'keterangan', 'catatan', 'nama_operator'] as $name) {
            $table->string($name)->nullable();
        }
        $table->decimal('tekanan')->default(0);
        $table->decimal('sales_tabung')->default(0);
    });
});

afterEach(function () {
    Schema::dropIfExists('sales');
    Schema::dropIfExists('outlet');
});

function salesWorkbook(array $filters = [])
{
    $path = tempnam(sys_get_temp_dir(), 'sales-export-');
    file_put_contents($path, Excel::raw(new SalesExport(new Request($filters)), \Maatwebsite\Excel\Excel::XLSX));
    try {
        return IOFactory::load($path);
    } finally {
        unlink($path);
    }
}

it('exports matching summary and details with independent widths and numeric totals', function () {
    DB::table('outlet')->insert(['id' => 1, 'nama_outlet' => str_repeat('Outlet Bogor ', 6)]);
    foreach ([['Januari', 100000], ['Januari', 200000], ['Februari', 500000]] as [$bulan, $sales]) {
        DB::table('sales')->insert([
            'bulan' => $bulan, 'date_in' => '2026-01-02', 'outlet_id' => 1,
            'sales_tabung' => $sales, 'tekanan' => 100, 'no_tabung' => 'BG-01',
            'catatan' => str_repeat('Catatan panjang ', 30),
        ]);
    }
    $book = salesWorkbook(['bulan' => 'Januari']);
    expect($book->getSheetNames())->toBe(['Rekap Sales', 'Detail Sales']);
    $summary = $book->getSheet(0);
    $detail = $book->getSheet(1);
    expect($summary->getCell('D6')->getValue())->toBe(2)
        ->and($summary->getCell('E6')->getValue())->toEqual(300000)
        ->and($summary->getCell('F8')->getCalculatedValue())->toEqual(150000)
        ->and($detail->getCell('A5')->getValue())->toBe('No')
        ->and($detail->getCell('A6')->getValue())->toBe(1)
        ->and($detail->getCell('A7')->getValue())->toBe(2)
        ->and($detail->getHighestDataRow())->toBe(7)
        ->and($detail->getAutoFilter()->getRange())->toBe('A5:S7')
        ->and($detail->getFreezePane())->toBe('D6')
        ->and($detail->getColumnDimension('A')->getWidth())->toEqual(7)
        ->and($summary->getColumnDimension('A')->getWidth())->toEqual(18)
        ->and($detail->getRowDimension(6)->getRowHeight())->toBeGreaterThan(100)
        ->and($detail->getStyle('I6')->getNumberFormat()->getFormatCode())->toBe('"Rp" #,##0');
    expect(salesWorkbook(['bulan' => 'Januari'])->getSheet(1)->getCell('A6')->getValue())->toBe(1);
});

it('exports a usable empty workbook', function () {
    $book = salesWorkbook();
    foreach ($book->getWorksheetIterator() as $sheet) {
        expect($sheet->getCell('A6')->getValue())->toBe('Tidak ada data sales sesuai filter yang dipilih.')
            ->and($sheet->getAutoFilter()->getRange())->toStartWith('A5:')
            ->and($sheet->getFreezePane())->not->toBeNull();
    }
});
