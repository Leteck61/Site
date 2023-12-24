$(function () {

  // On met une animation au click sur les liens internes 
  $(".navbar a, footer a").on("click", function (event) {
      event.preventDefault();
      var hash = this.hash;

      $("body,html").animate({
          scrollTop: $(hash).offset().top
      }, 200, function () {
          window.location.hash = hash;
      })
  });

  // Pour les smartphones au click sur un lien du menu : on referme le menu
  $('.navbar-nav>li>a').on('click', function () {
      $('.navbar-collapse').collapse('hide');
  });

  // Activation de tous les tooltips
  $('[data-toggle="tooltip"]').tooltip();

  // Affichage des recommandations entières
  $(".carousel-item").click(function () {

      var carousel = $("#myCarousel");
      var currentIndexSlide = $(this).index();
      var fullRecommandation = $("#full_recommandation div")[currentIndexSlide];

      if (fullRecommandation.classList.contains('hidden')) {
          carousel.addClass('visuallyhidden');
          carousel.addClass('hidden');
          fullRecommandation.classList.remove('hidden');
          setTimeout(function () {
              fullRecommandation.classList.remove('visuallyhidden');
          }, 20);
      }

      fullRecommandation.addEventListener('click', function () {
          fullRecommandation.classList.add('visuallyhidden');
          fullRecommandation.classList.add('hidden');
          carousel.removeClass('hidden');
          setTimeout(function () {
              carousel.removeClass('visuallyhidden');
          }, 20);
      });

  });

  $("#contact-form").submit(function (e) {
      e.preventDefault();
      $(".comments").empty();
      var postdata = $("#contact-form").serialize();

      $.ajax({
          type: "POST",
          url: "../php/contact.php",
          data: postdata,
          dataType: "json",
          success: function (result) {
              if (result.isSuccess) {
                  $("#contact-form").append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                  $("#contact-form")[0].reset();
              } else {
                  $("#firstname + .comments").html(result.firstnameError);
                  $("#name + .comments").html(result.nameError);
                  $("#email + .comments").html(result.emailError);
                  $("#phone + .comments").html(result.phoneError);
                  $("#message + .comments").html(result.messageError);
              }
          }
      });
  });



  var btn = $(".btn");
  
  btn.on("click", function() {
    
    $(this).addClass('btn-progress');
    setTimeout(function() {
      btn.addClass('btn-fill')
    }, 500);
    
    setTimeout(function() {
      btn.removeClass('btn-fill')
    }, 4100);
    
    setTimeout(function() {
      btn.addClass('btn-complete')
    }, 4100);
  
  });

});