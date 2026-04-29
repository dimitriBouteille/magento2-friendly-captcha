<?php

namespace IMI\FriendlyCaptcha\Model\Graphql;

use IMI\FriendlyCaptcha\Model\Exception\CaptchaValidationFailedGraphqlException;
use IMI\FriendlyCaptcha\Model\IsCheckRequiredInterface;
use Magento\Framework\App\Request\Http;
use IMI\FriendlyCaptcha\Api\ValidateInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use IMI\FriendlyCaptcha\Helper\Config\GraphQl;

class GraphQlValidator
{
    public function __construct(
        protected IsCheckRequiredInterface $isCheckRequired,
        protected Http $request,
        protected GraphQl $graphQlConfig,
        protected DataHelper $helper,
        protected ValidateInterface $validator,
        protected CustomerSession $customerSession
    ) {
    }

    public function validate(Field $field): bool
    {
        if (!$this->isCheckRequired->execute()) {
            return true;
        }

        $operations = array_merge(
            $this->graphQlConfig->getMutationsToSecure(),
            $this->graphQlConfig->getQueriesToSecure()
        );

        $name = (string) $field->getName();
        if (!in_array($name, $operations, true)) {
            return true;
        }

        $captcha = '';
        if ($this->validator->validate($captcha)) {
            return true;
        }

        throw new CaptchaValidationFailedGraphqlException();
    }
}