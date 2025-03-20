<?php

// Функция для получения продолжительности аудиофайла с помощью SoX
function getAudioDuration($filePath) {
    // Выполнить команду soxi для получения продолжительности аудиофайла
    $command = "soxi -D " . escapeshellarg($filePath);
    exec($command, $output, $returnVar);

    // Проверить, была ли команда успешной
    if ($returnVar !== 0 || empty($output)) {
        return false; // Вернуть false, если произошла ошибка
    }

    // Преобразовать вывод в float (продолжительность в секундах)
    return (float)$output[0];
}

// Основная логика скрипта
try {
    // Входные параметры
    if ($argc < 3) {
        throw new Exception("использование: php audio_processor.php <ПУТЬ> <Сколько секунд вычесть>");
    }

    $filePath = $argv[1]; // Полный путь к аудиофайлу
    $secondsToSubtract = (float)$argv[2]; // Количество секунд для вычитания

    // Проверить путь к файлу
    if (!file_exists($filePath)) {
        throw new Exception("ошибка: файл не найден '$filePath'.");
    }

    // Получить продолжительность аудиофайла
    $duration = getAudioDuration($filePath);
    if ($duration === false) {
        throw new Exception("ошибка: не удалось получить длину аудиофайла.");
    }

    // Выполнить вычитание
    $result = $duration - $secondsToSubtract;

    // Обработать случаи, когда результат отрицательный
    if ($result < 0) {
        echo "Результат: 0 секунд (Число для вычетания больше самого файла).\n";
    } else {
        echo "Результат: $result секунд.\n";
    }
} catch (Exception $e) {
    // Вывести любые ошибки
    echo "Ошибка: " . $e->getMessage() . "\n";
}
