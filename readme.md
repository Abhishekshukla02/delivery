
Steps for the execution of the project:

1. go to the project(delivery) dir from terminal

2. run the command “composer update

3. then run “php -S localhost:8000 -t public”

4. put the attached .env file in the root dir of project, and update database credentials

5. run “php artisan migrate”

5. use this “api_token” in the header for auth

api_token : p2lbgWkFrykA4QyUmpHihzmc5BNzIABq

For auth using api_token because once we will have register user can replace with jwt or other auths

6. I am also sending JSON file for APIs mockup, just import in to the postman, then you will

have all the APIs

Api URL: http://localhost:8000/api

