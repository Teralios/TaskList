<?php
// too many copy cat. I know why i do not like application system from WSC!
require_once('./config.inc.php');
require_once(RELATIVE_WCF_DIR . 'global.php');

// request handler
wcf\system\request\RequestHandler::getInstance()->handle('theia');