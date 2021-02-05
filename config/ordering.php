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
         * "array", "micro-cms", "google-sheets".
         */
        'driver'        => env('ORDERING_MENU_DRIVER', 'array'),

        //メニューの画像が設定されてない時の画像。
        'no_image'      => env('ORDERING_NO_IMAGE', '/images/food_menu.png'),

        //microCMS
        'micro-cms'     => [
            'api_key'  => env('ORDERING_MICROCMS_API_KEY'),
            'endpoint' => env('ORDERING_MICROCMS_ENDPOINT', 'https://***.microcms.io/api/v1/menus'),
            'limit'    => env('ORDERING_MICROCMS_LIMIT', 1000),
            'orders'   => env('ORDERING_MICROCMS_ORDERS'),
            'image'    => env('ORDERING_MICROCMS_IMAGE', '?w=200'),
        ],

        // Google Sheets
        'google-sheets' => [
            // OAuthでもサービスアカウントでもなくAPIキーを設定する。
            // スプレッドシートは共有して公開状態にする。
            'api_key'      => env('ORDERING_GOOGLE_API_KEY'),

            // URLの{SPREADSHEETS}部分を指定
            // https://docs.google.com/spreadsheets/d/{SPREADSHEETS}/edit
            'spreadsheets' => env('ORDERING_GOOGLE_SPREADSHEETS'),

            // シート名。デフォルトではSheet 1なのでmenusなどに変更。
            'menus_sheet'  => env('ORDERING_GOOGLE_MENUS_SHEET', 'Sheet 1'),
        ],
    ],

    /**
     * 決済機能.
     */
    'payment'       => [
        // 決済機能の有効化
        'enabled' => env('ORDERING_PAYMENT_ENABLED', false),

        // 使用する支払い方法
        'methods' => [
            'cash'   => 'レジで後払い',
            'paypay' => 'PayPay',

            // 'custom-pay' => 'CustomPay'
        ],

        // PayPay
        'paypay'  => [
            // 本番モード
            'production'      => env('ORDERING_PAYPAY_PRODUCTION', false),
            'api_key'         => env('ORDERING_PAYPAY_API_KEY'),
            'api_secret'      => env('ORDERING_PAYPAY_API_SECRET'),
            'merchant_id'     => env('ORDERING_PAYPAY_MERCHANT_ID'),
            'currency'        => env('ORDERING_PAYPAY_CURRENCY', 'JPY'),
            'prepare_message' => env('ORDERING_PAYPAY_PREPARE_MESSAGE', '（支払いに進んだ後はブラウザの戻るは使用しないでください。）'),
        ],
    ],

    /**
     * リダイレクト.
     */
    'redirect'      => [
        'from_menus'   => env('ORDERING_REDIRECT_FROM_MENUS', 'prepare'),
        'from_payment' => env('ORDERING_REDIRECT_FROM_PAYMENT', 'history'),
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
