#OTUS PHP-backend home works
##Home work 1
###1.1
To build an image

    docker build -t otus .
To run the container

    docker run --rm -p 8989:80 otus
    
###1.2
In progress...
##Home work 2
###2.1
    bash add.sh 2 6
###2.2
    awk 'NR>1 { print $3 }' db.txt | sort -k3 -t" " | uniq -c | sort -nr | head -n3

