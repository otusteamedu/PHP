#!/bin/bash
# установка корневого сертификата и сертификатов для этих сайтов:
# application.loc
# otus.loc
# valyakin.loc
dir=$(dirname $0)
echo Устанавливается корневой сертификат...
 ${dir}/certificate/create_root_ca.sh
echo Устанавливается сертификат для сайта application.loc...
 ${dir}/certificate/create_certificate_for_domain.sh application.loc
echo Устанавливается сертификат для сайта otus.loc...
 ${dir}/certificate/create_certificate_for_domain.sh otus.loc
echo Устанавливается сертификат для сайта valyakin.loc...
 ${dir}/certificate/create_certificate_for_domain.sh valyakin.loc
echo Установка сертификатов завершена!
