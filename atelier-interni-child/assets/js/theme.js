document.addEventListener('DOMContentLoaded',function(){
	var menuButton=document.querySelector('.atelier-menu-toggle');
	var nav=document.querySelector('.atelier-nav');
	if(menuButton&&nav){
		menuButton.addEventListener('click',function(){
			var open=nav.classList.toggle('is-open');
			menuButton.setAttribute('aria-expanded',open?'true':'false');
		});
	}
	var productsButton=document.querySelector('.atelier-products-toggle');
	var productsPanel=document.querySelector('.atelier-products-panel');
	if(!productsButton||!productsPanel){return;}
	function setProducts(open){
		productsButton.setAttribute('aria-expanded',open?'true':'false');
		productsPanel.hidden=!open;
		document.body.classList.toggle('atelier-mega-open',open);
	}
	productsButton.addEventListener('click',function(event){
		event.stopPropagation();
		setProducts(productsButton.getAttribute('aria-expanded')!=='true');
	});
	productsPanel.addEventListener('click',function(event){event.stopPropagation();});
	document.addEventListener('click',function(){setProducts(false);});
	document.addEventListener('keydown',function(event){
		if(event.key==='Escape'){setProducts(false);productsButton.focus();}
	});
});