<?php
require_once 'audio_duration.php';
echo "Аудио обработчик\n";
echo "----------------\n";

do {
    echo "Введите путь к аудиофайлу: ";
    $filePath = trim(fgets(STDIN));
    
    if (!file_exists($filePath)) {
        echo "Ошибка: файл не существует. Попробуйте снова.\n";
    }
} while (!file_exists($filePath));

do {
    echo "Введите количество секунд для вычитания: ";
    $secondsInput = trim(fgets(STDIN));
    
    if (!is_numeric($secondsInput)) {
        echo "Ошибка: введите числовое значение. Попробуйте снова.\n";
    }
} while (!is_numeric($secondsInput));

try {
    $result = calculateAudioDuration($filePath, $secondsInput);
    
    echo "\nРезультат обработки:\n";
    echo "Исходная длительность: " . getAudioDuration($filePath) . " сек\n";
    echo "Вычитаемое время: " . $secondsInput . " сек\n";
    
    if ($result === 0 && $secondsInput > 0) {
        echo "Итоговая длительность: 0 секунд (Число для вычетания больше самого файла)\n";
    } else {
        echo "Итоговая длительность: " . number_format($result, 2) . " сек\n";
    }
    
} catch (Exception $e) {
    echo "Критическая ошибка: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);