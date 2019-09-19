#!/bin/bash
function outHelp {
    echo ""
    echo "СЛОЖЕНИЕ ДВУХ И БОЛЕЕ ЧИСЕЛ"
    echo ""
    echo "Использование: $0 [arg1 arg2 [... argN]]"
    echo "    arg1...argN должны быть целыми или числами с плавающей точкой."
    echo ""
    echo "При запуске без параметров запрашивает два слагаемых интеррактивно."
    echo ""
    echo "Примеры использования:"
    echo "    $0 6 -2.6"
    echo "    $0 -4.23 62 5.3 -10 4.601"
    echo ""
}

re='^-?[0-9]+\.?[0-9]*$'

if [ $# -eq 0 ]
then
    outHelp

    inputMessages=("Введите первое слагаемое: " "Введите второе слагаемое: ")

    for (( i = 0; i < ${#inputMessages[*]}; i++ ))
    do
        read -p "${inputMessages[$i]}" value
        
        if [[ ! $value =~ $re ]]
        then
            echo "Введённое не является числом"
            exit 1
        fi
        
        if [ $i -eq 0 ]
        then
            expression="$value"
        else
            expression="$expression+$value"
        fi
    done
    
    echo "$expression" | awk -F'+' '{sum = $1 + $2} {print $1 " + " $2 " = " sum}'
    
elif [ $# -eq 1 ]
then
    outHelp
    exit 1
    
else
    i=1
    for value in "$@"
    do
        if [[ ! $value =~ $re ]]
        then
            echo "$value не является числом"
            exit 1
        fi
        
        if [ $i -eq 1 ]
        then
            expression1="$value"
            expression2="\$$i"
            expression3="\$$i"
            i=2
        else
            expression1="$expression1+$value"
            expression2="$expression2 + \$$i"
            expression3="$expression3 \" + \" \$$i"
            
            i=$(( $i + 1 ))
        fi
    done
    
    scriptName="calc-tmp-$RANDOM.sh"
    echo "#!/bin/bash" >$scriptName
    echo "echo \"$expression1\" | awk -F'+' '{sum = $expression2} {print $expression3\" = \" sum}'" >>$scriptName
    chmod 744 $scriptName
    ./$scriptName
    rm $scriptName
fi
