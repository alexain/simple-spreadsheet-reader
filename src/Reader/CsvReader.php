<?php

namespace Alexain\SimpleSpreadsheetReader\Reader;

final class CsvReader implements SpreadsheetReaderInterface
{
    public function supports(string $path): bool
    {
        return str_ends_with(strtolower($path), '.csv');
    }

    public function read(string $path): iterable
    {
        $file = new \SplFileObject($path);
        $file->setFlags(
            \SplFileObject::READ_CSV
            | \SplFileObject::SKIP_EMPTY
            | \SplFileObject::DROP_NEW_LINE
        );

        $headers = null;

        foreach ($file as $row) {
            if ($row === [null] || false === $row) {
                continue;
            }

            if (null === $headers) {
                $headers = $row;
                continue;
            }

            yield array_combine($headers, $row);
        }
    }
}
