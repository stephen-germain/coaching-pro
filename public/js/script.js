// display animation
$(function(){

	$(window).scroll(function(){
		if($(window).scrollTop() > 350 && window.matchMedia('(min-width: 1200px)').matches){
			$('.about-animation').css('visibility', 'visible');
			$('.about-animation').addClass('animate__animated animate__fadeInUp');
			window.setTimeout(function(){
				$('.about-animation p').css('visibility', 'visible');
				$('.about-animation p').addClass('animate__animated animate__fadeInUp');
			},300);
		}
		if($(window).scrollTop() > 900 && window.matchMedia('(min-width: 1200px)').matches){
			$('#service .size-headband').css('visibility', 'visible');
			$('#service .size-headband').addClass('animate__animated animate__fadeInUp');
		}
		if($(window).scrollTop() > 1400 && window.matchMedia('(min-width: 1200px)').matches){
			$('.scale-img').css('visibility', 'visible');
			$('.scale-img').addClass('animate__animated animate__fadeInUp');
		
			window.setTimeout(function(){
				$('.card-img-overlay').css('visibility', 'visible');
				$('.card-img-overlay').addClass('animate__animated animate__fadeInUp');
			},200);	
		}
		if($(window).scrollTop() > 2300 && window.matchMedia('(min-width: 1200px)').matches){
			$('.size-headband2').css('visibility', 'visible');
			$('.size-headband2').addClass('animate__animated animate__fadeInUp');
		}
	})
})

