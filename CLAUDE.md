# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## プロジェクト概要

このプロジェクトは、Laravelベースのオープンソースセルフオーダーシステムです。スマホでQRコードを読み込んで注文できるWebシステムを提供するcomposerパッケージとして実装されています。

## 技術スタック
- **PHP**: ^8.2
- **Laravel**: ^12.x
- **Livewire**: 3.x
- **Tailwind CSS**: 4.x
- **名前空間**: `Revolution\Ordering\`

## 開発コマンド

### テストとコード品質
```bash
# PHPUnit テスト実行
composer test
vendor/bin/phpunit

# Laravel Pint（コード整形）
composer lint
vendor/bin/pint

# フロントエンド開発
npm run dev      # Vite開発サーバー起動
npm run build    # 本番用ビルド
```

### パッケージ開発
```bash
# インストールコマンド（新規Laravelプロジェクトで使用）
php artisan ordering:install --vercel  # Vercel用
php artisan ordering:install           # 通常版
```

## アーキテクチャ

### パッケージ構成
- **サービスプロバイダー**: `OrderingServiceProvider` - 全ての設定とバインディングを管理
- **設定ファイル**: `config/ordering.php` - 店舗情報、メニュー設定、決済設定
- **データベース不要**: Vercel対応のためファイルベース運用可能

### 主要コンポーネント

#### Actions（ビジネスロジック）
- `AddCartAction` - カート追加処理
- `OrderAction` - 注文処理
- `LoginAction/LogoutAction` - 認証処理
- `Api/MenusIndexAction` - メニューAPI

#### Menu管理（ドライバーパターン）
- `ArrayDriver` - 配列ベースのサンプルメニュー
- `MicroCmsDriver` - microCMS連携
- `GoogleSheetsDriver` - Googleスプレッドシート連携
- `ContentfulDriver` - Contentful CMS連携
- `MenuManager` - ドライバー管理クラス

#### Payment管理
- `CashDriver` - レジ後払い
- `PaypayDriver` - PayPay決済
- `PaymentManager` - 決済方法管理

#### Livewireコンポーネント
- `Order/Menus` - メニュー表示・注文
- `Order/Prepare` - 注文確認
- `Order/History` - 注文履歴
- `Dashboard/QrCodeGenerator` - QRコード生成

#### 認証システム
- `OrderingRequestGuard` - カスタム認証ガード
- セッションベースの簡易認証

### ディレクトリ構造
```
src/
├── Actions/          # ビジネスロジック
├── Auth/            # 認証システム
├── Cart/            # カート管理
├── Contracts/       # インターフェース定義
├── Events/          # システムイベント
├── Facades/         # Laravelファサード
├── Http/           # HTTPレイヤー（Livewire含む）
├── Menu/           # メニュー管理ドライバー
├── Payment/        # 決済管理ドライバー
├── Providers/      # サービスプロバイダー
├── Support/        # ユーティリティ
└── View/           # Bladeコンポーネント
```

## 開発時のルール

### Laravel固有の規約
- `\Auth`、`\Log`などの短いFacadeは使用禁止
- `Illuminate\Support\Facades\Auth`のようにフルでインポートするか、`auth()`、`info()`などのグローバルヘルパーを使用
- 一時変数を避け、Laravelの便利なヘルパーを活用

### 拡張方法
- 新しいメニューソースや決済方法を追加する場合は、対応するContractを実装
- ドライバーパターンを使用してManagerクラスで管理
- 設定は`config/ordering.php`で制御

### テスト実行
開発中は必ずテストとlintを実行:
```bash
composer test && composer lint
```

## 環境変数設定
```env
ORDERING_MENU_DRIVER=array
ORDERING_ADMIN_PASSWORD=
ORDERING_DESCRIPTION=""
ORDERING_MICROCMS_API_KEY=
ORDERING_MICROCMS_ENDPOINT=https://
```