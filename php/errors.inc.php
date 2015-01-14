<?php

define("ERR_NONE",0);

define("ERR_DEBUG",1);

define("ERR_SERVER",666);
define("ERR_DIR",667); //album dir creation/removal failed
define("ERR_FILE",668); //file operation failed

//MySQL
define("ERR_MYSQL_L",6000); //Database NOT loaded (linked)
define("ERR_MYSQL_Q",6001); //Query failure
define("ERR_MYSQL_R",6002); //Query failure

?>