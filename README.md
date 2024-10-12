# my-simple-lamp

👯👯👯 久しぶりにLAMP環境を構築してみる！  

![成果物](./fruit.gif)  

## 実行方法

```shell
docker compose up -d --build
```

MySQLへ接続するためには、以下のコマンドを実行します。  

```shell
docker compose run --rm bastion bash
bash -c "$MYSQL_LOGIN_COMMAND"
```
