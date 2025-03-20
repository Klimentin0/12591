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

$originalDurResult = getAudioDuration($filePath);
if (!$originalDurResult['success']) {
    echo "Ошибка: " . $originalDurResult['error'] . "\n";
    exit(1);
}
$originalDuration = $originalDurResult['time'];

do {
    echo "Введите количество секунд для вычитания: ";
    $secondsInput = trim(fgets(STDIN));
    
    if (!is_numeric($secondsInput)) {
        echo "Ошибка: введите числовое значение. Попробуйте снова.\n";
    }
} while (!is_numeric($secondsInput));

$result = calculateAudioDuration($filePath, $secondsInput);

echo "\nРезультат обработки:\n";
echo "Исходная длительность: " . number_format($originalDuration, 2) . " сек\n";
echo "Вычитаемое время: " . number_format((float)$secondsInput, 2) . " сек\n";

if (!$result['success']) {
    echo "Ошибка: " . $result['error'] . "\n";
    exit(1);
}

echo "Итоговая длительность: " . number_format($result['time'], 2) . " сек\n";
exit(0);