<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

test('can make value object using command', function () {
    $this->artisan('make:value-object', ['name' => 'TestValueObject']);

    $this->assertFileExists(
        app_path('ValueObjects' . DIRECTORY_SEPARATOR . 'TestValueObject.php')
    );
});
