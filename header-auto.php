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
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <!-- jQuery autocompleteを使った自動補完 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
    
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