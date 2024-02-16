<?php
/**
 * PopulateCreatedAtColumn
 *
 * @copyright Copyright © 2024 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\SaveQuote\Setup\Patch\Data;


use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Quote\Api\Data\CartInterface;

class PopulateCreatedAtColumn implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();

        $select = $connection->select();
        $select->joinLeft(
            ['q' => $connection->getTableName("quote")],
            'qd.quote_id = q.entity_id',
            [ CartInterface::KEY_CREATED_AT => 'q.' . CartInterface::KEY_CREATED_AT]
        );

        $query = $connection->updateFromSelect(
            $select,
            ['qd' => $connection->getTableName('quote_description')],
        );

        $connection->query($query);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
