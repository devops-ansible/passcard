ARG IMAGE=devopsansiblede/apache
ARG VERSION=latest

FROM $IMAGE:$VERSION

MAINTAINER macwinnie <dev@macwinnie.me>

# copy all relevant files
COPY app/ /var/www/html/

# run on every (re)start of container
ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]
