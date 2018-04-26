<?php
require('../vendor/autoload.php');

use Acme\Controller\Core;

// Вызов метода (Точка входа в анализ методов)
$core = new Core();
$core->run();
