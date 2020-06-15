<?php
	session_start();
	unset ( $_SESSION["hqs"] );
	header("Location: index.php");