# メニューデータをContentfulで管理

分かる人向けなので細かいことは省略。

https://www.contentful.com/

## Content model

### メニュー(menus)
- `name` 名前 Short text
- `text` 説明 Short text
- `category` カテゴリー Short text
- `price` 価格 Integer
- `image` 画像 Media

## .env
ContentfulでAPIキーとエンドポイントのURLとコンテンツタイプを確認して.envに設定。

APIキーは`Content Delivery API - access token`

エンドポイントはこれの{SPACE_ID}を置き換え。必要ならenvironmentsも。  
`https://cdn.contentful.com/spaces/{SPACE_ID}/environments/master/entries`

コンテンツタイプはContent modelのID。

https://www.contentful.com/developers/docs/references/content-delivery-api/

```
ORDERING_MENU_DRIVER=contentful
ORDERING_CONTENTFUL_API_KEY=
ORDERING_CONTENTFUL_ENDPOINT=https://cdn.contentful.com/spaces/***/environments/master/entries
ORDERING_CONTENTFUL_TYPE=menus
```

VercelならEnvironment Variablesで設定。

### メニュー件数
最大1000まで。

```
ORDERING_CONTENTFUL_LIMIT=1000
```

### 並び順
デフォルトはカテゴリー名の順。

```
ORDERING_CONTENTFUL_ORDER=fields.category
```
