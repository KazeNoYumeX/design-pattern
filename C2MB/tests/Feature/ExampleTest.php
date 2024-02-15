<?php

test('example', function () {
    expect(true)->toBeTrue();
});

it('can create a new game', function () {
    $folder = __DIR__;
    $parentDirectory = dirname($folder);
    $inputFile = $parentDirectory.'/Data/straight.in';

    $inputContent = file_get_contents($inputFile);

    $inputs = explode("\n", $inputContent);

    $output = shell_exec('php your_script.php test.in');

    $cards = array_shift($inputs);
    dump($cards);
    dd($inputs);
});
