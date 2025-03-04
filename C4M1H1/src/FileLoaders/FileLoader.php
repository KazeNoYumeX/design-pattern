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

    public function saveFile(FileType $JSON, ?string $patientsPath, array $patients)
    {
        $patients = json_encode($patients, JSON_PRETTY_PRINT);

        file_put_contents($patientsPath, $patients);
    }
}
