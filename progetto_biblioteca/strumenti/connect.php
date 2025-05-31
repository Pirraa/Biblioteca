
<?php

    try{
		// Connessione -> db_ip, db_username, db_password, db_name
        $link = mysqli_connect("localhost", "francesco", "password", "Biblioteca"); 
        //$link = mysqli_connect("localhost", "user", "password", "Biblioteca"); 
    } catch(mysqli_sql_exception $e) {
		die("Non posso stabilire la connessione al db: " . $e->getMessage());
	}
?>


