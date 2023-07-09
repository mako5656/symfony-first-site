# 開発環境

- PHP：8.1.8
- symfony：6.1.4

# website-skeletonプロジェクト作成

Webアプリケーションのフルセット

```
composer create-project symfony/website-skeleton my-symfony-app
```

# skeletonプロジェクト作成

必要最低限のアプリケーションプロジェクト

```
composer create-project symfony/skeleton my-symfony-app
```

# プロジェクト実行

```
symfony server:start
```

# コントローラーの作成

```
php bin/console make:controller
```

# エンティティの作成

```
php bin/console make:entity
```

# データベースの作成

```
php bin/console doctrine:database:create
```

# マイグレーションファイルの作成

```
php bin/console make:migration
```

# マイグレーションの適用

```
php bin/console doctrine:migrations:migrate
```

# エンティティとDBを同期する、差分を確認する

```
php bin/console doctrine:schema:update
```

# エンティティとDBが同期されているかを調べる

```
bin/console doctrine:schema:validate
```

# キャッシュを削除する

```
bin/console cache:clear
```

# ログ出力場所

```
/var/log/dev.log
```
