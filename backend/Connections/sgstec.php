<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sgstec = "db-mysql-arreglatap-do-user-11514964-0.b.db.ondigitalocean.com:25060";
$database_sgstec = "cooperativav2";
$username_sgstec = "developer";
$password_sgstec = "AVNS_-VOrwRcsZd7Xjc_";
$sgstec = mysqli_connect($hostname_sgstec, $username_sgstec, $password_sgstec) or trigger_error(mysqli_error(),E_USER_ERROR);
mysqli_select_db($sgstec,$database_sgstec);
//var ConnectionString string = "developer:AVNS_-VOrwRcsZd7Xjc_@tcp(db-mysql-arreglatap-do-user-11514964-0.b.db.ondigitalocean.com:25060)/arreglatappdb?parseTime=True"
?>
