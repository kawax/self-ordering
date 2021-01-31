# Vercelで動かす

一番安く運用する方法。

https://vercel.com/

## 前提
README通りにインストールしたプロジェクトが前提。

すぐに動かせるプロジェクトテンプレートも。  
https://github.com/kawax/self-ordering-starter

## 必要なファイルは追加済
`php artisan ordering:install`でVercelで動かすためのファイルもインストールされている。

変更するとしたら`vercel.json`の`APP_NAME`。

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
