FROM nginx

# add nginx user to new group for sockets
RUN addgroup --gid 3000 --system app && \
    adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app && \
    usermod -a -G app nginx