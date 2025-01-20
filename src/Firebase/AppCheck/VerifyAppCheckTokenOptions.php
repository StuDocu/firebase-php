<?php

declare(strict_types=1);

namespace Kreait\Firebase\AppCheck;

/**
 * @phpstan-type VerifyAppCheckTokenOptionsShape array{
 *     consume: bool|null,
 * }
 */
final class VerifyAppCheckTokenOptions
{
    private function __construct(
        public readonly ?bool $consume = null,
    ) {
    }

    /**
     * @param VerifyAppCheckTokenOptionsShape $data
     *
     * @return VerifyAppCheckTokenOptions
     */
    public static function fromArray(array $data): self
    {
        $consume = $data['consume'] ?? null;

        return $consume ? new self($consume) : new self();
    }
}
