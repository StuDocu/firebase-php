<?php

declare(strict_types=1);

namespace Kreait\Firebase\AppCheck;

/**
 * @phpstan-import-type DecodedAppCheckTokenShape from DecodedAppCheckToken
 *
 * @phpstan-type VerifyAppCheckTokenResponseShape array{
 *     appId: non-empty-string,
 *     token: DecodedAppCheckTokenShape,
 *     alreadyConsumed?: boolean
 * }
 */
final class VerifyAppCheckTokenResponse
{
    /**
     * @param non-empty-string $appId
     * @param DecodedAppCheckToken $token
     * @param boolean $alreadyConsumed
     */
    public function __construct(
        public readonly string $appId,
        public readonly DecodedAppCheckToken $token,
        public readonly ?bool $alreadyConsumed = null,
    ) {
    }
}
