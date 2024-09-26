FROM debian

RUN apt update && apt install bc -y

COPY sum.sh /usr/bin/sum

ENTRYPOINT ["sum"]
