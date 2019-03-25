#!/bin/bash

if ! [[ $1 =~ ^[[:digit:]]+$ ]]; then
    echo -e "Argument is not a valid number\n" >&2
    exit 1
fi

cities=(Moscow Saint-P Tver Milan Perm Madrid Krasnodar Ekaterinburg London Canberra)

randomInt() {
    echo $(( RANDOM % 10 ))
}

echo -e 'id\tuser\tcity\tphone' > db.tsv
for (( id=1; id<=$1; id++ )); do
    userId=($(randomInt) + 1 )
    cityId=$(randomInt)
    phone=''
    for (( i=0; i<=9; i++ )); do
        phone=$phone$(randomInt)
    done
    echo -e "$id\ttest$userId\t${cities[$cityId]}\t$phone" >> db.tsv
done
