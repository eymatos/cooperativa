<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sgstec = "localhost";
$database_sgstec = "cooproco_amr";
$username_sgstec = "cooproco_n";
$password_sgstec = "procon01";
$sgstec = mysql_connect($hostname_sgstec, $username_sgstec, $password_sgstec) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_sgstec);
?>