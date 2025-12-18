<?php

namespace Alexain\SimpleSpreadsheetReader\Reader;

interface SpreadsheetReaderInterface
{
    public function supports(string $path): bool;

    /**
     * @return iterable<array<string, mixed>>
     */
    public function read(string $path): iterable;
}
