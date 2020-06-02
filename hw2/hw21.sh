#!/bin/bash
a=""
b=""
regexp="^(0|-?(((0|[1-9][0-9]*)[.,][0-9]*[1-9])|[1-9][0-9]*))$"

until [[ $a =~ $regexp ]] ; do
    read -p 'Операнд "a" [enter]: ' a
done

until [[ $b =~ $regexp ]] ; do
    read -p 'Операнд "b" [enter]: ' b
done

echo $a $b | awk '{print "a + b = ",gensub(/[,]/,".","g",$1)+gensub(/[,]/,".","g",$2)}'
