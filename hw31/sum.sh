#! /bin/bash
regex="^-?[0-9]+$"
if  ! [[ $1 =~ regex && $2 =~ regex ]]
then
	echo $(($1+$2))
else
	echo "Один из операндов не является числом."
fi

