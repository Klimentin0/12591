<?php

function getAudioDuration($filePath) {
    $command = "soxi -D " . escapeshellarg($filePath);
    exec($command, $output, $returnVar);

    if ($returnVar !== 0 || empty($output)) {
        return [
            'success' => false,
            'error' => 'Ошибка получения длины аудиофайла',
            'time' => null
        ];
    }

    return [
        'success' => true,
        'error' => null,
        'time' => (float)$output[0]
    ];
}

function calculateAudioDuration($filePath, $secondsToSubtract) {
    if (!file_exists($filePath)) {
        return [
            'success' => false,
            'error' => "ошибка: файл не найден '$filePath'",
            'time' => null
        ];
    }

    $durationResult = getAudioDuration($filePath);
    if (!$durationResult['success']) {
        return [
            'success' => false,
            'error' => "ошибка: не удалось получить длину аудиофайла",
            'time' => null
        ];
    }

    $duration = $durationResult['time'];
    $secondsToSubtract = (float)$secondsToSubtract;
    
    if ($secondsToSubtract > $duration) {
        return [
            'success' => false,
            'error' => "ошибка: вычитаемое время больше длительности аудио",
            'time' => null
        ];
    }

    return [
        'success' => true,
        'error' => null,
        'time' => $duration - $secondsToSubtract
    ];
}

?>