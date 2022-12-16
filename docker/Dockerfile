FROM node as doc-builder

RUN npm install -g redoc-cli
COPY ./docs /docs
WORKDIR /docs
RUN redoc-cli build api.yml --output docs.html

FROM app-image

COPY .  /var/www/html
COPY --from=doc-builder /docs/docs.html /var/www/html/public/docs.html
USER root
RUN chown -R web:web /var/www/html
USER web

RUN composer install --optimize-autoloader --no-interaction --no-progress

#RUN php artisan vendor:publish
RUN php artisan storage:link
