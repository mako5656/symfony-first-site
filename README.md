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

# マイグレーションファイルの作成

```
php bin/console make:migration
```

# マイグレーションの適用

```
php bin/console doctrine:migrations:migrate
```

# ログ出力場所

```
/var/log/dev.log
```
