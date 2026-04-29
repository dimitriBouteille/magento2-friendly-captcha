<?php

namespace IMI\FriendlyCaptcha\Model\Exception;

use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;
use Magento\Framework\Exception\LocalizedException;

class CaptchaValidationFailedGraphqlException extends LocalizedException implements ClientAware, ProvidesExtensions
{
    final public const CODE = 'captcha-validation-failed-graphql';

    /**
     * @inheritDoc
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getExtensions(): ?array
    {
        return [
            'category' => self::CODE,
        ];
    }
}