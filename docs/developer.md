# 開発者向け

## 方針
- なるべくconfigファイルは公開しなくていいようにenvで設定。

## デプロイ
- viewファイルを変更したら`npm run prod`で再ビルドを忘れないようにする。cssが反映されてない時は要確認。開発中は`npm run dev`、本番へのデプロイ前に`npm run prod`
- self-orderingパッケージ更新後もパッケージ内のviewファイルが更新されていることがあるので`npm run prod`
