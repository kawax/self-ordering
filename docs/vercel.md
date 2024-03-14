# Vercelで動かす

https://vercel.com/

## 前提
README通りにインストールしたプロジェクトが前提。

すぐに動かせるプロジェクトテンプレートも。  
https://github.com/kawax/self-ordering-starter

## 必要なファイルは追加済
`php artisan ordering:install`でVercelで動かすためのファイルもインストールされている。

変更するとしたら`vercel.json`の`APP_NAME`。

## TrustProxiesの設定
Laravel10とLaravel11以降で設定方法が違うので手動で変更が必要。

### Laravel 10
`/app/Http/Middleware/TrustProxies.php`を変更。
```php
protected $proxies = '*';
```

### Laravel 11
`/bootstrap/app.php`を変更。
```php
->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies('*');
    })
```

## installコマンド以外での必須ではない変更箇所
composer.jsonの`scripts`。ここを参考に。  
https://github.com/kawax/self-ordering-starter/blob/master/composer.json

```
        "vercel": [
            "@php artisan config:cache",
            "@php artisan route:cache",
            "@php artisan view:cache",
            "@php artisan event:cache",
            "Google\\Task\\Composer::cleanup"
        ],
```

Googleスプレッドシートを使うなら必須。`cleanup`しないと容量オーバーでデプロイに失敗する。

`extra`部分も変更。
```json
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "google/apiclient-services": [
            "Sheets"
        ]
    },
```

## APIを使う
VercelでAPIを使う場合、`https://localhost/api/menus` では正常に動かないので`vercel.json`でprefixを設定する。

```json
    "env": {
        "ORDERING_PREFIX": "ordering"
    }
```

`https://localhost/ordering/api/menus` で正しく表示される。  
`ordering` 部分はなんでも良い。  
api以外のURLにも影響する。

## Vercelでの手順
Vercelの細かい部分は頻繁に変更されるので絶対にこの手順通りに進めようとしなくていい。

- https://vercel.com/dashboard から`New Project`
- GitHubのリポジトリを選択。
- Select Vercel Scopeは`PERSONAL ACCOUNT`を選択。
- Import Projectのdirectoryはそのまま次へ。
- Environment Variablesで追加が必要。
  - NAME `APP_KEY` 
  - VALUE https://laravel-app-key.vercel.app/ で生成されたキー`base64:***`をコピペ。
  - `ADD`で追加。
- `Deploy`でデプロイ。少し待つ。
- `Congratulations!`が表示されたら成功。
