<?php
include "../includes/init.php";

$query	=	"INSERT INTO tab_texts(id_text, text_id, text_title, text_desc) VALUES(NULL, 4, 'email', 'famigliaboroli@deagostini.it');";
$query	=	mysql_query($query);
//print_r(mysql_fetch_array($query));

?>