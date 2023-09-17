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
    <!-- jQuery 郵便番号自動生成 -->
    <script src="//yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <!-- jQuery autocompleteを使った自動補完 -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    
    <script>
        
    $(function() {
        $("#customer").autocomplete({
            source: "autocomplete-customer.php"
        });
        $("#company").autocomplete({
            source: "autocomplete-company.php"
        });
        $("#employee").autocomplete({
            source: "autocomplete-employee.php"
        });
        $("#opportunity").autocomplete({
            source: "autocomplete-opportunity.php"
        });
    });
</script>


    <title>CorpSales/コープセールス</title>
    
</head>

<body>
