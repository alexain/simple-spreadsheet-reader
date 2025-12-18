<?php

namespace Alexain\SimpleSpreadsheetReader\Tests\Reader;

use Alexain\SimpleSpreadsheetReader\Reader\CsvReader;
use PHPUnit\Framework\TestCase;

final class CsvReaderTest extends TestCase
{
    public function test_it_reads_csv_with_header(): void
    {
        $reader = new CsvReader();

        $path = __DIR__ . '/../Fixtures/simple.csv';
        $rows = array_values(iterator_to_array($reader->read($path)));

        self::assertCount(4, $rows);

        self::assertSame(
            [
                'email' => 'john@example.com',
                'name'  => 'John',
                'age'   => '30',
            ],
            $rows[0]
        );

        self::assertSame(
            [
                'email' => 'jane@example.com',
                'name'  => 'Jane',
                'age'   => '25',
            ],
            $rows[1]
        );

        self::assertSame(
            [
                'email' => 'rob@example.com',
                'name'  => 'Rob',
                'age'   => '29',
            ],
            $rows[2]
        );

        self::assertSame(
            [
                'email' => 'alex@example.com',
                'name'  => 'Alex',
                'age'   => '50',
            ],
            $rows[3]
        );
    }
}
