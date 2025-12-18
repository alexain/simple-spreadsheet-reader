<?php

namespace Alexain\SimpleSpreadsheetReader\Tests\DependencyInjection;

use Alexain\SimpleSpreadsheetReader\DependencyInjection\SimpleSpreadsheetReaderExtension;
use Alexain\SimpleSpreadsheetReader\Service\SimpleSpreadsheetReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SimpleSpreadsheetReaderExtensionTest extends TestCase
{
    public function test_it_registers_services_definitions(): void
    {
        $container = new ContainerBuilder();
        $extension = new SimpleSpreadsheetReaderExtension();

        $extension->load([], $container);

        self::assertTrue(
            $container->hasDefinition(SimpleSpreadsheetReader::class),
            'Expected SimpleSpreadsheetReader service definition to be registered.'
        );
    }
}
