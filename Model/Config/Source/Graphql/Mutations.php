<?php
/**
 *  Copyright © iMi digital GmbH, based on work by MageSpecialist
 *  See LICENSE for license details.
 */

namespace IMI\FriendlyCaptcha\Model\Config\Source\Graphql;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\GraphQlSchemaStitching\GraphQlReader;

class Mutations implements OptionSourceInterface
{
    public function __construct(
        protected GraphQlReader $graphQlReader
    ) {
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        $config = $this->graphQlReader->read();
        $entries = array_map(static fn ($item) => [
            'label' => $item,
            'value' => $item,
        ], array_keys($config['Mutation']['fields']));

        usort($entries, static function ($item1, $item2) {
            return $item1['label'] <=> $item2['label'];
        });

        return $entries;
    }
}
