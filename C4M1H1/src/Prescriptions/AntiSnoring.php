<?php

namespace C4M1H1\Prescriptions;

class AntiSnoring extends Prescription
{
    public function __construct()
    {
        parent::__construct('打呼抑制劑',
            '睡眠呼吸中止症',
            'SleepApneaSyndrome',
            '一捲膠帶',
            '睡覺時，撕下兩塊膠帶，將兩塊膠帶交錯黏在關閉的嘴巴上，就不會打呼了。');
    }
}
