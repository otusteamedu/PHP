FROM rabbitmq:3-management
RUN apt-get update
RUN apt-get install -y curl
