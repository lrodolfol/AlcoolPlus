<?php

/*
 * DESTROI A SESSÃO DE LOGIN E FAZ LOGOUT DO SISTEMA
 */

session_start();
session_destroy();
unset( $_SESSION );
header("location: ../");
?>