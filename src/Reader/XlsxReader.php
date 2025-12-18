<?php

namespace Alexain\SimpleSpreadsheetReader\Reader;

final class XlsxReader implements SpreadsheetReaderInterface
{
    public function __construct(
        private readonly int $sheetIndex = 0,
    ) {
    }

    public function supports(string $path): bool
    {
        return str_ends_with(strtolower($path), '.xlsx');
    }

    public function read(string $path): iterable
    {
        $reader = $this->createReader();
        $reader->open($path);

        try {
            $headers = null;
            $currentSheetIndex = 0;

            foreach ($reader->getSheetIterator() as $sheet) {
                if ($currentSheetIndex !== $this->sheetIndex) {
                    ++$currentSheetIndex;
                    continue;
                }

                foreach ($sheet->getRowIterator() as $row) {
                    $cells = $row->toArray();

                    // Skip empty rows
                    $isEmpty = true;
                    foreach ($cells as $v) {
                        if (null !== $v && '' !== trim((string) $v)) {
                            $isEmpty = false;
                            break;
                        }
                    }
                    if ($isEmpty) {
                        continue;
                    }

                    if (null === $headers) {
                        $headers = array_map(
                            static fn ($h) => trim((string) ($h ?? '')),
                            $cells
                        );
                        continue;
                    }

                    $headerCount = count($headers);
                    $cellCount = count($cells);

                    if ($cellCount < $headerCount) {
                        $cells = array_pad($cells, $headerCount, null);
                    } elseif ($cellCount > $headerCount) {
                        $cells = array_slice($cells, 0, $headerCount);
                    }

                    $assoc = array_combine($headers, $cells);
                    if (false !== $assoc) {
                        yield $assoc;
                    }
                }

                break;
            }
        } finally {
            $reader->close();
        }
    }

    private function createReader(): object
    {
        if (class_exists(\OpenSpout\Reader\XLSX\Reader::class)) {
            return new \OpenSpout\Reader\XLSX\Reader();
        }

        if (class_exists(\Box\Spout\Reader\XLSX\Reader::class)) {
            return new \Box\Spout\Reader\XLSX\Reader();
        }

        throw new \RuntimeException('No XLSX reader class found. Please install openspout/openspout.');
    }
}
