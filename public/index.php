<?php
require('../vendor/autoload.php');

use Acme\Controllers\Core;

// Вызов метода (Точка входа в анализ методов)
$core = new Core();
$core->run();
