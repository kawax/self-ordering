# カスタマイズ

## はじめに
Laravelのサービスコンテナを活用しているのでカスタマイズするにはサービスコンテナに慣れておく必要があります。

## メニューデータ
MenuManagerのドライバーを切り替えることでメニューデータの取得元を変更できる。

```
ORDERING_MENU_DRIVER=array
```

### Arrayドライバー
デフォルト。

メニュー情報を変更することがほとんどなくPHPのコードで管理できれば十分な場合はArrayドライバーでいい。外部へのAPIリクエストがないので最速。

使い方はLaravelプロジェクト内にclassを作る。  
`app/Odering/FooMenu.php`  
SampleMenuを参考に同じようにCollectionを返す。  
https://github.com/kawax/self-ordering/blob/develop/src/Menu/SampleMenu.php

`AppServiceProvider@register`でサービスコンテナに登録。MenuDataが呼び出された時に代わりにFooMenuが使われる。

```php

use App\Ordering\FooMenu;
use Revolution\Ordering\Contracts\Menu\MenuData;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MenuData::class, FooMenu::class);
    }
```

Collectionさえ返せばいいのでFooMenu内で外部からデータを取得してもいい。

### microCMSドライバー
メニュー情報を変更するなら管理画面が必要。  
管理画面を外部サービスに任せてシンプル化している。  
https://microcms.io/

```
ORDERING_MENU_DRIVER=micro-cms
ORDERING_MICROCMS_API_KEY=
ORDERING_MICROCMS_ENDPOINT=https://***.microcms.io/api/v1/menus
```

詳しくは[microcms.md](./microcms.md)

## イベント
注文送信後は`Revolution\Ordering\Events\OrderEntry`イベントが発生するのでLaravelプロジェクト側でリスナーを用意。

`ordering:install`で`App\Listeners\OrderEntryListener`が追加されている。  
注文情報をどこにどう送信するかは`OrderEntryListener`が担当することなのでプロジェクト側の責務。  
Laravelの通知機能などを使って作りましょう。

## Actions
ログインや注文などの`Action`はある程度個別のclassにしているのでサービスコンテナで変更できる。  
https://github.com/kawax/self-ordering/tree/develop/src/Actions

### 注文を変更
`app/Odering/Actions/OrderAction.php`を作る。

```php
<?php

namespace App\Ordering\Actions;

use Illuminate\Support\Arr;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Cart;

class OrderAction implements Order
{
    public function order()
    {
        //
    }
}
```

オリジナルを参考に変更。  
https://github.com/kawax/self-ordering/blob/develop/src/Actions/OrderAction.php

`AppServiceProvider@register`でサービスコンテナに登録。

```php

use App\Ordering\Actions\OrderAction;
use Revolution\Ordering\Contracts\Actions\Order;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Order::class, OrderAction::class);
    }
```

## 画面遷移
メニュー選択→（A）→注文確認→（B）→支払い→（C）→注文履歴。

A,B,Cでのリダイレクト先の設定方法。

- A : .envの`ORDERING_REDIRECT_FROM_MENUS`でルート名を指定。 https://github.com/kawax/self-ordering/blob/develop/src/Http/Livewire/Order/Menus.php
- B : 支払い方法ドライバーの担当。「レジで後払い」なら支払いがないので注文送信後そのままCへ進んで注文履歴にリダイレクト。
- C : .envの`ORDERING_REDIRECT_FROM_PAYMENT`でルート名を指定。 https://github.com/kawax/self-ordering/blob/develop/src/Payment/CashDriver.php

リダイレクト先を変更すれば画面遷移を自由に変更できる。

## ビューファイル
`php artisan vendor:publish --tag=ordering-views`で`resources/views/vendor/ordering/`以下にviewsファイルが公開されるので自由に変更可能。

`resources/views/vendor/ordering/`以下は一部のファイルのみ置いてもいい。  
`resources/views/vendor/ordering/dashboard.blade.php`だけ作って管理画面をカスタマイズするような使い方ができる。

## Livewire
`app/Odering/Livewire/Menus.php`などを作って`AppServiceProvider@register`で登録すればLivewireのclassごと変更可能。

```php
use Livewire\Livewire;
use App\Ordering\Livewire\Menus;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Livewire::component('ordering.menus', Menus::class);
        Livewire::component('ordering.prepare', Prepare::class);
        Livewire::component('ordering.history', History::class);
    }
```

## カラーの変更
`tailwind.config.js`のcolors部分を変更すれば基本カラーの変更が可能。

```js
        colors: {
            ...defaultTheme.colors,
            primary: colors.orange,
        },
```

```js
        colors: {
            ...defaultTheme.colors,
            primary: colors.indigo,
        },
```

指定できるカラーはtailwindを参考。  
https://tailwindcss.com/docs/customizing-colors

`npm run prod`を忘れずに。

## ダークモード
`tailwind.config.js`の`darkMode`を残せばダークモードが有効。消せば無効。

```
darkMode: 'media',
```
```
//darkMode: 'media',
```

これも`npm run prod`

## 管理画面のパスワード
.envで
```
ORDERING_ADMIN_PASSWORD=secret
```

デフォルトでは何もないので設定しなくてもいい。  
何もないので不正にログイン成功されても被害はない。

## テイクアウトの無効化
.envで
```
ORDERING_TAKEOUT=false
```

テーブル番号を「takeout」にしてるだけなのでテイクアウト専用メニューを表示するような特別な機能はない。  
テイクアウトに対応してないなら無効化。

## ルーティングを無効化
.envで
```
ORDERING_ROUTES=false
```

Laravelプロジェクト側のルーティングで指定したいような時は無効化。
