# live-coding-20250618
TDDに関するLive Coding用リポジトリ

## 技術スタック
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-11.5-366488?style=flat&logo=php&logoColor=white)
![Pest](https://img.shields.io/badge/Pest-3.8-41B883?style=flat&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat&logo=docker&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-Alpine-009639?style=flat&logo=nginx&logoColor=white)

## 使用方法

### Makeコマンド一覧
- `make up` - Docker環境の起動
- `make down` - Docker環境の停止
- `make restart` - Docker環境の再起動
- `make logs` - ログの表示
- `make shell` - アプリケーションコンテナのシェルに接続
- `make migrate` - データベースマイグレーションの実行
- `make seed` - データベースシーダーの実行
- `make test` - テストの実行
- `make db-connect` - MySQLデータベースに接続（パスワード: secret）
- `make clean` - Docker環境のクリーンアップ

## TDDについて

TDD（Test-Driven Development）は「テスト駆動開発」と呼ばれる開発手法です。

### TDDの基本サイクル
1. **Red（赤）**: まず失敗するテストを書く
2. **Green（緑）**: テストが通る最小限のコードを書く
3. **Refactor（リファクタ）**: コードを改善する

### なぜTDDが有効なのか
- **バグの早期発見**: テストがあることで問題を素早く見つけられる
  ```
  例：計算機能を作るとき、先にテストがあれば「5+3=8」が正しく動作するかすぐ確認できる
  ```
- **設計の改善**: テストを先に書くことで、使いやすいコードになる
  ```
  例：「ユーザー登録」のテストを書くと、ユーザー登録処理にはどんな入力が必要かが明確になる
  → 不必要なデータを処理内で生成したりメソッドに渡したりすることを防げるので、見通しがよく使いやすいコードになる
  ```
- **安心してコード変更**: テストがあるので、リファクタリングが安全にできる
  ```
  例：コードを整理しても、テストが通れば既存の機能が壊れていないとわかる
  ```
- **仕様の明確化**: テストがコードの仕様書の役割を果たす
  ```例：
  「パスワードは8文字以上」というルールがテストで明文化される
  ```

### TDD初心者向けのポイント
- 最初は小さな機能から始める
- 完璧を求めず、まずはサイクルに慣れる
- テストコードも「コード」なので、読みやすく書く

## 今日やらないこと
- DBは使いません

## 今日やること
1. pestを導入
2. テストの実装
3. テストをパスする実装
4. 三角測量の実施
5. リファクタリング
6. 段階的にレベルを上げながら②〜⑤の手順を繰り返します
