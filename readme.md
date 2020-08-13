### Тестовый результат
    - src/Otus/PatternsAlgorithms/run-cli-output.txt
    - запустить скрипт `php src/Otus/PatternsAlgorithms/run-cli.php`
    
### Использованные паттерны
	- Strategy (GoF)
	- Information Expert, Polymorphism (GRASP)

### Uml диаграмма
 - src/Otus/PatternsAlgorithms/uml-diagram.png
 - сгенерировать диаграмму: `vendor/bin/phuml phuml:diagram -r -a -p dot src/Otus/PatternsAlgorithms/ uml-diagram.png`

### Установка
Необходим vagrant и ansible.
    
    `ansible-playbook -i  server_setup/ansible/hosts.ini server_setup/ansible/setup-playbook.yml`