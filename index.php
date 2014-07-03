<?php

define("IN_FILE", true);

require_once("smarty/libs/Smarty.class.php");

$smarty = new Smarty();
$smarty->setTemplateDir("smarty/templates/");
$smarty->setCompileDir('smarty/templates_c/');
$smarty->setConfigDir('smarty/configs/');
$smarty->setCacheDir('smarty/cache/');

$smarty->display("layout.tpl");