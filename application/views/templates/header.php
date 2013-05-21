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
    <title><?=$title?> - <?=$this->config->item('page.title:suffix.metadata')?></title>
    <meta name="description" content="<?=$description?>">
    <meta name="author" content="<?=$author?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?
    /*
     * TODO: use CDN URL for static resources
     */
    ?>
    <link type="image/png" rel="shortcut icon" href=".favicon.png">
    <link rel="stylesheet" type="text/css" href="/resources/css/probe.css">
</head>
