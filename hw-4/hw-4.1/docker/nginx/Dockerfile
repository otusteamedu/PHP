FROM nginx:stable

RUN apt-get update && apt-get install nano

ARG UID

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app
