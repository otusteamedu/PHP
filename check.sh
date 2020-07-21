#!/bin/bash

. ./paths.sh
cd $SITES_TO_DEPLOY

for DIR in $(find . -mindepth 1 -maxdepth 1 -type d  \( ! -iname '.*' \))
do
	DEV=0
	TEST=0
    cd $SITES_TO_DEPLOY/$DIR
	
	echo -e "\nСмотрим папку $DIR"
	
	for SUBDIR in $(find . -mindepth 1 -maxdepth 1 -type d  \( ! -iname '.*' \))
	do
		if [ -e $SUBDIR/1 ]; then
			echo -e "\nЕсть отметка о том, что нужно сделать деплой $SUBDIR версии"
			rm $SUBDIR/1
			touch $SUBDIR/0
			
			if [[ "$SUBDIR" == *dev* ]]; then
				DEV=1
			fi
			if [[ "$SUBDIR" == *test* ]]; then
				TEST=1
			fi
		fi
	
	done
	
	if [[ "$DEV" == 1 ]]; then
		echo -e "\ncd $WWW_ROOT/$DIR/config && ./deploy.sh -di"
		cd $WWW_ROOT/$DIR/config && ./deploy.sh -di
	fi
	if [[ "$TEST" == 1 ]]; then
		echo -e "\ncd $WWW_ROOT/$DIR/config && ./deploy.sh -ti"
		cd $WWW_ROOT/$DIR/config && ./deploy.sh -ti
	fi
done