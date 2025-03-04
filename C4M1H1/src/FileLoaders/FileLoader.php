<?php

namespace C4M1H1\FileLoaders;

class FileLoader
{
    public function loadFile(FileType $type, string $path): array
    {
        return match ($type) {
            FileType::JSON => $this->loadJson($path),
            FileType::TXT => $this->loadText($path),
            default => [],
        };
    }

    private function loadJson(string $path): array
    {
        $patients = file_get_contents($path);

        return json_decode($patients, true);
    }

    private function loadText(string $path): array
    {
        $potentialDiseases = file_get_contents($path);

        $potentialDiseases = explode("\n", $potentialDiseases);

        // If last is empty, remove it
        if (empty($potentialDiseases[count($potentialDiseases) - 1])) {
            array_pop($potentialDiseases);
        }

        return $potentialDiseases;
    }

    public function saveFile(FileType $type, ?string $path, array $data): void
    {
        $formated = $this->formatDataByType($data, $type);
        file_put_contents($path, $formated);
    }

    public function formatDataByType(array $params, FileType $type): mixed
    {
        return match ($type) {
            FileType::JSON => json_encode($params, JSON_PRETTY_PRINT),
            FileType::CSV => $this->convertToCsv($params),
            default => null,
        };
    }

    private function convertToCsv(array $data): string
    {
        $filePath = 'php://temp'; // Use a temporary file
        $file = fopen($filePath, 'w+');

        // Write the header
        fputcsv($file, array_keys($data));

        // Write the data
        fputcsv($file, $data);

        // Rewind the file pointer
        rewind($file);

        // Get the CSV content
        $csvContent = stream_get_contents($file);

        // Close the file
        fclose($file);

        return $csvContent;
    }
}
