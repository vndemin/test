# Инструкция для запуска
Запустить команду
```bash
docker-compose build && docker-compose up -d
```
После чего приложение доступно для использования
[API-документация после запуска http://localhost:8888/api/doc](http://localhost:8888/api/doc)

## Тех. решение

- Поднял кластер Redis для отказоустойчивости, т.к. в требованиях был акцент на высоких нагрузках
- Не стал использовать классическую onion-архитектуру(Infra-App-Domain), т.к. сильно терялась читабельность на таком небольшом коде
- В качестве хранения использовал структуру данных Hash, т.к. есть возможность инкрементировать конкретный ключ, а получение всех ключей по времени.
- Не использовал получение $this->redis->keys('countries:*'), т.к. операция очень высоконагруженная и опасная
- Валидацию на код страны сделал с помощью библиотеки  symfony/intl