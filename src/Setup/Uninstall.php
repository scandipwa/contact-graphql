<?php

namespace ScandiPWA\ContactGraphQl\Setup;

use Magento\Cms\Model\BlockRepository;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements  UninstallInterface
{
    private $blockRepository;

    public function __construct(BlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->blockRepository->deleteById('contact_us_page_block');

        $resourceConfig = ObjectManager::getInstance()->get(Config::class);
        $resourceConfig->deleteConfig('content_customization/contact_us_content/contact_us_cms_block');

        $setup->endSetup();
    }
}
