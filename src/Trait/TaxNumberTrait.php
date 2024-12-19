<?php

namespace App\Trait;

trait TaxNumberTrait
{
    /**
     * Генерация паттерна для валидации.
     * Преобразует произвольный шаблон в регулярное выражение.
     *
     * @param string $template
     * @return string
     */
    public function generatePattern(string $template): string
    {
        $pattern = preg_replace(
            ['/X/', '/Y/'],
            ['\d', '[A-Z]'],
            $template
        );

        return '/^' . $pattern . '$/';
    }

    /**
     * Проверка, соответствует ли номер шаблону.
     *
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    public function compareNumberPattern(string $pattern, string $value): bool
    {
        return preg_match($pattern, $value) === 1;
    }
}
