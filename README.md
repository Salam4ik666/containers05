# IWNO5: Взаимодействие контейнеров

- [IWNO5: Взаимодействие контейнеров](#iwno5-взаимодействие-контейнеров)
  - [Цель работы](#цель-работы)
  - [Задание](#задание)
  - [Описание выполнения работы](#описание-выполнения-работы)
  - [Выводы](#выводы)

## Цель работы
Выполнив данную работу студент сможет управлять взаимодействием нескольких контейнеров.
## Задание
Создать php приложение на базе двух контейнеров: nginx, php-fpm.
## Выполнение

Создайте репозиторий containers05 и скопируйте его себе на компьютер.

В директории containers05 создайте директорию mounts/site. В данную директорию перепишите сайт на php, созданный в рамках предмета по php.

Создайте файл .gitignore в корне проекта и добавьте в него строки:

```bash
# Ignore files and directories
mounts/site/*
```
Создайте в директории containers05 файл nginx/default.conf со следующим содержимым:
```
server {
    listen 80;
    server_name _;
    root /var/www/html;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    location ~ \.php$ {
        fastcgi_pass backend:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Описание выполнения работы

Создайте сеть internal для контейнеров.

Создайте контейнер backend со следующими свойствами:

  * на базе образа php:7.4-fpm;
  * к контейнеру примонтирована директория mounts/site в /var/www/html;
  * работает в сети internal.

Создайте контейнер frontend со следующими свойствами:

  * на базе образа nginx:1.23-alpine;
  * c примонтированной директорией mounts/site в /var/www/html;
  * с примонтированным файлом nginx/default.conf в /etc/nginx/conf.d/default.conf;
  * порт 80 контейнера проброшен на порт 80 хоста;
  * работает в сети internal.

```bash
docker network create internal
docker run -d --name backend --network internal backend
docker run -d --name frontend --network internal frontend
```
```bash
docker network connect internal backend
```
![pull backend](https://github.com/Salam4ik666/containers05/assets/159524637/80abe2a6-36c7-4748-b92e-fefd6f18f0f1)
![frontend](https://github.com/Salam4ik666/containers05/assets/159524637/f4cdec8f-0314-4920-acfb-d558b9f66e30)

Проверьте работу сайта в браузере, перейдя по адресу http://localhost. Если отображается базовая страница nginx, то перегрузите страницу.

![готово](https://github.com/Salam4ik666/containers05/assets/159524637/32bd6186-f396-4646-883c-c335175d6a5d)



## Ответы на вопросы

1. Каким образом в данном примере контейнеры могут взаимодействовать друг с другом?

В данном примере контейнеры взаимодействуют друг с другом через сеть Docker. Они могут обмениваться данными и устанавливать соединения друг с другом, используя имена контейнеров в качестве хостовых идентификаторов.

2. Как видят контейнеры друг друга в рамках сети internal?

В рамках сети internal контейнеры видят друг друга по именам, которые они были назначены при создании. В данном случае, контейнер backend виден контейнеру frontend под именем backend, поскольку они оба присоединены к одной сети.

3. Почему необходимо было переопределять конфигурацию nginx?

Переопределение конфигурации nginx было необходимо для того, чтобы указать, что php-fpm находится на другом контейнере с именем backend внутри сети Docker. Это позволяет nginx правильно направлять запросы на php-fpm для обработки php-скриптов.

## Выводы

Эта лабораторная демонстрирует простой способ настройки и запуска взаимодействующих контейнеров с использованием Docker. Она позволяет легко создавать и тестировать многоконтейнерные приложения, разделяя их на отдельные слои функциональности. Работа с контейнерами позволяет эффективно управлять зависимостями приложения и обеспечивает изоляцию и масштабируемость.
