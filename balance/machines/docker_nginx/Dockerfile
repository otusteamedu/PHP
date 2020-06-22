FROM nginx:latest 

RUN addgroup --gid 3000 --system app
RUN adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app

RUN adduser --uid 3001 --system --disabled-login --disabled-password --gid 3000 app2