<?php

namespace Alexain\SimpleSpreadsheetReader\Tests\Service;

use Alexain\SimpleSpreadsheetReader\Reader\Exception\UnsupportedFormatException;
use Alexain\SimpleSpreadsheetReader\Reader\SpreadsheetReaderInterface;
use Alexain\SimpleSpreadsheetReader\Service\SimpleSpreadsheetReader;
use PHPUnit\Framework\TestCase;

final class SimpleSpreadsheetReaderTest extends TestCase
{
    public function testItDelegatesToSupportedReader(): void
    {
        $reader = new class implements SpreadsheetReaderInterface {
            public function supports(string $path): bool
            {
                return str_ends_with($path, '.csv');
            }

            public function read(string $path): iterable
            {
                yield ['ok' => true, 'path' => $path];
            }
        };

        $service = new SimpleSpreadsheetReader([$reader]);

        $rows = iterator_to_array($service->read('/tmp/file.csv'));

        self::assertSame([['ok' => true, 'path' => '/tmp/file.csv']], $rows);
    }

    public function testItThrowsWhenNoReaderSupportsFile(): void
    {
        $reader = new class implements SpreadsheetReaderInterface {
            public function supports(string $path): bool
            {
                return false;
            }

            public function read(string $path): iterable
            {
                yield ['never' => 'called'];
            }
        };

        $service = new SimpleSpreadsheetReader([$reader]);

        $this->expectException(UnsupportedFormatException::class);
        iterator_to_array($service->read('/tmp/file.unknown'));
    }
}
