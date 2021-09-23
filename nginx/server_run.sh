#!/usr/bin/env bash

envsubst '${APP_HOST}' < /etc/nginx/sites-available/app.template > /etc/nginx/conf.d/app.conf

nginx
