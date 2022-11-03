<?php
chdir("/mnt/vol1/101india.com");
define('DRUPAL_ROOT', '/mnt/vol1/101india.com');
include_once DRUPAL_ROOT.'/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

require_once '/mnt/vol1/101india.com/vzaar-src/Vzaar.php';

Vzaar::$token = 'SJxSbf84NUl6cJsKjCHMCMcnhF9Qvw3XpmOpD4v268';
Vzaar::$secret = 'Abbasali';
$videodetail=Vzaar::getVideoDetails($_GET["videoid"], true);
print_r($videodetail->duration*1000);
?>