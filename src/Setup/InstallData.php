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

namespace ScandiPWA\ContactGraphQl\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\Store;

class InstallData implements  InstallDataInterface
{
    private $blockFactory;

    public function __construct(BlockFactory $blockFactory)
    {
        $this->blockFactory = $blockFactory;
    }

    public function  install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $identifier = 'contact_us_page_block';
        $content = $this->getBlockContent();
        $block = [
            'title' => 'Contact Us Page Block',
            'identifier' => $identifier,
            'content' => $content,
            'is_active' => 1,
            'stores' => [Store::DISTRO_STORE_ID]
        ];

        $setup->startSetup();

        $this->blockFactory->create()->setData($block)->save();

        $resourceConfig = ObjectManager::getInstance()->get(Config::class);
        $resourceConfig->saveConfig('content_customization/contact_us_content/contact_us_cms_block', $identifier);

        $setup->endSetup();
    }

    private function getBlockContent() {
        return '<div class="contact-info cms-content"><p class="cms-content-important">We love hearing from you, our Luma customers. Please contact us about anything at all. Your latest passion, unique health experience or request for a specific product. We’ll do everything we can to make your Luma experience unforgettable every time. Reach us however you like</p><div class="block block-contact-info"><div class="block-title"><strong>Contact Us Info</strong></div><div class="block-content"><div class="box box-phone"><strong class="box-title"> Phone </strong><div class="box-content"><span class="contact-info-number">1-800-403-8838</span><p>Call the Luma Helpline for concerns, product questions, or anything else. We’re here for you 24 hours a day - 365 days a year.</p></div></div><div class="box box-design-inquiries"><strong class="box-title"> Apparel Design Inquiries </strong><div class="box-content"><p>Are you an independent clothing designer? Feature your products on the Luma website! Please direct all inquiries via email to: <a href="mailto:cs@luma.com" data-mce-href="mailto:cs@luma.com">cs@luma.com</a></p></div></div><div class="box box-press-inquiries"><strong class="box-title"> Press Inquiries </strong><div class="box-content"><p>Please direct all media inquiries via email to: <a href="mailto:pr@luma.com" data-mce-href="mailto:pr@luma.com">pr@luma.com</a></p></div></div></div></div></div>';
    }
}
