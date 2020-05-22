<p>
<a href="https://travis-ci.org/kunsal/taskee"><img src="https://travis-ci.com/kunsal/taskee.svg?branch=develop" alt="Build Status"></a>

</p>

# Taskee

A smart todo list app where a user can add tasks, view and mark them as complete. Built with PHP/Laravel, tested with PHPUnit and shipped with Docker. 

## Features

- User can register
- User can login
- User can add task
- User can view list of task
- User can update task due date
- User can mark task as completed or open

## Try it out

Follow the following guide to deploy and use this application.

- Ensure you have Docker installed on your system. Follow these links to install for [MAC](https://docs.docker.com/docker-for-mac/install) or [WINDOWS](https://docs.docker.com/docker-for-windows/install)

- Clone this app

- Navigate to project root `cd taskee`

- Run `docker-compose build` and wait for app to finish building

- Start up the services `docker-compose up -d`

- You need a database to run the application. Use these configurations in your `.env` file
    - DB_CONNECTION=mysql
    - DB_HOST=db 
    - DB_PORT=3306
    - MYSQL_DATABASENAME={your preferred db name}
    - DK_DB_USER={your preferred db user}
    - DK_DB_PSW={your preferred db password}
    
- Now we need to create the database by sshing into the db service. You will need the db user, db password and db name you specified above in the following steps

    - Run `docker-compose exec db bash`
    - Run $`mysql -u {your db user}` and provide your db password when prompted
    - Run $`CREATE DATABASE {your db name}`
    - Run `exit`

- Its time to run migration. So ssh into the app service
    - Run `docker-compose exec app bash`
    - Run `php artisan migrate`
    That's it. 
    
- Visit app in browser on {your-ip}:8088
  

## License

Taskee is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
