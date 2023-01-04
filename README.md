# Kuro Photos

[![PWD](https://raw.githubusercontent.com/play-with-docker/stacks/master/assets/images/button.png)](https://labs.play-with-docker.com/?stack=https://raw.githubusercontent.com/kuro-vale/kuro-photos/main/pwd-stack.yml)

Web app to share your favorite photos, made with laravel.

This web app was made for educationals purposes only.

## Screenshots

#### Home
![image](https://user-images.githubusercontent.com/87244716/161460801-5c01d594-5599-46d1-aeb3-321b31e1eadc.png)
#### Photos
![Screenshot_20230104_160103](https://user-images.githubusercontent.com/87244716/210649192-8505adbe-ae02-40fb-b4c9-87786b2db957.png)
#### Users
![image](https://user-images.githubusercontent.com/87244716/161460866-bb089244-ab45-4a5a-8fc9-08186ab57681.png)
#### User's Dashboard
![image](https://user-images.githubusercontent.com/87244716/161460915-a01daa33-05b7-4190-bb7a-a631a956b4a0.png)

## Deploy

Follow any of these methods and open http://localhost:8000/ to see the WebApp

### Docker

Run the command below to quickly deploy this project on your machine, see the [docker image](https://hub.docker.com/r/kurovale/kuro-photos) for more info.

```bas
docker run -d -p 8000:8000 kurovale/kuro-photos:sqlite
```

### Quick setup

You can run this web app on your machine, just follow these steps:

1. ```git clone https://github.com/kuro-vale/kuro-photos.git```
2. ```cd kuro-photos```
3. ```composer install```
4. Create a .env, use .env.example as reference*
5. ```php artisan storage:link```
6. ```php artisan migrate```
7. ```php artisan serve```

### Editing .env

If you want to use local storage just checkout to the commit c62701c8b662a34527ddd47a190b790c7f4d8467, that's before I setup Google Drive as a storage provider, commits after that are configs for deployment in Heroku.

- For Google Drive as a storage provider see [flysystem-google-drive-ext](https://github.com/masbug/flysystem-google-drive-ext).

More info about .env [here](https://laravel.com/docs/9.x/configuration#environment-configuration)

