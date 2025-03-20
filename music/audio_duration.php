<?php


function isSoxInstalled() {
    // Проверка установки через проверки на версию в командной строке. Опять же под линукс.
    exec("sox --version 2>&1", $output, $returnVar);

    // Если 0, sox установлен.
    return $returnVar === 0;
}

function getAudioDuration($filePath) {
    if (!isSoxInstalled()) {
        return [
            'success' => false,
            'error' => 'Ошибка: утилита sox не установлена',
            'time' => null
        ];
    } 

    $command = "soxi -D " . escapeshellarg($filePath);
    exec($command, $output, $returnVar);

    if ($returnVar !== 0 || empty($output)) {
        return [
            'success' => false,
            'error' => 'Ошибка получения длины аудиофайла',
            'time' => null
        ];
    }

    // Округляем длительность аудио вверх до ближайшего большего целого числа
    return [
        'success' => true,
        'error' => null,
        'time' => (int)ceil((float)$output[0])
    ];
}

function calculateAudioDuration($filePath, $secondsToSubtract) {
    if (!isSoxInstalled()) {
        return [
            'success' => false,
            'error' => 'Ошибка: утилита sox не установлена',
            'time' => null
        ];
    }
    if (!file_exists($filePath)) {
        return [
            'success' => false,
            'error' => "файл не найден '$filePath'",
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

    // Получаем округленную вверх длительность аудио
    $duration = $durationResult['time'];

    // Округляем вычитаемое время вверх до ближайшего большего целого числа
    $secondsToSubtract = (int)ceil((float)$secondsToSubtract);

    if ($secondsToSubtract > $duration) {
        return [
            'success' => false,
            'error' => "ошибка: вычитаемое время больше длительности аудио",
            'time' => null
        ];
    }

    // Возвращаем результат с округлением вверх
    return [
        'success' => true,
        'error' => null,
        'time' => $duration - $secondsToSubtract
    ];
}

?>
