document.addEventListener('DOMContentLoaded',function(){
	var menuButton=document.querySelector('.atelier-menu-toggle');
	var nav=document.querySelector('.atelier-nav');
	var productsButton=document.querySelector('.atelier-products-toggle');
	var productsPanel=document.querySelector('.atelier-products-panel');

	function setMenu(open){
		if(!menuButton||!nav){return;}
		nav.classList.toggle('is-open',open);
		menuButton.setAttribute('aria-expanded',open?'true':'false');
	}
	function setProducts(open){
		if(!productsButton||!productsPanel){return;}
		productsButton.setAttribute('aria-expanded',open?'true':'false');
		productsPanel.hidden=!open;
		document.body.classList.toggle('atelier-mega-open',open);
	}
	if(menuButton&&nav){
		menuButton.addEventListener('click',function(event){
			event.stopPropagation();
			var open=menuButton.getAttribute('aria-expanded')!=='true';
			setProducts(false);
			setMenu(open);
		});
	}
	if(productsButton&&productsPanel){
		productsButton.addEventListener('click',function(event){
			event.stopPropagation();
			var open=productsButton.getAttribute('aria-expanded')!=='true';
			setMenu(false);
			setProducts(open);
		});
		productsPanel.addEventListener('click',function(event){event.stopPropagation();});
	}
	document.addEventListener('click',function(){setMenu(false);setProducts(false);});
	document.addEventListener('keydown',function(event){
		if(event.key==='Escape'){
			setMenu(false);
			setProducts(false);
		}
	});

	document.querySelectorAll('[data-atelier-slider]').forEach(function(slider){
		var slides=Array.prototype.slice.call(slider.querySelectorAll('.atelier-slide'));
		var dots=Array.prototype.slice.call(slider.querySelectorAll('.atelier-slider-dots button'));
		var prev=slider.querySelector('.atelier-slider-prev');
		var next=slider.querySelector('.atelier-slider-next');
		var pause=slider.querySelector('.atelier-slider-pause');
		if(slides.length<2){return;}
		var current=0;
		var paused=false;
		var interval=Math.max(3000,parseInt(slider.getAttribute('data-interval'),10)||5000);
		var timer;
		function show(index){
			current=(index+slides.length)%slides.length;
			slides.forEach(function(slide,i){
				var active=i===current;
				slide.classList.toggle('is-active',active);
				slide.setAttribute('aria-hidden',active?'false':'true');
			});
			dots.forEach(function(dot,i){
				var active=i===current;
				dot.classList.toggle('is-active',active);
				dot.setAttribute('aria-selected',active?'true':'false');
			});
		}
		function start(){
			window.clearInterval(timer);
			if(!paused){timer=window.setInterval(function(){show(current+1);},interval);}
		}
		if(prev){prev.addEventListener('click',function(){show(current-1);start();});}
		if(next){next.addEventListener('click',function(){show(current+1);start();});}
		dots.forEach(function(dot,i){dot.addEventListener('click',function(){show(i);start();});});
		if(pause){
			pause.addEventListener('click',function(){
				paused=!paused;
				pause.setAttribute('aria-pressed',paused?'true':'false');
				pause.querySelector('.atelier-pause-label').textContent=paused?'Riprendi':'Pausa';
				start();
			});
		}
		slider.addEventListener('mouseenter',function(){window.clearInterval(timer);});
		slider.addEventListener('mouseleave',start);
		slider.addEventListener('focusin',function(){window.clearInterval(timer);});
		slider.addEventListener('focusout',start);
		start();
	});
});