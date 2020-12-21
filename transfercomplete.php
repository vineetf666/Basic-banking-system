<?php include('connection.php'); ?>

<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Transfer process</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">

    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    
    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
  </head>
  <body class="d-flex h-100 text-left text-white bg-dark">

    
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
            
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a href="index.php" class="brand-logo"><img src="logo.png" height="60px" width="80px"></a>
  <a class="navbar-brand" href="home.php">Basic Banking System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Bank Users<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Transaction History</a>
      </li>
    &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>  
      </nav>
    </div>
  </header>
  <br><br><br><br><br><br><br><br>
  
  <section>
  <div class="container" style="height: 85vh;">
  <?php 
    if($_SERVER["REQUEST_METHOD"]=='POST'){
    $sender=$_POST['Sname'];
    $receiver=$_POST['Rname'];
    $transfer_amount=$_POST['amount'];
    if( $sender != $receiver && $transfer_amount>0) {
      
        $senderQuery="SELECT c_balance FROM customer_details WHERE c_name='${sender}'";
        $senderConn=mysqli_query($conn, $senderQuery);
        $senderResult=mysqli_fetch_array($senderConn);
        $senderBalance=$senderResult['c_balance'];
        $receiverQuery="SELECT c_balance FROM customer_details WHERE c_name='${receiver}'";
        $receiverConn=mysqli_query($conn, $receiverQuery);
        $receiverResult=mysqli_fetch_array($receiverConn);
        $receiverBalance=$receiverResult['c_balance'];

        $senderBalance-=$transfer_amount;
        $receiverBalance+=$transfer_amount;
        //echo $senderBalance." ".$receiverBalance;
        $senderBalanceUpdate="UPDATE customer_details SET c_balance=\"{$senderBalance}\" WHERE c_name=\"{$sender}\"";
        $senderLogUpdate=mysqli_query($conn,$senderBalanceUpdate);

        $receiverBalanceUpdate="UPDATE customer_details SET c_balance=\"{$receiverBalance}\" WHERE c_name=\"{$receiver}\"";
        $receiverLogUpdate=mysqli_query($conn,$receiverBalanceUpdate);

        $historyQuery="INSERT INTO transfer_history (t_sender, t_receiver, t_amount) VALUES ('{$sender}', '{$receiver}', {$transfer_amount})";
        $historyUpdate=mysqli_query($conn, $historyQuery);
        if(!$historyUpdate) {
          echo "ERROR!";
        }

        echo "<h3 class=\"green-text\"> Transaction Successful!</h3>";
        echo "<h5>₹{$transfer_amount} has been deducted from your account i.e. {$sender} and the fund is succesfully transfered to {$receiver}.</h5>";
        echo "<a href=\"transferhistory.php\" class=\"waves-effect waves-light btn black\">Transfer History</a>";
        echo "     <a href=\"home.php\" class=\"waves-effect waves-light btn black z-depth-2\">Home</a>";
    }
    else {
      echo "<h3 class=\"red-text accent-3\"> Transaction Failed!</h3>";
      if($sender==$receiver) {
        
        echo "<h5 class=\"red-text accent-3\">Sender and receiver cannot be the same person.</h5>";
      }
      else {
        echo "<h5 class=\"red-text accent-3\">Transfer amount cannot be negative.</h5>";
      }
      echo "<p>Redirecting to previous, please wait. <a href=\"transfer.php\">Click here</a> to redirect manually</p>";
      header( "refresh:5;url=transfer.php" );
    }
  }
