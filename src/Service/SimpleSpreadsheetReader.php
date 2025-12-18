<?php

namespace Alexain\SimpleSpreadsheetReader\Service;

use Alexain\SimpleSpreadsheetReader\Reader\Exception\UnsupportedFormatException;
use Alexain\SimpleSpreadsheetReader\Reader\SpreadsheetReaderInterface;

final class SimpleSpreadsheetReader
{
    /**
     * @param iterable<SpreadsheetReaderInterface> $readers
     */
    public function __construct(
        private readonly iterable $readers
    ) {
    }

    /**
     * @return iterable<array<string, mixed>>
     */
    public function read(string $path): iterable
    {
        foreach ($this->readers as $reader) {
            if ($reader->supports($path)) {
                return $reader->read($path);
            }
        }

        throw new UnsupportedFormatException(sprintf('Unsupported file format for "%s".', $path));
    }
}
