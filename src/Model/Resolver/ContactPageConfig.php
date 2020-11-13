<?php
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/base-theme
 * @link https://github.com/scandipwa/base-theme
 */

namespace ScandiPWA\ContactGraphQl\Model\Resolver;

use Magento\Contact\Model\Config;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class ContactPageConfig implements ResolverInterface {
    /**
     * @var Config
     */
    private $mailConfig;

    /**
     * ContactFormConfig constructor.
     * @param Config $mailConfig
     */
    public function __construct(Config $mailConfig)
    {
        $this->mailConfig = $mailConfig;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null) {
        return [
            'enabled' => $this->mailConfig->isEnabled()
        ];
    }
}
