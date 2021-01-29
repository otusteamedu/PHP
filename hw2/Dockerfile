FROM debian

RUN apt-get update && apt-get install bc -y

WORKDIR '/home'

RUN mkdir -p /home/bscript

COPY cityRating.sh summa.sh citybd.txt /home/bscript/

RUN chmod a+x /home/bscript/*.sh