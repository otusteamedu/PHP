;(function() {
	'use strict';
	// подложка под всплывающее окно
var overlay	= document.querySelector('.overlay'),
	// коллекция всех элементов на странице, которые могут открывать всплывающие окна
	// их отличительной особенность является наличие атрибута '[data-modal]'
	mOpen	= document.querySelectorAll('[data-modal]'),
	// коллекция всех элементов на странице, которые могут закрывать всплывающие окна
	// их отличительной особенность является наличие атрибута '[data-close]'
	mClose	= document.querySelectorAll('[data-close]'),
	// родительский элемент всплывающих окон
	outer		= document.querySelector('.modal-outer'),
	// коллекция всплывающих окон
	modals		= document.querySelectorAll('.modal-outer > div'),
	// время анимации в ms
	duration	= 400,
	// флаг всплывающего окна: false - окно закрыто, true - открыто
	mStatus	= false;
 
	// если нет элементов управления всплывающими окнами, прекращаем работу скрипта
	if (mOpen.length == 0) return;

	[].forEach.call(mOpen, function(el) {
	// вешаем обработчик события на каждый элемент коллекции
		el.addEventListener('click', function(e) {
			// получаем значение атрибута ['data-modal'], которое
			// является id всплывающего окна
			var modalId	= el.getAttribute('data-modal'),
				// используя id, получаем объект всплывающего окна,
				// которое мы собираемся открыть
				modal	= document.getElementById(modalId);
	 
			// вызываем функцию открытия всплывающего окна, аргументом
			// является объект всплывающего окна
			modalShow(modal);
		});
	});


	[].forEach.call(mClose, function(el) {
		el.addEventListener('click', modalClose);
	});
	// Вешаем обработчик клавиатуры на закрытия окна 
	document.addEventListener('keydown', modalClose);

	function modalShow(modal) {
		mStatus = true;
		// показываем подложку
		overlay.classList.remove('fadeOut');
		overlay.classList.add('fadeIn');
		// делаем видимым выбранное всплывающее окно
		modal.style.display = 'block';
	 
			// время начала анимации
		var start		= new Date().getTime(),
			// начальное значение свойства 'top' - от него стартует анимация перемещения
			startTop	= outer.getBoundingClientRect().top,
			//конечное значение свойства 'top' - им заканчивается анимация
			finalTop	= (window.innerHeight - outer.offsetHeight) / 2,
			// расстояние, на которое переместиться <div> за время анимации 
			offset		= outer.offsetHeight + finalTop;
	 
		var fn = function() {
				// время, прошедшее с начала анимации
			var now		= new Date().getTime() - start,
				// текущее значение свойства 'top', рассчитанное
				// по формуле линейной анимации
				currTop	= Math.round(startTop + offset * now / duration);
			
			// не даём текущему значению 'top' превысить окончательное
			currTop = (currTop > finalTop) ? finalTop : currTop;
			outer.style.top = currTop + 'px';
	 
			// если текущее значение 'top' меньше окончательного, значит необходимо
			// продолжить анимацию и рекурсивно вызвать её функцию 'fn'
			if (currTop < finalTop) {
				requestAnimationFrame(fn);
			}
		}
		// первоначальный запуск функции анимации
		requestAnimationFrame(fn);
		window.addEventListener('resize', setTopOpenOuter);
	}

	function modalClose() {
		if (mStatus && ( !event.keyCode || event.keyCode === 27 ) ) {
			mStatus = false;
	 
			var start		= new Date().getTime(),
				startTop	= outer.getBoundingClientRect().top,
				// контейнер со всплывающими окнами должен полностью скрыться за верхней
				// границей окна браузера, соответственно свойство 'top' должно иметь
				// значение равное высоте контейнера, взятое с отрицательным знаком
				finalTop	= -outer.offsetHeight,
				// смещение контейнера за время анимации будет складывается из самой высоты
				// контейнера и величины отступа от верхней границы окна браузера
				// (см. рисунок выше) 
				offset		= outer.offsetHeight + (window.innerHeight - outer.offsetHeight) / 2;
	 
			var fn = function() {
				var now		= new Date().getTime() - start,
					currTop	= Math.round(startTop - offset * now / duration);
	 
				currTop = (currTop < finalTop) ? finalTop : currTop;
				outer.style.top = currTop + 'px';
	 
				if (currTop > finalTop) {
					requestAnimationFrame(fn);
				} else {
					overlay.classList.remove('fadeIn');
					overlay.classList.add('fadeOut');
					// перебираем по очереди все всплывающие окна и удаляем у них
					// атрибут 'style', значение которого делало окно видимым
					[].forEach.call(modals, function(modal){
						modal.removeAttribute('style');
					});
				}
			}
			requestAnimationFrame(fn);
		}
	 }

	function setTopOpenOuter() {
		// берётся половина разности между текущей высотой окна браузера
		// и родительским контейнером
		// результат будет являться значением свойства 'top' родительского элемента
		// всплывающих окон
		outer.style.top = (window.innerHeight - outer.offsetHeight) / 2 + 'px';
	}



})();




