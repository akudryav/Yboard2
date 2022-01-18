(function (exports) {
    "use strict";
	
	var YL = function(param){
			"use strict";

		   if (param) {
			   return YL.variable[param] || false;
		   }
		   return this;
	   },
	   themeSetting = typeof exports.themeSetting === 'undefined' ? {} : exports.themeSetting,
	   $ = exports.jQuery,
	   bootstrap = exports.bootstrap;
   
	exports.YL = YL;
	
	YL.variable = {
		init: function () {
			this.header = document.querySelector('.header');
			this.stuck = document.querySelector('.header__content');
		},
		
		set: function (name, value) {
			this[name] = value;
		}
	};
  
  /**
	 * Polyfill
	 */
	YL.zombieBrowser = function () {
		// Check if browser supports document.querySelectorAll('body').forEach();
		if (window.NodeList && !NodeList.prototype.forEach) {
			NodeList.prototype.forEach = Array.prototype.forEach;
		}
		// Check if browser supports document.body.closest()
		if (Element.prototype && !Element.prototype.closest) {
			Element.prototype.matches = Element.prototype.matches || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector;
			Element.prototype.closest = Element.prototype.closest || function closest(selector) {
				if (!this) return null;
				if (this.matches(selector)) return this;
				if (!this.parentElement) return null;
				else return this.parentElement.closest(selector);
			};
		}
		// Check if browser supports array.includes()
		if (!Array.prototype.includes) {
			Object.defineProperty(Array.prototype, 'includes', {
				value: function(searchElement, fromIndex) {
					return this.indexOf(searchElement, fromIndex) > -1 ? true : false;
				}
			});
		}
		// Check if browser supports new CustomEvent()
		if (typeof CustomEvent !== "function") {
			function CustomEvent (event, params) {
				params = params || {bubbles: false, cancelable: false, detail: null};
				var evt = document.createEvent('CustomEvent');
				evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
				return evt;
			}
			
			window.CustomEvent = CustomEvent;
		}
		// Check if browser supports :scope natively
		// Thanks for https://stackoverflow.com/a/17989803
		try { 
			document.querySelector(':scope body');
		} catch (err) {
			['querySelector', 'querySelectorAll'].forEach(function(method) {
				var nativ = Element.prototype[method];
				Element.prototype[method] = function(selectors) {
					if (/(^|,)\s*:scope/.test(selectors)) {
						var id = this.id;
						this.id = 'ID_' + Date.now();
						selectors = selectors.replace(/((^|,)\s*):scope/g, '$1#' + this.id);
						var result = document[method](selectors);
						this.id = id;
						return result;
					} else {
						return nativ.call(this, selectors);
					}
				}
			});
		}
	};
  
  /**
	 * Создать и вызвать кастомное событие
	 * @param string name - event name
	 * @param mixed params - массив или объект с параметрами
	 * @param HTML Node el - объект на который нужно добавить событие (по умолчанию 'document')
	 */
	
	YL.dispatchEvent = function (name, params, el) {
		var event = new CustomEvent(name, {cancelable: true});
		if (params) {
			for (var i in params) {
				event[i] = params[i];
			}
		}
		(el || document).dispatchEvent(event);
	},
	
	/**
	 * Ширина окна браузера
	 * @returns float
	 */
	YL.windowWidth = function () {
		return window.innerWidth;
	};
	
	/**
	 * Высота окна браузера
	 * @returns float
	 */
	YL.windowHeight = function () {
		return window.innerHeight;
	};
	
	/**
	 * Get width element
	 * @param HTML Node element - объект
	 * @param boolean withMargin - return width with marginLeft and marginRight values
	 * @returns float
	 */
	YL.elementWidth = function (element, withMargin) {
		if (withMargin) {
			let styles	= getComputedStyle(element, null);
			return parseFloat(styles.width.replace("px", "")) + parseFloat(styles.marginLeft.replace("px", "")) + parseFloat(styles.marginRight.replace("px", ""));
		}
		return parseFloat(getComputedStyle(element, null).width.replace("px", ""));
	};
	
	/**
	 * Get height element
	 * @param HTML Node element - объект
	 * @param boolean withMargin - return width with marginLeft and marginRight values
	 * @returns float
	 */
	YL.elementHeight = function (element, withMargin) {
		if (withMargin) {
			let styles	= getComputedStyle(element, null);
			return parseFloat(styles.width.replace("px", "")) + parseFloat(styles.marginTop.replace("px", "")) + parseFloat(styles.marginBottom.replace("px", ""));
		}
		return parseFloat(getComputedStyle(element, null).height.replace("px", ""));
	};
	
	/**
	 * Получить позицию элемента с учётом скроллбара
	 * @param HTML Node element - объект, у которого проверяем аттрибут
	 * @returns mixed object
	 */
	YL.elementOffset = function (element) {
		let offset = element.getBoundingClientRect(),
			docElement = document.documentElement || document.body.parentNode;
		return {
			left: offset.left + (typeof docElement.scrollLeft === 'number' ? docElement : document.body).scrollLeft,
			top: offset.top + (typeof docElement.scrollTop === 'number' ? docElement : document.body).scrollTop
		};
	};
  
  /**
	 * Выполнение функции после загрузки страницы
	 * @param function func
	 */
	YL.ready = function(func) {
		let scope = this,
			args = arguments;
		if (document.readyState != 'loading'){
			func.apply(scope, Array.prototype.slice.call(args));
		} else {
			document.addEventListener('DOMContentLoaded', function () {
				func.apply(scope, Array.prototype.slice.call(args));
			});
		}
	}
  
  // Получить уникальный идентификатор
	YL.getRandId = function (prefix) {
		let randId = prefix + Math.floor(1 + Math.random() * 1000);
		return document.getElementById(randId) !== null ? YL.getRandId(prefix) : randId;
	};
  
  /**
	 * Получить аттрибут элемента
	 * @param HTML Node el - объект, у которого проверяем аттрибут
	 * @param string|boolean defaultValue - значение по умолчанию
	 * @returns string|boolean
	 */

	YL.getAttr = function (el, attr, defaultValue) {
		var value = el.getAttribute(attr) !== null ? el.getAttribute(attr) : defaultValue;
		if (value === 'false') {
			return false;
		} else if (value === 'true') {
			return true;
		} else if (parseInt(value) == value) { // '==' important
			return parseInt(value);
		} else {
			return value;
		}
	};
  
  YL.issetScroll = function () {
    let docElement = document.documentElement || document.body.parentNode;
    return docElement.clientHeight < document.body.clientHeight ? true : false;
  }
    
	//* Carousel
	YL.carousel = {
		carouselObj: [],
		init: function () {
			document.querySelectorAll("*[data-type='carousel']:not(.blockComposite)").forEach(function(el) {
				if (YL.getAttr(el, 'data-carousel-init', false) === true) return;
				el.setAttribute('data-carousel-init', true);

				var item = YL.getAttr(el, 'data-item', 4), // Кол-во элементов в одном слайде
					mediumShow = YL.getAttr(el, 'data-medium-count', 3), // -||-
					smallShow = YL.getAttr(el, 'data-small-count', 2), // -||-
					miniShow = YL.getAttr(el, 'data-mini-count', 1), // -||-
					dots = YL.getAttr(el, 'data-dots', false), // Current slide indicator dots
					arrows = YL.getAttr(el, 'data-controls', false), // Enable Next/Prev arrows
					infinite = YL.getAttr(el, 'data-infinite', false), // Бесконечный цикл
					speed = YL.getAttr(el, 'data-speed', 300), // Скорость пролистывания
					adaptiveHeight = YL.getAttr(el, 'data-adaptiveHeight', false), // Adapts slider height to the current slide
					pauseOnHover = YL.getAttr(el, 'data-pauseOnHover', true), // Пауза при наведении
					pauseOnDotsHover = YL.getAttr(el, 'data-pauseOnDotsHover', true), // -||-
					autoplay = YL.getAttr(el, 'data-autoplay', false), // Автопролистывание
					autoplaySpeed = YL.getAttr(el, 'data-autoplaySpeed', 5000), // Время показа слайда при автопролистывании
					fade = YL.getAttr(el, 'data-fade', false),
					vertical = YL.getAttr(el, 'data-vertical', false),
					verticalScrolling = YL.getAttr(el, 'data-verticalScrolling', false),
					variableWidth = YL.getAttr(el, 'data-variableWidth', false),
					slidesToScroll = YL.getAttr(el, 'data-slidesToScroll', 1),
					centerMode = YL.getAttr(el, 'data-centerMode', false),
					lazyLoad = YL.getAttr(el, 'data-lazyLoad', false); // !
				
				switch (themeSetting.carousel) {
					case 'swiper' : {
						let randId = YL.getRandId('swiper'),
							swiperOpt = {
								slidesPerView: miniShow,
								spaceBetween: 0,
								speed: speed,
								autoHeight: adaptiveHeight,
								loop: infinite,
								slidesPerGroup: miniShow,
								breakpoints: {
									1025: {
										slidesPerView: item,
										slidesPerGroup: item
									},
									791: {
										slidesPerView: mediumShow,
										slidesPerGroup: mediumShow
									},
									487: {
										slidesPerView: smallShow,
										slidesPerGroup: smallShow
									},
                  320: {
                    slidesPerView: miniShow,
										slidesPerGroup: miniShow
                  }
								},
								on: {
									init: function () {
										document.getElementById(randId).classList.add('carousel-initialized');
									},
								},
							},
							classObj = YL.getAttr(el, 'class', '');
						
						el.insertAdjacentHTML('beforebegin', '<div id="' + randId + '" class="carousel-container swiper-container ' + classObj + '"><div class="carousel-list swiper-list" id="' + randId + '_list"></div></div>');
						el.setAttribute('class', 'carousel-wrapper swiper-wrapper');
						for (var i = 0; i < el.childNodes.length; i++) {
							if (typeof el.childNodes[i].tagName !== 'undefined') {
								el.childNodes[i].classList.add('carousel-slide', 'swiper-slide');
							}
						}
						document.getElementById(randId + '_list').appendChild(el.parentElement.removeChild(el));
						
						if (arrows === true) {
							document.getElementById(randId).insertAdjacentHTML('beforeend', '<button type="button" class="carousel-button-prev carousel-arrow swiper-button-prev swiper-arrow" id="' + randId + '_prevBtn">Previous</button><button type="button" class="carousel-button-next carousel-arrow swiper-button-next swiper-arrow" id="' + randId + '_nextBtn">Next</button>');
							swiperOpt.navigation = {
								nextEl: document.getElementById(randId + '_nextBtn'),
								prevEl: document.getElementById(randId + '_prevBtn'),
							};
						}
						if (dots === true) {
							document.getElementById(randId).insertAdjacentHTML('beforeend', '<ul class="carousel-dots swiper-pagination" id="' + randId + '_dots"></ul>');
							swiperOpt.pagination = {
								el: document.getElementById(randId + '_dots'),
								type: 'bullets',
								bulletClass: 'carousel-dots-bullet',
								bulletActiveClass: 'carousel-dots-bullet-active',
								clickable: true,
								renderBullet: function (index, className) {
									return '<li class="' + className + '"><button type="button" data-role="none" role="button" tabindex="0">' + (index + 1) + '</button></li>';
								}
							};
						}
						if (lazyLoad !== false) {
							swiperOpt.lazy = {
								loadPrevNext: true
							};
						}
						if (autoplay !== false) {
							swiperOpt.autoplay = {
								delay: autoplaySpeed,
								disableOnInteraction: (pauseOnHover === true ? false : true)
							};
						}
						if (fade !== false) {
							document.getElementById(randId).classList.add('carousel-fade');
							swiperOpt.effect = 'fade';
							swiperOpt.fadeEffect = {
								crossFade: true
							};
						}
						if (vertical !== false) {
							document.getElementById(randId).classList.add('carousel-vertical');
							swiperOpt.direction = 'vertical';
						}
						
						YL.carousel.carouselObj[randId] = new Swiper('#' + randId + '_list', swiperOpt);
						break;
					}
					case 'jquery.slick': { // with jQuery
						if (typeof $ === 'undefined') {
							console.log('jQuery is not defined');
							return;
						}
						let randId = YL.getRandId('slick'),
							slickOpt = {
								dots: dots,
								dotsClass: 'carousel-dots slick-dots',
								arrows: arrows,
								infinite: infinite,
								autoplay: autoplay,
								autoplaySpeed: autoplaySpeed,
								fade: fade,
								speed: speed,
								slidesToShow: item,
								slidesToScroll: item,
								adaptiveHeight: adaptiveHeight,
								lazyLoad: lazyLoad,
								pauseOnHover: pauseOnHover,
								pauseOnDotsHover: pauseOnDotsHover,
								variableWidth: variableWidth,
                slidesToScroll: slidesToScroll,
                centerMode: centerMode,
								responsive: [{
									breakpoint: 1025,
									settings: {
										slidesToShow: mediumShow,
										slidesToScroll: mediumShow
									}
								},
								{
									breakpoint: 791,
									settings: {
										slidesToShow: smallShow,
										slidesToScroll: smallShow
									}
								},
								{
									breakpoint: 487,
									settings: {
										slidesToShow: miniShow,
										slidesToScroll: miniShow
									}
								}]
							};
						
						if (vertical !== false) {
							el.classList.add('carousel-vertical');
							slickOpt.vertical = vertical;
							slickOpt.verticalScrolling = verticalScrolling;
						}
						el.setAttribute('id', randId);
						$(el).on('init beforeChange', function (slick) {
							var element = document.getElementById(randId);
							element.classList.add('carousel-container', 'carousel-initialized');
							if (fade !== false) {
								element.classList.add('carousel-fade');
							}
							element.parentElement.querySelector('#' + randId + ' > .slick-list').classList.add('carousel-list');
							element.parentElement.querySelector('#' + randId + ' > .slick-list > .slick-track').classList.add('carousel-wrapper');
							element.parentElement.querySelector('#' + randId + ' > .slick-list > .slick-track > .slick-slide').classList.add('carousel-slide');
							if (slickOpt.arrows === true) {
                element.parentElement.querySelectorAll('#' + randId + ' > .slick-prev').forEach(function(element) {
                  element.classList.add('carousel-arrow', 'carousel-button-prev');
                });
                element.parentElement.querySelectorAll('#' + randId + ' > .slick-next').forEach(function(element) {
                  element.classList.add('carousel-arrow', 'carousel-button-next');
                });
							}
							if (slickOpt.dots === true) {
								var dots = element.parentElement.querySelector('#' + randId + ' > .carousel-dots');
								for (var i = 0; i < dots.childNodes.length; i++) {
									if (typeof dots.childNodes[i].tagName !== 'undefined') {
										if (dots.childNodes[i].classList.contains('slick-active') === true) {
											dots.childNodes[i].classList.add('carousel-dots-bullet-active');
										}
										dots.childNodes[i].classList.add('carousel-dots-bullet');
									}
								}
							}
						});
						if (slickOpt.dots === true) {
							$(el).on('afterChange', function (slick, currentSlide) {
								var dots = document.getElementById(randId).parentElement.querySelector('#' + randId + ' > .carousel-dots');
								for (var i = 0; i < dots.childNodes.length; i++) {
									if (typeof dots.childNodes[i].tagName !== 'undefined') {
										if (dots.childNodes[i].classList.contains('slick-active') === true) {
											dots.childNodes[i].classList.add('carousel-dots-bullet-active');
										} else {
											dots.childNodes[i].classList.remove('carousel-dots-bullet-active');
										}
									}
								}
							});
						}
						YL.carousel.carouselObj[randId] = $(el).slick(slickOpt);
						break;
					}
				}
			});
			
			YL.carousel.checkTab();
			YL.carousel.checkModal();
			YL.carousel.checkDropdown();
		},
		
		/**
		 * Перестроение слайдера
		 * @param HTML Node element - dom элемент слайдера, смотрите '.carousel-container'
		 */
		refresh: function(element) {
			switch (themeSetting.carousel) {
				case 'swiper' : {
					YL.carousel.carouselObj[element.getAttribute('id')].update();
					break;
				}

				default: {
					if (typeof $ === 'undefined') {
						console.log('jQuery is not defined');
						return;
					}
					$(element).slick("getSlick").refresh();
					$(element).trigger('init', [$(element).slick("getSlick")]);
					break;
				}
			}
		},
		
		/**
		 * Ищет слайдеры внутри элемента DOM и обновляет их.
		 * Для каждого элемента, переданного данной функции поиск производится только один раз.
		 * @param HTML Node element - dom элемент, в котором нужно произвести поиск и обновление слайдеров
		 */
		
		checkCarouselInEl: function (el) {
			if (el.classList.contains('bx-tocarousel-init') === true) return;
			el.classList.add('bx-tocarousel-init');
			
			el.querySelectorAll('.carousel-container').forEach(function(carouselElement) {
				console.log(carouselElement);
				YL.carousel.refresh(carouselElement);
			});
		},

		/**
		 * Перестроение слайдера при переключении табов
		 */

		checkTab: function() {
			document.querySelectorAll('[data-toggle="tab"]:not(.bx-tocarousel-init)').forEach(function(element) {
				let el = element;
				
				if (typeof bootstrap === 'undefined') {
					el.addEventListener('tab.show', function(e) {
						YL.carousel.checkTabEvent(el);
					});
				} else {
					if (typeof $ === 'undefined') {
						console.log('jQuery is not defined');
						return;
					}
					$(el).on('shown.bs.tab', function (e) {
						YL.carousel.checkTabEvent(el);
					});
				}
			});
		},
		
		/**
		 * Ищет слайдеры по кнопке переключения табов
		 * @param HTML Node element - dom элемент кнопки переключения табов
		 */
		
		checkTabEvent: function (el) {
			if (el.classList.contains('bx-tocarousel-init') === true) return;
			el.classList.add('bx-tocarousel-init');

			if (el.getAttribute('href') === null) {
				return;
			}
			let tabEl = document.getElementById(el.getAttribute('href').replace('#', ''));
			if (tabEl === null) {
				return;
			}
			
			tabEl.querySelectorAll('.carousel-container').forEach(function(carouselElement) {
				YL.carousel.refresh(carouselElement);
			});
		},

		/**
		 * Перестроение слайдера при открытии модального окна
		 */

		checkModal: function() {
      
		},

		/**
		 * Перестроение слайдера при открытии меню
		 */

		checkDropdown: function() {
			document.querySelectorAll('.dropdown-object:not(.bx-tocarousel-init)').forEach(function(element) {
				let el = element;
				
				el.addEventListener('dropdown.show', function(e) {
					YL.carousel.checkCarouselInEl(el);
				});
			});
		}
	};
  
  /**
	 * Шапка сайта
	 */

	YL.header = {
		isStuck: false,
		init: function () {
			YL.header.initStuck();
		},

		/**
		 * Плавающая шапка
		 */

		initStuck: function () {
			if (YL('stuck').classList.contains('disabled') === true) return;
			if (YL('stuck').classList.contains('YLInit') === true) return;
			YL('stuck').classList.add('YLInit');
			
			['scroll', 'resize'].forEach(function(eventName) {
				window.addEventListener(eventName, function (e) {
					if ((document.documentElement || document.body.parentNode).scrollTop > (YL.elementHeight(YL('header')) - YL.elementHeight(YL('stuck')))) {
						YL.header.showStuck();
					} else {
						YL.header.hideStuck();
					}
				});
			});
		},
		
		/**
		 * Плавающая шапка: показать
		 */
		
		showStuck: function () {
			if (YL('stuck').classList.contains('stuck') === true) return;
			YL.header.isStuck = true;
			YL('header').classList.add('isStuck');
			YL('stuck').classList.add('stuck');
		},
		
		/**
		 * Плавающая шапка: скрыть
		 * 
		 * @params boolean withNoClass - принудительно отменить плавающую шапку
		 */
		
		hideStuck: function (withNoClass) {
			if (YL('stuck').classList.contains('stuck') !== true && !withNoClass) return;
			YL.header.isStuck = false;
			YL('header').classList.remove('isStuck');
			YL('stuck').classList.remove('stuck');
		}
	};
  
  /**
	* Tabs (auto enable when not defined bootstrap js)
	*/
   
	YL.tabs = {
		init: function () {
			if (typeof bootstrap !== 'undefined') {
				return false;
			}
			document.querySelectorAll('[data-toggle="tab"]').forEach(function(element) {
				let el = element;
				
				if (el.getAttribute('data-tabs-init') === 'true'){
					return;
				}
				el.setAttribute('data-tabs-init', 'true');
				
				if (el.getAttribute('href') === null) {
					return;
				}
				let tabEl = document.getElementById(el.getAttribute('href').replace('#', ''));
				
				if (tabEl === null) {
					return;
				}
				
				el.addEventListener('click', function(e) {
					e.preventDefault();
					if (el.classList.contains('show') === true) return;
					el.closest('.nav, .list-group').querySelectorAll('[data-toggle="tab"]').forEach(function(element) {
						element.classList.remove('show', 'active');
					});
					el.classList.add('show', 'active');
					
					for (var i = 0; i < tabEl.parentNode.children.length; i++) {
						tabEl.parentNode.children[i].classList.remove('show', 'active');
					}
					tabEl.classList.add('show', 'active');
					YL.dispatchEvent('tab.show', {}, el);
				});
			});
		}
	};
  
  /**
	 * Menu
	 */

	YL.menu = {
    isSetEvent: false,
		init: function () {
      if (YL.menu.isSetEvent !== true) {
        YL.menu.setEvent();
      }
			
		},
    
    setEvent: function () {
      YL.menu.setEventOpenMenu();
      YL.menu.setEventHover();
    },
    setEventOpenMenu: function () {
      document.querySelectorAll('.header__categories_btn').forEach(function (element) {
				let el = element;
				if (el.getAttribute('data-categories-menu-init') === 'true') return;
				el.setAttribute('data-categories-menu-init', 'true');
				el.addEventListener('click', function (e) {
          e.preventDefault();
          let categoryEl = el.closest('.header__categories');
          if (categoryEl !== null) {
            categoryEl.classList.toggle('active');
            document.getElementById('mobileMenu').classList.toggle('active');
            setTimeout(() => {
              categoryEl.classList.toggle('show');
              document.getElementById('mobileMenu').classList.toggle('show');
            }, 50)
          }
				});
			});
    },
    setEventHover: function () {
      document.querySelectorAll('.categories-menu a').forEach(function (element) {
				let el = element;
				if (el.getAttribute('data-categories-menu-init') === 'true') return;
				el.setAttribute('data-categories-menu-init', 'true');
				el.addEventListener('mouseenter', function (e) {
					el.closest('ul').querySelectorAll(':scope > li').forEach(function(element) {
						element.classList.remove('active');
					});
					el.closest('li').classList.add('active');
				});
			});
    }
	};
  
  //* Mobile menu
	YL.mobileMenu = {
		init: function () {
			if (YL.windowWidth() <= 1024) {
				YL.mobileMenu.create();
				YL.mobileMenu.parse();
			} else {
				window.addEventListener('resize', function () {
					YL.mobileMenu.init();
				});
			}
		},
    
    create: function () {
      if (document.getElementById('mobileMenu') !== null) {
        let el = document.getElementById('mobileMenu'),
            menuEl = document.querySelector('ul.categories-menu__list');
        
        if (el.getAttribute('data-mobileMenuCreate-init') === 'true') return;
				el.setAttribute('data-mobileMenuCreate-init', 'true');
        
        el.insertAdjacentHTML('beforeend', menuEl.outerHTML);
        el.querySelector(':scope > ul').insertAdjacentHTML('afterbegin', '<li class="header-close">Категория</li>');
        el.querySelector('.header-close').addEventListener('click', function (e) {
          e.preventDefault();
          document.getElementById('mobileMenu').classList.remove('active');
          document.getElementById('mobileMenu').classList.remove('show');
        });
        
        YL.update();
      }
    },

		/*
		 * Открытие и закрытие меню разделов
		 */

		parse: function () {
			if (document.getElementById('mobileMenu') !== null) {	
				let el = document.getElementById('mobileMenu'),
            headerEl = document.getElementById('mobileMenuHeader');
					
				if (el.getAttribute('data-mobileMenu-init') === 'true') return;
				el.setAttribute('data-mobileMenu-init', 'true');

				el.querySelectorAll('li ul').forEach(function (ulEl) {
					let parentLinkEl = ulEl.parentNode.querySelector(':scope > a');
					if (parentLinkEl !== null) {
						ulEl.insertAdjacentHTML('afterbegin', '<li class="active-submenu-link">' + parentLinkEl.outerHTML + '</li>');
						parentLinkEl.classList.add('submenu-link');
						parentLinkEl.addEventListener('click', function (e) {
							e.preventDefault();
							ulEl.classList.add('active');
							setTimeout(function () {
								ulEl.parentNode.classList.add('list-active');
								ulEl.parentNode.parentNode.classList.add('sublist-active');
							}, 200);
						});
					}
					if (headerEl !== null) {
						ulEl.insertAdjacentHTML('afterbegin', '<li class="header-submenu">' + headerEl.outerHTML + '</li>');
						ulEl.querySelector(':scope > .header-submenu').addEventListener('click', function (e) {
							e.preventDefault();
							ulEl.parentNode.classList.remove('list-active');
							ulEl.parentNode.parentNode.classList.remove('sublist-active');
							setTimeout(function () {
								ulEl.classList.remove('active');
							}, 50);
						});
					}
				});
			}
		}
	};
  
  /*
   * Modal
   */
  
  YL.modal = {
    init: function () {
      document.querySelectorAll('[data-open-modal]').forEach(function (element) {
				let el = element;
				if (el.getAttribute('data-open-modal-init') === 'true') return;
				el.setAttribute('data-open-modal-init', 'true');
				el.addEventListener('click', function (e) {
					e.preventDefault();
          YL.modal.open(el.getAttribute('data-open-modal'));
				});
			});
    },
    
    open: function (id) {
      let el = document.getElementById(id);
      if (el !== null) {
        document.body.classList.add('modal-popup__body');
        if (YL.issetScroll() === true) {
          document.body.classList.add('modal-popup__body_scroll');
        }
        el.classList.add('show');
        document.querySelector('.modal-popup__bg').classList.add('show');
        el.querySelectorAll('.modal-popup__close, ._modal-popup__close').forEach(function (element) {
          element.addEventListener('click', function (e) {
            YL.modal.closeAll();
          });
        });
        
        YL.dispatchEvent('modal.Show', {
          el: el,
          modalId: id
        });
        
        return true;
      }
      
      return false;
    },
    
    closeAll: function () {
      document.body.classList.remove('modal-popup__body');
      document.body.classList.remove('modal-popup__body_scroll');
      document.querySelectorAll('.modal-popup').forEach(function (element) {
        element.classList.remove('show');
      });
      document.querySelector('.modal-popup__bg').classList.remove('show');
    }
  };
  
  // LazyLoad
	YL.lazyLoad = {
		init: function () {
			if (typeof LazyLoad === 'function') {
				new LazyLoad();
				new LazyLoad({
				   elements_selector: "iframe"
				});
				new LazyLoad({
				   elements_selector: "video"
				});
			}
		}
	};
  
  YL.requireScript = function (file, callback) {
    let script = document.createElement('script');
    script.src = file;
    script.type = 'text/javascript';
    if (typeof callback === 'function') {
      //real browsers
      script.onload = callback;
      //Internet explorer
      script.onreadystatechange = function() {
          if (this.readyState == 'complete') {
              callback();
          }
      }
    }
    document.head.appendChild(script);
  };
	
	YL.init = function (update) {
    // Polyfill
		if (!update) {
			YL.zombieBrowser();
		}
		//* Variables
		YL.variable.init();
		//* Header
		YL.header.init();
    //* LazyLoad
		YL.lazyLoad.init();
    // Timing in first init
		setTimeout(function () {
      //* Carousel
      YL.carousel.init();
      //* Menu
      YL.menu.init();
      //* Menu
      YL.mobileMenu.init();
      //* Modal
      YL.modal.init();
      //* Tabs
      YL.tabs.init();
    }, (update ? 0 : 100));
	};
	
	YL.update = function() {
		YL.init(true);
	};
	
	YL.ready(function() {
		YL.init();
	});
})(window);

var locationMap = null;
document.addEventListener('modal.Show', function (e) {
  if (e.modalId == 'location' && locationMap === null) {
    YL.requireScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU', () => {
      ymaps.ready(function(){     
        locationMap = new ymaps.Map("map_location", {
          center: [59.9340, 30.3091],
          zoom: 12,
          controls: []
        }, {
          searchControlProvider: 'yandex#search'
        });

        // Приближение и уменьшение
        locationMap.controls.add(new ymaps.control.ZoomControl());

        // Выбор какой тип карты показывать
        locationMap.controls.add('typeSelector');
      });
    });
  }
});