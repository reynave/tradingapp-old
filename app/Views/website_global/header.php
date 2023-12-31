<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title;?></title>  
    <meta name="description" content="<?= $description;?>">
   
    <meta property="og:title" content="<?= $title;?>">
    <meta property="og:description" content="<?= $description;?>">
    <meta property="og:image" content="<?= $image;?>">
    <meta property="og:url" content="<?= $url;?>">
    <meta property="og:site_name" content="Mirrel.com">
    <meta property="og:type" content="website">
    
    <meta name="twitter:card" content="summary_large_image"> 
    <meta name="twitter:title" content="Mirrel.com">
    <meta name="twitter:description" content="<?= $description;?>">
    <meta name="twitter:image" content="<?= $image;?>">
 
    <link rel="canonical" href="<?= $canonical;?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Poppins:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="./favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/slick-1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/slick-1.8.1/slick/slick-theme.css"/>

    <link href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/bgn1.css" rel="stylesheet">
    
</head>

<body>