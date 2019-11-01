.PHONY: build build-app build-nginx docker-login docker-push docker-pull
.DEFAULT: build

TAG    := dev

APP_NAME   := gcr.io/generic-website-hosting/echo-chamber-app
APP_IMG    := ${APP_NAME}:${TAG}
APP_LATEST := ${APP_NAME}:latest

NGINX_NAME   := gcr.io/generic-website-hosting/echo-chamber-nginx
NGINX_IMG    := ${NGINX_NAME}:${TAG}
NGINX_LATEST := ${NGINX_NAME}:latest

build: build-app build-nginx

build-app: build-composer
	@DOCKER_BUILDKIT=1 docker build \
	--ssh default \
	-t ${APP_IMG} \
	-f tools/docker/app.docker .
	@docker tag ${APP_IMG} ${APP_LATEST}

build-nginx: build-npm
	@DOCKER_BUILDKIT=1 docker build \
	-t ${NGINX_IMG} \
	-f tools/docker/nginx.docker .
	@docker tag ${NGINX_IMG} ${NGINX_LATEST}

build-composer:
	@DOCKER_BUILDKIT=1 docker build \
	--ssh default \
	-t echo-chamber-app-composer:latest \
	-f tools/docker/app-composer.docker .

build-npm:
	@DOCKER_BUILDKIT=1 docker build \
	--ssh default \
	-t echo-chamber-app-npm:latest \
	-f tools/docker/app-npm.docker .

docker-login:
	@docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}

push:
	@docker push ${APP_NAME}
	@docker push ${NGINX_NAME}

pull:
	@docker pull ${APP_IMG}
	@docker pull ${NGINX_IMG}
