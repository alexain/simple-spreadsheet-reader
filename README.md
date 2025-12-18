# Simple Spreadsheet Reader

**SimpleSpreadsheetReader** is a lightweight Symfony bundle that provides a unified and streaming-friendly API for reading tabular data from spreadsheet-like files such as **CSV** and **XLSX**.

The bundle is **read-only by design** and focuses on simplicity, performance, and low memory usage.  
It is built for **PHP 8.2+** and **Symfony 7.x / 8.x**, and is intended to standardize how Symfony applications consume spreadsheet data.

Its architecture is format-agnostic and intentionally extensible, allowing future support for additional formats such as **OpenDocument (ODS)**.

---

## Features

- Read-only spreadsheet parsing
- Supported formats:
    - CSV
    - XLSX
- Streaming-based reading (low memory footprint)
- Unified API across different formats
- Automatic format detection
- Header normalization and mapping
- Designed for large files
- Symfony-native services and configuration
- PHP 8.2+ compatible

---

## Installation

```console
composer require alexain/simple-spreadsheet-reader
```

If Symfony Flex is enabled, the bundle will be registered automatically.

---

[//]: # (## Basic Usage)

[//]: # ()
[//]: # (Inject the reader service into your application:)

[//]: # ()
[//]: # (```console)

[//]: # (use Alexain\SimpleSpreadsheetReaderBundle\Service\SimpleSpreadsheetReader;)

[//]: # ()
[//]: # (final class ImportService)

[//]: # ({)

[//]: # (    public function __construct&#40;)

[//]: # (        private SimpleSpreadsheetReader $reader)

[//]: # (    &#41; {})

[//]: # ()
[//]: # (    public function import&#40;string $path&#41;: void)

[//]: # (    {)

[//]: # (        foreach &#40;$this->reader->read&#40;$path&#41; as $row&#41; {)

[//]: # (            // $row is a normalized representation of a single record)

[//]: # (            // e.g. $row['email'], $row['created_at'], etc.)

[//]: # (        })

[//]: # (    })

[//]: # (})

[//]: # (```)

[//]: # ()
[//]: # (The reader automatically selects the appropriate implementation based on the file type.)

[//]: # (Configuration)

[//]: # ()
[//]: # (Basic configuration example:)

[//]: # ()
[//]: # (simple_spreadsheet_reader:)

[//]: # (  csv:)

[//]: # (    delimiter: ';')

[//]: # (    encoding: auto)

[//]: # (  xlsx:)

[//]: # (    sheet_index: 0)

[//]: # (  header:)

[//]: # (    normalize: true)

[//]: # ()
[//]: # (All configuration options are optional.)

---

## Roadmap

Planned features and extensions:

- OpenDocument (ODS) support 
- Custom row transformers
- Validation integration
- Import result reporting
- Strict vs lenient parsing modes

---

## License

This bundle is released under the MIT License.

---

## Contributing

Contributions are welcome.
Please open an issue or submit a pull request for improvements or bug fixes.