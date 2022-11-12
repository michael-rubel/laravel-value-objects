<?php

use Illuminate\Support\Facades\File;
use MichaelRubel\ValueObjects\Artisan\ValueObjectMakeCommand;
use Symfony\Component\Console\Input\InputOption;

test('can make value object using command', function () {
    $pathToGeneratedFile = app_path('ValueObjects' . DIRECTORY_SEPARATOR . 'TestValueObject.php');

    File::delete($pathToGeneratedFile);

    $this->artisan('make:value-object', [
        'name' => 'TestValueObject',
    ]);

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

test('value object command option', function () {
    $option = app(ValueObjectMakeCommand::class)
        ->getNativeDefinition()
        ->getOption('value-object');

    $fakeOption = new InputOption('value-object', null, InputOption::VALUE_NONE, 'Create a value object');

    assertEquals($option, $fakeOption);
});
