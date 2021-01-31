# Self Ordering System

オープンソースのセルフオーダーシステム

## 目的
スマホで注文するセルフオーダーの普及。

## 概要
- 1店舗1システムで動かす。
- 店舗ごとにカスタマイズして使う前提。
- 商用利用可能。開発・設置・運用代行をビジネスにして良い。
- 決済やPOS連携機能は含めない。拡張はできるので必要なら個別に対応。
- Vercelを使えばサーバー費用を無料にできるのでデータベースなしでの運用も可能にする。
- バージョンアップしやすいようにLaravel用のcomposerパッケージとして作る。Laravelアプリとしては作らない。

## 動作環境
- PHP ^7.4
- Laravel 8.x
- Livewire 2.x

## バージョン
|ver|PHP|Laravel|
|---|---|-------|
|1.x|^7.4|8.x  |

## インストール
「Laravelでセルフオーダーシステムを作るためのスターターキット」なので必ずLaravelの新規プロジェクトを作るところから始めてください。`ordering:install`コマンドでファイルが上書きされます。

```
curl -s https://laravel.build/self-ordering-project | bash
cd ./self-ordering-project

composer require revolution/self-ordering

php artisan ordering:install

npm install && npm run dev

./vendor/bin/sail up -d
```

http://localhost/order

### .env
```
ORDERING_MENU_DRIVER=array
ORDERING_ADMIN_PASSWORD=
ORDERING_DESCRIPTION=""

ORDERING_MICROCMS_SERVICE=
ORDERING_MICROCMS_API_KEY=
ORDERING_MICROCMS_ENDPOINT=menus
```

### routes/web.php
`/`のルートは使わないのでリダイレクト。

```php
//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', 'order');
```

インストール後にページを増やすのは自由。

## 仕様
### ページ
- ユーザー向けの注文ページ
  - QRコードを読み込んで表示。
  - メニューを選択→注文確認画面（注文を送信）→注文履歴画面。
- 店舗向けのダッシュボード
  - デフォルトでは簡易的なパスワード認証。

### メニューデータ
- array（デフォルト）
- データベース
- Googleスプレッドシート
- microCMS

### 注文送信先
基本的にはLaravelの通知機能を使う。

- メール
- LINE Notify
- データベース

## 制限
- sessionをcookieドライバーで使うとクッキーの容量制限にひっかかる。注文履歴は一定数に制限。「一度に注文できる商品数」も制限したほうがいいかもしれない。cookieドライバーを使わなければ関係ない。

## LICENCE
MIT
