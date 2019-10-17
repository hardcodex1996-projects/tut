<?php


// application/controllers/admin/IndexController.class.php


class TestController extends BaseController
{

    public function indexAction()
    {
        $pricing_data = array(
            'platforms_available' => [
                'coinbase','binance'
            ],
            'symbol_list' => [
                [
                'id' => 1995,
                'name' => 'BTCUSD',
                'platforms' => [
                    'coinbase' => [
                        'available_liquidity' => 10000,
                        'step' => 10,
                        'max' => 100,
                    ],
                    'binance' => [
                        'available_liquidity' => 20000,
                        'step' => 20,
                        'max' => 200,
                    ]
                ]
            ],
            [
                'id' => 1996,
                'name' => 'ETHUSD',

                'platforms' => [
                    'coinbase' => [
                        'available_liquidity' => 10000,
                        'step' => 10,
                        'max' => 100,
                    ],
                    'binance' => [
                        'available_liquidity' => 20000,
                        'step' => 20,
                        'max' => 200,
                    ]
                ]
            ],
                [
                    'id' => 1997,
                    'name' => 'EURUSD',

                    'platforms' => [
                        'coinbase' => [
                            'available_liquidity' => 10000,
                            'step' => 10,
                            'max' => 100,
                        ],
//                        'binance' => [
//                            'available_liquidity' => 20000,
//                            'step' => 20,
//                            'max' => 200,
//                        ]
                    ]
                ]
            ]
        );
        // Load View template
        include CURR_VIEW_PATH . "test.php";
    }
}
