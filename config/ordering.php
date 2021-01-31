<?php

return [
    /**
     * 店舗情報.
     */
    'shop'          => [
        'description'          => env('ORDERING_DESCRIPTION'),
        'disabled_pay_message' => env('ORDERING_DISABLED_PAYMENT_MESSAGE',
            'セルフオーダーでの支払いはありません。支払いは伝票を持ってレジまでお越しください。'),
        'order_message'        => env('ORDERING_ORDER_MESSAGE', '注文が完了しました。しばらくお待ち下さい。'),
    ],

    /**
     * メニューデータ.
     */
    'menu'          => [
        /**
         * "array", "micro-cms".
         */
        'driver'    => env('ORDERING_MENU_DRIVER', 'array'),

        //メニューの画像が設定されてない時の画像。
        'no_image'  => env('ORDERING_NO_IMAGE', '/images/food_menu.png'),

        //microCMS
        'micro-cms' => [
            'api_key'  => env('ORDERING_MICROCMS_API_KEY'),
            'endpoint' => env('ORDERING_MICROCMS_ENDPOINT', 'https://sample.microcms.io/api/v1/menus'),
            'limit'    => env('ORDERING_MICROCMS_LIMIT', 1000),
            'orders'   => env('ORDERING_MICROCMS_ORDERS'),
        ],
    ],

    /**
     * 決済機能.
     */
    'payment'       => [
        'enabled' => env('ORDERING_PAYMENT_ENABLED', false),
    ],

    /**
     * リダイレクト.
     */
    'redirect'      => [
        'from_menus'   => env('ORDERING_REDIRECT_FROM_MENUS', 'prepare'),
        'from_prepare' => env('ORDERING_REDIRECT_FROM_PREPARE', 'history'),
        'from_payment' => env('ORDERING_REDIRECT_FROM_PAYMENT', 'prepare'),
    ],

    /**
     * テイクアウトを使用.
     */
    'takeout'       => env('ORDERING_TAKEOUT', true),

    /**
     * ルーティングを登録.
     */
    'routes'        => env('ORDERING_ROUTES', true),

    /**
     * ミドルウェア.
     */
    'middleware'    => env('ORDERING_MIDDLEWARE', 'web'),

    /**
     * ルーティングのドメイン.
     */
    'domain'        => env('ORDERING_DOMAIN'),

    /**
     * ルーティングのprefix.
     *
     * "ordering"
     */
    'prefix'        => env('ORDERING_PREFIX'),

    /**
     * ログインクッキー.
     */
    'cookie'        => env('ORDERING_LOGIN_COOKIE', 'ordering-login'),

    /**
     * 注文履歴の保存数上限.
     */
    'history_limit' => env('ORDERING_HISTORY_LIMIT', 10),

    /**
     * 管理画面.
     */
    'admin'         => [
        'password' => env('ORDERING_ADMIN_PASSWORD'),
    ],
];
