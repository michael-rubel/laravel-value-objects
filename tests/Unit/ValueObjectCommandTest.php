<?php

use Illuminate\Support\Facades\File;

test('can make value object using command', function () {
    $this->artisan('make:value-object', [
        'name' => 'TestValueObject',
    ]);

    $pathToGeneratedFile = app_path('ValueObjects' . DIRECTORY_SEPARATOR . 'TestValueObject.php');
    $this->assertFileExists($pathToGeneratedFile);
    $fileString = File::get($pathToGeneratedFile);

    $this->assertStringContainsString('declare(strict_types=1);', $fileString);
    $this->assertStringContainsString('use MichaelRubel\ValueObjects\ValueObject;', $fileString);
    $this->assertStringContainsString('@method static static make(mixed ...$values)', $fileString);
    $this->assertStringContainsString('class TestValueObject extends ValueObject', $fileString);
    $this->assertStringContainsString('public function value(): string', $fileString);
    $this->assertStringContainsString('public function toArray(): array', $fileString);
    $this->assertStringContainsString('public function __toString(): string', $fileString);
    $this->assertStringContainsString('Value of TestValueObject cannot be empty.', $fileString);
});
