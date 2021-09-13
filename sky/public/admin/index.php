<?php
//abrir sessão

use core\classes\Database;

session_start();
//carregar o config
require_once('../../config.php');
require_once('../../vendor/autoload.php');
//carregar o sistema de rota
require_once('../../core/rotas_admin.php');

