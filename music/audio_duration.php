<?php

function getAudioDuration($filePath) {
    $command = "soxi -D " . escapeshellarg($filePath);
    exec($command, $output, $returnVar);

    if ($returnVar !== 0 || empty($output)) {
        return false;
    }

    return (float)$output[0];
}

function calculateAudioDuration($filePath, $secondsToSubtract) {
    if (!file_exists($filePath)) {
        throw new Exception("ошибка: файл не найден '$filePath'");
    }

    $duration = getAudioDuration($filePath);
    if ($duration === false) {
        throw new Exception("ошибка: не удалось получить длину аудиофайла");
    }

    $result = $duration - (float)$secondsToSubtract;
    return max(0, $result);
}

?>