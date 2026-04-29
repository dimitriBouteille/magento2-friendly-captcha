<?php
/**
 *  Copyright © iMi digital GmbH, based on work by MageSpecialist
 *  See LICENSE for license details.
 */
namespace IMI\FriendlyCaptcha\Helper\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class GraphQl
{
    final public const XML_PATH_CAPTCHA_GRAPHQL_ENABLED = 'imi_friendly_captcha/graphql/enabled';
    final public const XML_PATH_CAPTCHA_GRAPHQL_MUTATIONS = 'imi_friendly_captcha/graphql/mutations';
    final public const XML_PATH_CAPTCHA_GRAPHQL_QUERIES = 'imi_friendly_captcha/graphql/queries';

    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Whether the Friendly Captcha protection is enabled for GraphQL endpoints in the current store scope.
     */
    public function controlIsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CAPTCHA_GRAPHQL_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return the list of GraphQL mutation names that must be protected by the captcha.
     *
     * @return string[]
     */
    public function getMutationsToSecure(): array
    {
        return explode(
            ',',
            (string) $this->scopeConfig->getValue(
                self::XML_PATH_CAPTCHA_GRAPHQL_MUTATIONS,
                ScopeInterface::SCOPE_STORE
            )
        );
    }

    /**
     * Return the list of GraphQL query names that must be protected by the captcha.
     *
     * @return string[]
     */
    public function getQueriesToSecure(): array
    {
        return explode(
            ',',
            (string) $this->scopeConfig->getValue(
                self::XML_PATH_CAPTCHA_GRAPHQL_QUERIES,
                ScopeInterface::SCOPE_STORE
            )
        );
    }
}