<?php
putenv('DB_HOST=localhost'); // change this to your database host
putenv('DB_NAME=db'); // change this to your database name
putenv('DB_USER=root'); // change this to your database user
putenv('DB_PASS=root'); // change this to your database password
putenv('DB_PORT=3306'); // change this to your database port
putenv('NEW_USER=true'); // set to false if you don't want to permit new user registrations
putenv('NEW_FILE=true'); // set to false if you don't want to permit new file uploads
putenv('MAX_FILE_SIZE=100M'); // set to the maximum file size you want to permit
?>