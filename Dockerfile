FROM nucle-x_php

WORKDIR /app

ADD ./laravel .

# RUN composer install

# FROM nucle-x_sso


CMD php artisan down

CMD php artisan cache:clear

CMD php artisan config:clear

CMD php artisan config:cache

CMD php artisan event:clear

CMD php artisan event:cache

CMD php artisan route:clear

CMD php artisan view:clear

CMD php artisan up

CMD php artisan serve --host=0.0.0.0:8000

EXPOSE 8000

# RUN php artisan migrate:fresh --seed
