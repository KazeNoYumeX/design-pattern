<?php

namespace C4M1H1\Prescriptions;

class NRICM101 extends Prescription
{
    public function __construct()
    {
        parent::__construct('清冠一號',
            '新冠肺炎',
            'COVID-19',
            '清冠一號',
            '將相關藥材裝入茶包裡，使用500 mL 溫、熱水沖泡悶煮1~3 分鐘後即可飲用。');
    }
}
