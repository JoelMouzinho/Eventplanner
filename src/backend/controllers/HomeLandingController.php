<?php
require_once __DIR__ . '/../middleware/auth.php';

if (isLoggedIn()) {
    redirect('/home/');
}
