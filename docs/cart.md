# カートの仕様

- セッションをcookieドライバーで使うと容量制限に引っかかりやすいのでカートや注文履歴には「商品のID」のみを保存。
- シンプルに「商品のID」の配列。
- 「商品のID」は数値も文字列もありえる。
- デフォルトの仕様なのでカスタマイズするのは自由。

## セッションのkey
- テーブル番号 : `table` string
- カート : `cart` array
- 追加メモ : `memo` string
- 注文履歴 : `history` array

## カートへ追加

```php
    public function add($id): void
    {
        $cart = session('cart', []);

        $cart[] = $id;

        session(['cart' => $cart]);
    }
```

## カートから削除
配列の$index番目を削除。同じIDの商品が複数カートに入るのでID指定で削除はしない。

```php
    public function delete(int $index): void
    {
        $items = Arr::except(session('cart', []), [$index]);

        session(['cart' => $items]);
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

## Cart Facade
`Cart::items()`で変換済の商品データのCollectionとして取得。
```php
use Revolution\Ordering\Facades\Cart;

$items = Cart::items();
```
引数を省略した場合は以下と同じ。
```php
$items = Cart::items(session('cart', []), Collection::wrap(Menu::get()));
```

```php
use Revolution\Ordering\Facades\Cart;

Cart::add($id);
Cart::delete($index);
Cart::reset();
$ids = Cart::all();//商品データに変換済のitems()ではなく商品IDのみ。
```
