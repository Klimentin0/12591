<?php

function getAudioDuration($filePath) {
    $command = "soxi -D " . escapeshellarg($filePath);
    exec($command, $output, $returnVar);

    if ($returnVar !== 0 || empty($output)) {
        return [false, null]; 
    }

    return [true, (float)$output[0]];
}

function calculateAudioDuration($filePath, $secondsToSubtract) {
    if (!file_exists($filePath)) {
        return [false, "ошибка: файл не найден '$filePath'", null];
    }

    list($success, $duration) = getAudioDuration($filePath);
    if (!$success) {
        return [false, "ошибка: не удалось получить длину аудиофайла", null];
    }

    $secondsToSubtract = (float)$secondsToSubtract;
    
    if ($secondsToSubtract > $duration) {
        return [false, "ошибка: вычитаемое время больше длительности аудио", null];
    }

    $result = $duration - $secondsToSubtract;
    return [true, null, $result];
}

?>