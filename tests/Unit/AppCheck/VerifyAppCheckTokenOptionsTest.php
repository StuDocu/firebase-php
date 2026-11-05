<?php

declare(strict_types=1);

namespace Kreait\Firebase\Tests\Unit\AppCheck;

use Iterator;
use Kreait\Firebase\AppCheck\VerifyAppCheckTokenOptions;
use Kreait\Firebase\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 */
final class VerifyAppCheckTokenOptionsTest extends UnitTestCase
{
    #[Test]
    public function consumeIsEnabledWhenRequested(): void
    {
        $options = VerifyAppCheckTokenOptions::fromArray(['consume' => true]);

        $this->assertTrue($options->consume);
    }

    /**
     * @param array{consume?: bool|null} $data
     */
    #[DataProvider('optionsWithoutConsumption')]
    #[Test]
    public function consumeIsNotSetWhenNotRequested(array $data): void
    {
        $options = VerifyAppCheckTokenOptions::fromArray($data);

        $this->assertNull($options->consume);
    }

    /**
     * @return Iterator<string, array{0: array{consume?: bool|null}}>
     */
    public static function optionsWithoutConsumption(): Iterator
    {
        yield 'omitted' => [[]];
        yield 'null' => [['consume' => null]];
        yield 'false' => [['consume' => false]];
    }
}
