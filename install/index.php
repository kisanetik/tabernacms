<?php
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE);

header('Content-Type: text/html; charset=utf-8');

include 'application.php';

app::run();