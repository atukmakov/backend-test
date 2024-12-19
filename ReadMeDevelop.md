# Реализация

***

## Запуск
* Добавлен файл [compose.override.yaml](compose.override.yaml) с конфигурацией БД
* Добавлены переменные окружения в .env DB_MAIN_PASSWORD, DB_MAIN_VERSION
* После сборки и запуска контейнера выполнить 
```
bin/console doctrine:migrations:migrate
```

```
bin/console doctrine:fixtures:load
```
(Не стал добавлять в сборку контейнера)

## Тестирование

* Запустить тесты [requests.http](requests.http)
* Добавлены тесты одного сервиса [PaymentServiceTest.php](tests%2FService%2FPaymentServiceTest.php)

## Комментарии для реализации
* Вся бизнеслогика вынесена в сервис с соответствующими именами
* Ограничения реализованы на уровне DTO. Можно реализовать еще c помощью классов Form и Violations
* Исключения сервисов Exception (не стал реализовывать кастомные)
* Исключения контроллеров ApiException
* Логирование не добавлял