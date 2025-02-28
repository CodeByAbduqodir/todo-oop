<?php
declare(strict_types=1);

require 'credentials.php';

echo (new Bot())->setWebhook($argv[1]);
