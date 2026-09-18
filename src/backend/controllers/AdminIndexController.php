<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireAdmin($pdo);

$stats = getAdminStats($pdo);
$earliestEvent = getEarliestEvent($pdo);
