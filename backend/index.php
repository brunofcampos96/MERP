<?php
mb_internal_encoding("UTF-8");
set_time_limit(60);

require __DIR__ . '/vendor/autoload.php';
$app = new \App\App;
require __DIR__ . '/src/router.php';

date_default_timezone_set('America/Sao_Paulo');
$app->run();
