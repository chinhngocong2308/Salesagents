<?php

namespace AHT\Salesagents\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Directory\Model\Currency;

class Commissiontype extends Column
{

    /**
     * @var Currency
     */
    private $currency;

    /**
     * Constructor
     *
     * @param Currency $currency
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        Currency $currency = null,
        array $data = []
    ) {
        $this->currency = $currency ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->create(Currency::class);
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        $currencyCode = isset($item['base_currency_code']) ? $item['base_currency_code'] : null;
        $basePurchaseCurrency = $this->currency->load($currencyCode);

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                if ($items['sa_commission_type'] == 1) {
                    $items['result_commission'] = $basePurchaseCurrency
                        ->format($items['sa_commission_value'], [], false);

                    $items['sa_commission_type'] = '<span class="grid-severity-notice"><span>' . 'Fixel' . '</span></span>';
                    $items['sa_commission_value'] = $basePurchaseCurrency
                        ->format($items['sa_commission_value'], [], false);
                }
                if ($items['sa_commission_type'] == 2) {
                    $items['result_commission']  =
                        $basePurchaseCurrency
                        ->format(($items['sa_commission_value'] * $items['product_price_final'] / 100), [], false);
                    $items['sa_commission_value'] = number_format(($items['sa_commission_value']), 2,".",",").'%';
                    $items['sa_commission_type'] = '<span class="grid-severity-minor"><span>' . 'Percent' . '</span></span>';
                }
            }
        }
        return $dataSource;
    }
}
