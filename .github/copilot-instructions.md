# GitHub Copilot 開発ガイド

## プロジェクト概要
このプロジェクトは、Laravelベースのオープンソースセルフオーダーシステムです。スマホでQRコードを読み込んで注文できるWebシステムを提供します。

## 技術スタック
- **PHP**: ^8.2
- **Laravel**: ^12.x
- **Livewire**: 3.x
- **Tailwind CSS**: 4.x

## アーキテクチャ
- **パッケージ構成**: Laravel用のcomposerパッケージとして実装
- **名前空間**: `Revolution\Ordering\`
- **サービスプロバイダー**: `Revolution\Ordering\Providers\OrderingServiceProvider`
- **データベース**: 不要（Vercel対応のためファイルベース運用可能）

## コーディング規約

### Laravel固有の規約
- `\Auth`、`\Log`などの短いFacadeは使用禁止
- `Illuminate\Support\Facades\Auth`のようにフルでインポートするか、`auth()`、`info()`などのグローバルヘルパーを使用
- 一時変数を避け、Laravelの便利なヘルパーを活用
- Eloquentよりもコレクションやヘルパーを優先

### コード品質
- 差分は最小限に抑える（変更行数を少なく）
- 既存コードのロジックを最大限活用
- ファイル数・関数の変更を最小限にする
- 常にテストとlintを実行する（`composer test`、`composer lint`）

### ファイル構成
- **Actions**: ビジネスロジック（カート追加、注文処理など）
- **Contracts**: インターフェース定義
- **Drivers**: メニュー管理、決済方法の実装
- **Livewire**: UI コンポーネント
- **Events**: システムイベント

## 主要機能

### メニュー管理
- **ArrayDriver**: 配列ベースのメニュー
- **ContentfulDriver**: Contentful CMS連携
- **GoogleSheetsDriver**: Googleスプレッドシート連携
- **MicroCmsDriver**: microCMS連携

### 決済方法
- **CashDriver**: 現金決済
- **PaypayDriver**: PayPay決済

### 認証
- **OrderingRequestGuard**: カスタム認証ガード
- セッションベースの認証システム

## 開発時の注意点

### テストとLint
```bash
# テスト実行
composer test

# コード整形
composer lint
```

### 拡張性
- 新しい決済方法やメニューソースを追加する際は、対応するContractを実装
- ドライバーパターンを使用して機能を拡張
- 既存のFactoryクラスを活用

### Livewireコンポーネント
- リアルタイムUI更新に使用
- カート管理、注文履歴、決済処理で活用
- アルパインJSとの連携も考慮

### 設定ファイル
- `config/ordering.php`: パッケージの設定
- 店舗ごとのカスタマイズに対応

## コミット・リリース

### Git使用
```bash
# 差分確認
git diff --numstat
git diff --name-only
git diff

# 適切なコミットメッセージ
git commit -m "feat: add new payment method"
git commit -m "fix: resolve cart calculation issue"
```

### バージョン管理
- セマンティックバージョニングを使用
- 破壊的変更はメジャーバージョンアップ
- 新機能はマイナーバージョンアップ

## パフォーマンス最適化
- Vercelでの動作を考慮
- データベース不要の軽量実装
- キャッシュ戦略の実装

## セキュリティ
- CSRF保護の実装
- XSS対策
- 適切なバリデーション

## 商用利用について
- 開発・設置・運用代行をビジネスとして利用可能
- 店舗ごとのカスタマイズを前提とした設計
- オープンソースライセンスに準拠

## 追加リソース
- [カート機能](./docs/cart.md)
- [メニュー管理](./docs/menu.md)
- [決済機能](./docs/payment.md)
- [カスタマイズガイド](./docs/customize.md)
- [開発者向けドキュメント](./docs/developer.md)
