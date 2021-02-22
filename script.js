$('#email').focus(function(){
  $(this).attr('placeholder','');
});
$('#email').focusout(function(){
  $(this).attr('placeholder','xyz@email.com');
});
$('#email2').focus(function(){
  $(this).attr('placeholder','');
});
$('#email2').focusout(function(){
  $(this).attr('placeholder','xyz@email.com');
});



$(document).ready(function(){
  $(window).scroll(function(){
  if($(window).scrollTop() > 60 ){
  $('.my-navbar').addClass('navbar-scroll');
 

  }
  else{
  $('.my-navbar').removeClass('navbar-scroll');

  }
  });
  });


var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}





