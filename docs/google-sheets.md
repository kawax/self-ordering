# メニューデータをGoogleスプレッドシートで管理

若干難しいので慣れてる人向け。

## インストール
Laravelプロジェクト側で追加インストール。
```
composer require google/apiclient
```

Vercelで動かすなら composer.jsonの`scripts`で`cleanup`も必須。

```json
    "scripts": {
        "vercel": [
            "@php artisan config:cache",
            "@php artisan route:cache",
            "@php artisan view:cache",
            "Google\\Task\\Composer::cleanup"
        ],
    }
```

`extra`でSheetsのみを指定。
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

## 手順
API ConsoleでAPIを使えるように新しいプロジェクトを作る。  
https://console.developers.google.com/

APIは`Google Sheets API`

認証情報は`APIキー`を作成。APIキーなのでスプレッドシートは公開状態にする必要がある。閲覧のみ。  
サービスアカウントで使うには要カスタマイズ。

### スプレッドシートを作る
1行目に`id | name | text | category | price | image | sold_out_until`  
サンプルを参考。  
https://docs.google.com/spreadsheets/d/1EXZTgRJKROjHVYNPztOER7mLvl0Tppnm95RrASutg20/edit?usp=sharing

スプレッドシートではidの重複に注意。

「共有」から「リンクを取得」→「リンクを知っている全員」「閲覧者」→完了。

画像は外部のURL。

### .env
必要な項目はAPIキー、スプレッドシートID、シート名。

スプレッドシートIDはURLの{SPREADSHEETS}部分。  
https://docs.google.com/spreadsheets/d/{SPREADSHEETS}/edit

シート名のデフォルトはSheet 1。menusなどに変えてもいい。

```
ORDERING_MENU_DRIVER=google-sheets
ORDERING_GOOGLE_API_KEY=
ORDERING_GOOGLE_SPREADSHEETS=1EXZTgRJKROjHVYNPztOER7mLvl0Tppnm95RrASutg20
ORDERING_GOOGLE_MENUS_SHEET="menus"
```
