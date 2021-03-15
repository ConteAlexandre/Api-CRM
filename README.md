# Api-CRM

### Recover the depot with git
* SSH : git clone git@github.com:ConteAlexandre/Api-CRM.git
* HTTPS : git clone https://github.com/ConteAlexandre/Api-CRM.git

### First step
* Tap the command:
```
composer install
```

### Second step
* Create the file .env.local
* Copy the content .env in .env.local

### Third step
* Change the DATABASE_URL with the good ID
* And write command:
```
./bin/console d:d:c
or
php bin/console d:d:c
```

### Four step
Update your database with entity with this command
```
./bin/console d:s:u --force
or
php bin/console d:s:u --force
```

### Five step
Load fixtures in the database with this command
```
./bin/console d:f:l
or
php bin/console d:f:l
```

### Six step
Run the application with this command
```
php -S localhost:8000 -t public
```
