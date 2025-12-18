<?php

declare(strict_types=1);

namespace Alexain\SimpleSpreadsheetReader\Tests\Reader;

use Alexain\SimpleSpreadsheetReader\Reader\XlsxReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PHPUnit\Framework\TestCase;

final class XlsxReaderTest extends TestCase
{
    public function testItReadsXlsxWithHeader(): void
    {
        $path = $this->createTempXlsx([
            ['email', 'name', 'age'],
            ['john@example.com', 'John', 30],
            ['jane@example.com', 'Jane', 25],
        ]);

        $reader = new XlsxReader(sheetIndex: 0);
        $rows = array_values(iterator_to_array($reader->read($path)));

        self::assertCount(2, $rows);

        self::assertSame(
            ['email' => 'john@example.com', 'name' => 'John', 'age' => 30],
            $rows[0]
        );

        self::assertSame(
            ['email' => 'jane@example.com', 'name' => 'Jane', 'age' => 25],
            $rows[1]
        );
    }

    /**
     * @param array<int, array<int, mixed>> $rows
     */
    private function createTempXlsx(array $rows): string
    {
        $path = sys_get_temp_dir().'/ssr_'.bin2hex(random_bytes(8)).'.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $r = 1;
        foreach ($rows as $row) {
            $c = 1;
            foreach ($row as $value) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($c);
                $sheet->setCellValue($col.$r, $value);
                ++$c;
            }
            ++$r;
        }

        $writer = new XlsxWriter($spreadsheet);
        $writer->save($path);

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return $path;
    }
}
