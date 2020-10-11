#!/bin/bash
#скрипт для сложения 2 чисел (вещественных)
#баш не поддерживает вещественные числа
#За разделитель целой и  дробной части принята .
#Идея: Перевести числа в целые (если нужно)  с учетом возможного различного количество знаков  дробной части
#      Сложить и  вставить в  результат разделитель .

f=${1};
s=${2};
a=0
b=0
IFS='.';
regex='^[+-]?[0-9]+([.][0-9]+)?$';

if [[ "$f" =~ $regex ]] && [[ "$s" =~ $regex ]]; then
	read -ra ARR <<< "$f"
	d=${ARR[1]}
	if [[ -z "$d" ]]; then
		d=0
	fi


	if (($d>0)); then
		let a=${#d};
 		f=${ARR[0]}${ARR[1]};
	fi;
        read -ra ARR <<< "$s";
        d=${ARR[1]};
        if [[ -z "$d" ]]; then
                d=0
        fi


       if (($d>0)); then
                let b=${#d};
                s=${ARR[0]}${ARR[1]};
        fi

	max=$(( $a > $b ? $a : $b ));

	if (($max>0)); then
		let f=$f*10**$(($max-$a));
        	let s=$s*10**$(($max-$b));
	fi

	let "out = f + s";

        if (($max>0)); then
		let k=${#out};
		let x=${out:0:k-max};
		let y=${out:k-max:max};
		out=$x.$y;
	fi

	echo "$out";
	else
	echo "Не корректные значения" 
fi
