<?php

use App\Library\Session\Flash;

$flashMessages = Flash::all();
if (!empty($flashMessages)) {
    foreach ($flashMessages as $type => $message) {
        $alertClass = 'bg-blue-100 border-blue-500 text-blue-700';
        switch ($type) {
            case 'success':
                $alertClass = 'bg-green-100 border-green-500 text-green-700';
                break;
            case 'error':
                $alertClass = 'bg-red-100 border-red-500 text-red-700';
                break;
            case 'warning':
                $alertClass = 'bg-yellow-100 border-yellow-500 text-yellow-700';
                break;
        }
        echo "<div class='border-l-4 p-4 mb-4 {$alertClass}' role='alert'>";
        echo "<p class='font-bold'>" . ucfirst($type) . "</p>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        echo "</div>";
    }
}
