# カートの仕様

- セッションをcookieドライバーで使うと容量制限に引っかかりやすいのでカートや注文履歴には「商品のID」のみを保存。
- シンプルに「商品のID」の配列。
- 「商品のID」は数値も文字列もありえる。

## セッションのkey
- テーブル番号 : table
- カート : cart
- 追加メモ : memo
- 注文履歴 : history

## カートへ追加

```php
    public function add($id): void
    {
        $cart = session('cart', []);

        $cart[] = $id;

        session(['cart' => $cart]);
    }
```

## カートのリセット

```php
    public function reset(): void
    {
        session()->forget(['cart', 'memo']);
    }
```

## 注文履歴へ追加

```php
    public function add(array $history)
    {
        $histories = collect(session('history', []));

        $histories = $histories->prepend($history)
                               ->take(config('ordering.history_limit', 10));

        session(['history' => $histories->toArray()]);
    }
```

## 商品IDから商品データ
`Menu::get()`で全メニューデータを取得。  
`firstWhere('id', $id)`で指定IDの商品データに変換。

```php
use Revolution\Ordering\Facades\Menu;
use Illuminate\Support\Collection;

        $menus = Collection::wrap(Menu::get());

        $items = session('cart', []);

        $items = collect($items)
            ->map(fn ($id) => $menus->firstWhere('id', $id))
            ->toArray();
```