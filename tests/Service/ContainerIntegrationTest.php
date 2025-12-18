<?php


namespace Alexain\SimpleSpreadsheetReader\Tests\Service;

use Alexain\SimpleSpreadsheetReader\DependencyInjection\SimpleSpreadsheetReaderExtension;
use Alexain\SimpleSpreadsheetReader\Service\SimpleSpreadsheetReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ContainerIntegrationTest extends TestCase
{
    public function test_simple_spreadsheet_reader_receives_tagged_readers(): void
    {
        $container = new ContainerBuilder();

        $extension = new SimpleSpreadsheetReaderExtension();
        $extension->load([], $container);

        // Make the service public for this test container only
        if ($container->hasDefinition(SimpleSpreadsheetReader::class)) {
            $container->getDefinition(SimpleSpreadsheetReader::class)->setPublic(true);
        }

        $container->compile();

        self::assertTrue(
            $container->has(SimpleSpreadsheetReader::class),
            'SimpleSpreadsheetReader service should be registered.'
        );

        $service = $container->get(SimpleSpreadsheetReader::class);

        $path = __DIR__ . '/../Fixtures/simple.csv';
        $rows = iterator_to_array($service->read($path));

        self::assertCount(4, $rows);
        self::assertSame('john@example.com', $rows[0]['email']);
    }
}
