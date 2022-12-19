# Configuration

преопределение штатного класса сущности

    video_content:
        db_driver: orm модель данных
        factory: App\VideoContent\Factory\VideoContentFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\VideoContent\Entity\VideoContent сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto_class: App\VideoContent\Dto\VideoContentDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд видеоконтента
          query - декоратор mediator запросов видеоконтента
        services:
          pre_validator - переопределение сервиса валидатора видеоконтента
          handler - переопределение сервиса обработчика сущностей
          file_system - переопределение сервиса сохранения файла

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_VIDEO_CONTENT, API_CRITERIA_VIDEO_CONTENT - получение видеоконтента
    2. API_POST_VIDEO_CONTENT - создание видеоконтента
    3. API_PUT_VIDEO_CONTENT -  редактирование видеоконтента

# Статусы:

    создание:
        видеоконтент создан HTTP_CREATED 201
    обновление:
        видеоконтент обновлен HTTP_OK 200
    удаление:
        видеоконтент удален HTTP_ACCEPTED 202
    получение:
        видеоконтент найден HTTP_OK 200
    ошибки:
        если видеоконтент не найден VideoContentNotFoundException возвращает HTTP_NOT_FOUND 404
        если видеоконтент не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если видеоконтент не прошел валидацию VideoContentInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если видеоконтент не может быть сохранен VideoContentCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности video_content нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.video_content.constraint.property

    evrinoma.video_content.constraint.property.custom:
        class: App\VideoContent\Constraint\Property\Custom
        tags: [ 'evrinoma.video_content.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
   