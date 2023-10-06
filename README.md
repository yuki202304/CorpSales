# CorpSales
## サービス概要
顧客管理、案件管理、行動管理が行える営業支援システムです。前職の営業経験から営業マンの負担の少ないシンプルでわかりやすい営業支援システムを制作したいと思い開発しました。

<img width="942" alt="index" src="https://github.com/yuki202304/CorpSales/assets/131171459/63f272fe-d3e6-45f2-b175-fc977924a4eb">

## URL
https://corpsales-934dbaf7e58f.herokuapp.com

*現在、サービス停止中です。(2023/10/6現在)

## 制作期間
約2カ月

## メイン機能
・ログイン、ログアウト機能

・グラフ表示機能

・企業の検索機能

・企業、担当者、案件、日報それぞれの追加、更新機能

## 使用技術
・バックエンド　PHP 7.1.33

・フロントエンド　html、css、javascript、jQuery

・データベース　mySQL 8.0.28

・その他　github、heroku、MySQL Workbench、VScode

## ER図
![er](https://github.com/yuki202304/CorpSales/assets/131171459/34a8474b-ac9f-4901-84c2-9d59e7b37c31)

## 利用方法
### 1.ログイン
下記画面でログインします。

＊管理者がユーザー登録をする前提で制作しています。ログイン前画面にログインIDとパスワードを載せているのでそちらを用いてログインしてください。

<img width="959" alt="login" src="https://github.com/yuki202304/CorpSales/assets/131171459/c7246bd9-0973-4496-8f55-86547893291f">

### 2.TOP画面
TOP画面で個人成績と今月全体成績を表示させるようにしています。

個人成績では今月を含めた今後3カ月間の案件が確認できます。受注確度も同時に確認できるので進捗状況が一目でわかります。
それぞれの案件金額や受注確度など変更ボタンから編集することができるようにしています。

今月全体成績では今月の受注済み金額が上位の担当者順に棒グラフと表で表示させるようにしています。

<img width="948" alt="graph" src="https://github.com/yuki202304/CorpSales/assets/131171459/56e81b29-5bc4-407a-afbe-866d73a14dcf">
<img width="947" alt="index2" src="https://github.com/yuki202304/CorpSales/assets/131171459/db5e7bd2-b52a-47e6-8423-a41ba0852bc1">

### 3.企業一覧

企業一覧画面ではデータベースに登録されている企業を確認することができます。ページネーションを実装しており、1ページにつき10件ずつ表示させています。

フォームでは法人番号、企業名、住所、電話番号、自社担当者の検索が可能です。

詳細ボタンから企業ごとの詳細情報を確認することができます。

<img width="947" alt="history" src="https://github.com/yuki202304/CorpSales/assets/131171459/ea80c361-8e12-45b0-9ced-c554b6b37428">

### 4.企業登録

企業登録画面から企業登録を行います。必須項目に入力せず確定ボタンを押すとエラーメッセージが表示されます。
自社担当者の入力項目では現在ログインしている担当者名が自動的に入力されるようにしていますが、変更することも可能です。

<img width="947" alt="company" src="https://github.com/yuki202304/CorpSales/assets/131171459/e97350ff-f938-44ce-901b-d6c6874714db">

### 5.担当者登録

担当者登録画面から担当者登録を行います。企業登録と同様、必須項目に入力せず確定ボタンを押すとエラーメッセージが表示されます。
また、登録を行っていない企業を関連先企業の項目に入力するとエラーメッセージを表示するようにしています。

正しい関連先企業の入力を行ってもらうため、文字の一部を入力すると当てはまる単語をリストアップしてくれるjQuery UIのAutocompleteを使用してオートコンプリート（自動補完）機能を実装しています。

<img width="948" alt="customer" src="https://github.com/yuki202304/CorpSales/assets/131171459/26c8ba8d-a157-40fa-9256-8b2bee42b8b3">

### 6.案件登録

案件登録画面から案件登録を行います。担当者登録同様、関連先企業の項目ではオートコンプリート機能を実装しています。

<img width="946" alt="opportunity" src="https://github.com/yuki202304/CorpSales/assets/131171459/3e6d8b74-6d6b-4785-8524-946aa0492fa8">

### 7.行動登録

行動登録画面から行動登録を行います。関連先企業を入力した後に案件・担当者検索ボタンを押すと関連先企業に紐づいている案件と担当者をセレクトボックスで選択できるようになります。このようにしたことで入力の手間を省くことができます。

検索ボタンを押す前は関連先案件、取引先担当者ともにテキストボックスとなっていますが、入力できないようにしています。

<img width="947" alt="report" src="https://github.com/yuki202304/CorpSales/assets/131171459/1526753c-0624-4346-af69-1db9959d854d">

### 8.企業詳細

企業一覧画面の変更ボタン押下後、企業詳細画面へ遷移します。企業詳細では登録内容の確認ができます。変更ボタンから編集画面に遷移し、法人番号以外の変更を行うことができます。

<img width="947" alt="company-detail" src="https://github.com/yuki202304/CorpSales/assets/131171459/fa6ac2af-70e7-4c80-9819-182634ee0214">

### 9.担当者詳細

担当者詳細タブを押下することで詳細を確認することができます。

<img width="947" alt="customer-detail" src="https://github.com/yuki202304/CorpSales/assets/131171459/ff80bcfe-3a86-44b7-891e-ad75ae89a8d2">

### 10.案件詳細

企業詳細、担当者詳細同様に案件詳細の確認、編集を行うことができます。案件ごとに行動履歴を表示させるようにしています。

<img width="947" alt="opportunity-detail" src="https://github.com/yuki202304/CorpSales/assets/131171459/e24a84cc-44fa-42bb-8252-26b524bbff9a">

### 11.行動詳細

案件ごとの行動履歴を確認することができます。＋ボタンを押すことでそれぞれの行動詳細を確認することができ、変更ボタンから編集画面に遷移します。

<img width="947" alt="report-detail" src="https://github.com/yuki202304/CorpSales/assets/131171459/e8dacfda-ba2e-48dc-a194-c82faea66bc8">

### 12.ログアウト

ログアウト画面でログアウトを行います。

<img width="959" alt="logout" src="https://github.com/yuki202304/CorpSales/assets/131171459/2cf87ba0-01c6-451a-9969-c87b1ddb49db">





