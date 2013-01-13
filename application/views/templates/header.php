<?php
/**
* Main header template
*
* @category Template
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <?
    /**
     * @see Pages::fetchConfig()
     * @var $title string
     * @var $description string
     * @var $author string
     */
    ?>
    <title><?=$title?> - Probe</title>
    <meta name="description" content="<?=$description?>">
    <meta name="author" content="<?=$author?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/resources/js/libs/jquery-1.8.3.min.js"><\/script>')</script>

    <link href="/resources/less/bootstrap/responsive.less" rel="stylesheet/less">

    <link type="image/png" rel="shortcut icon" href="/.favicon.png">
    <link rel="stylesheet/less" href="/resources/less/probe.less">
    <script src="/resources/js/libs/less-1.3.0.min.js"></script>

    <!-- Use SimpLESS (Win/Linux/Mac) or LESS.app (Mac) to compile your .less files
    to style.css, and replace the 2 lines above by this one:

    <link rel="stylesheet/less" href="less/style.css">
     -->

    <!-- modernizr/HTML5shiv must be in the head as the create HTML5 tag when non exixtent -->
<!--     <script src="/resources/js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script> -->
</head>
