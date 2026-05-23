Pasos a seguir para ejecutar el programa 

1. La carpeta vendor se ha quitado por su peso. para volver a tener ejecuta el comando "composer install" en la terminal de visual
   
2. crear la base de datos en mysql, ejecuta "CREATE DATABASE farmacia_hospitalaria;" en mysql

3. ejecuta el comando "php artisan migrate:fresh --seed", esto creara las tablas en la base de datos ademas de ingresar los resgistros de prueba.

4. para ingresar al login tienes que ingresar a "http://127.0.0.1:8000/login", luego haber ejecutado el comando "php artisan serve"
   
5. los datos para ingresar los pueden ver tanto en la bd como en los seeder de usuarios (database/seeders/UserSeeder.php)
   
6. ya hay hecho un layaout para que es con el que se trabajara por el momento, por estilo no se preocupen que luego se le ira dando.

7. por el momento el estilo del login esta meh, pero es para que puedan trabajar, durante la semana subire mi commit con los cambios.

8. por favor, respeten el orden de las carpetas.

9. si cambiaran algo de la bd, informenlo a todos y compartan las migraciones para poder trabajar con esos cambios.

NUEVO DATOS:

1. ya no hace falta que pongan http://127.0.0.1:8000/login, hoy automaticamente ingresa al login en caso de no estar logueado
y en caso de estarlo manda al dashboard del rol con que el que se haya iniciado sesion

2. en caso de ya tener las tablas del principio, no hace falta que ejecutes "php artisan migrate:fresh --seed"
para tener la nueva tabla estados y asi mismo agregar el nuevo campo a las demas tablas bastas con: "php artisan migrate" 

3. hay seeders con datos de las tablas, estados, categorias, areas y ubicaciones, basta con: "php artisan db:seed" (IMPORTANTE: en caso de tener
los datos de antes, comenta en el databaseseeder, el de roles y el de user)

4. la tabla estados, esta configurada para que al ingresar un nuevo registro, guarde en ese campo el estado 1, que seria "activo"

cualquier duda haganmela saber por favor
