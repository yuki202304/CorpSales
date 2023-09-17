<?php require('dbconnect.php'); ?>
<?php require('common.php'); ?>
<?php session_start(); ?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- jQuery -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
    <!--グラフ-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"
    integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg=="
    crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script>
    <!-- jQuery 郵便番号自動生成 -->
    <script src="//yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <title>CorpSales/コープセールス</title>
    
</head>

<body>
