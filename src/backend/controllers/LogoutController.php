<?php
require_once __DIR__ . '/../middleware/auth.php';
logoutUser();
redirect('/');
