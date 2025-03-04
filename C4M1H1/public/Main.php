<?php

declare(strict_types=1);

use C4M1H1\FileLoaders\FileType;
use C4M1H1\PatientCase;
use C4M1H1\PrescriberSystemFacade;
use C4M1H1\Prescriptions\NRICM101;

require_once dirname(__DIR__).'/vendor/autoload.php';

// Client
$facade = new PrescriberSystemFacade(dirname(__DIR__).'/data/patient.json',
    dirname(__DIR__).'/data/potential-disease.txt');
$data = $facade->diagnosis($id = 'A1234567890', ['headache'], FileType::JSON);

// Maintainer
$patient = $facade->selectPatientById($id);
$case = new PatientCase(date('Y-m-d H:i:s'), ['headache'], new NRICM101);
$facade->createPatientCase($id, $case);
