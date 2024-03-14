# CHANGELOG

## v4.0.0 (2024-03-14)
- Laravel11 support
- Drop PHP8.1, Laravel10.x

## v3.0.0 (2023-08-27)
- Livewire 3 support
- Drop PHP8.0, Laravel9.x support

## v2.2.0 (2023-01-28)
- Laravel 10 support

## v2.1.0 (2022-06-29)
- Switch Laravel mix to [Vite](https://github.com/laravel/vite-plugin)
  - viewファイルを公開して使っている場合：既存プロジェクトへの影響はない。
  - 公開せず使ってる場合： Viteに移行する、もしくはviewファイルを公開後mixのまま使えるように変更が必要。

## v2.0.0 (2022-02-09)
- Laravel9 support
- Require PHP8.0+

## v1.8.0 (2021-12-30)
- Update to Tailwind 3

## v1.7.0 (2021-05-03)
- Add theme support
  - https://github.com/kawax/self-ordering-theme-tablet

## v1.6.0 (2021-04-23)
- Add `declare(strict_types=1)` to all files.

## v1.5.0 (2021-03-04)
- Add OrderID
- Add sold_out_until

## v1.4.0 (2021-02-12)
- Add Menu/ContentfulDriver

## v1.3.3 (2021-02-09)
- Remove Controllers

## v1.3.2 (2021-02-08)
- Add PayPay/CreateOrderItem

## v1.3.1 (2021-02-08)
- Add PayPay Events
- Add Auth Events

## v1.3.0 (2021-02-08)
- API追加開始。Livewire以外で構築する用。
  - 最初は`GET /api/menus`でメニュー情報を返すのみ。
  - 要望があれば追加していく。

## v1.2.8 (2021-02-07)
- Split PayPay package https://github.com/kawax/laravel-paypay

## v1.2.0 (2021-02-05)
- Add Payment
- Add PayPay
- Add Cart

## v1.1.0 (2021-02-03)
- Add GoogleSheetsDriver

## v1.0.0 (2021-02-02)
- first
