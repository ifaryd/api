<section id="contacts" class="sections contact-1s" >
    
    <div class="contact-wrapper">
      <!-- Map -->
     
     <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15881.249412620044!2d-4.580225970505733!3d5.667896487129959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc058339b3e6993%3A0x83061b2c38f23a49!2sSikensi!5e0!3m2!1sfr!2sci!4v1674264676700!5m2!1sfr!2sci" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->

     
      <div class="container">
        <div class="row ws-m">
          
        </div>
        
        <!-- Contact Form -->
        
        <div class="row">
          <form id="contact-form-1" class="form-ajax">
            @csrf
            <div class="col-md-offset-2 col-md-4 wow fadeInUp" data-wow-duration="1s">

              <!-- Name -->
              
              <div class="form-group">
                <input type="text" name="name" id="name" class="form-control validate-locally" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.nom')}}">
                <label for="name">{!! nl2br(__('app.contact.nom')) !!}</label>
                <span class="pull-right alert-error"></span>
              </div>

              <!-- Email -->
              <div class="form-group">
                <input type="email" name="email" id="email" class="form-control validate-locally" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.email')}}">
                <label for="email">{!! nl2br(__('app.contact.email')) !!}</label>
                <span class="pull-right alert-error"></span>
              </div>

            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-duration="1s">

              <!-- Message -->
              <div class="form-group">
                <textarea name="message" id="message" class="form-control" rows="5" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.message')}}"></textarea>
                <label for="message">{{__('app.contact.message')}}</label>
              </div>
              <div>
                <div id="notification" class="row w-full"></div>
                <input id="wait" style="display: none;" value="{{__('app.contact.wait')}}">
                <input id="send" style="display: none;" value="{{__('app.contact.envoyer')}}">
                <input id="sendShow" type="submit" class="btn pull-right" value="{{__('app.contact.envoyer')}}">
              </div>

              <!-- Ajax Message -->
              <div class="ajax-message col-md-12 no-gap" ></div>

            </div><!-- / .col-md-4 -->

          </form>
        </div><!-- / .row -->
      </div><!-- / .container -->
    </div><!-- / .contact-wrapper -->
  </section><!-- / .contact-1 -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          // Set up CSRF token for AJAX requests
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $('.form-ajax').on('submit', function(e) {
              e.preventDefault();

              let name = $('#name').val();
              let email = $('#email').val();
              let message = $('#message').val();
              $('input#sendShow').val($('input#wait').val())
              if(!name || !email || !message){
                $('#notification').notify("Veuillez remplir tous les champs!", 'error', { position:"right" ,autoHideDelay: 10000});
                $('input#sendShow').val($('input#send').val())
                return 
              }
              if(message.length<20){
                $('#notification').notify("Votre message doit contenir au moins 20 caractères!", 'error', { position:"right" ,autoHideDelay: 10000});
                $('input#sendShow').val($('input#send').val())
                return
              }
              $.ajax({
                  url: "/sendEmail",
                  type: 'POST',
                  data: {name, email,message},
                  success: function(response) {
                    console.log(response, "contact response")
                      if(response.success) {
                        $('#notification').notify("Votre message a été envoyé avec succès et sera traité avant 24h!", 'success', { position:"right" ,autoHideDelay: 10000});
                          $('#form-ajax').trigger("reset");
                          $('#name').val("");
                          $('#email').val("");
                          $('#message').val("");
                          
                      } else {
                          $('#notification').notify("Impossible d'envoyer votre message, veuillez rééssayer plutard!", 'error', { position:"right" ,autoHideDelay: 10000});
                      }
                      $('input#sendShow').val($('input#send').val())
                  },
                  error: function(xhr) {
                      let errors = xhr.responseJSON;
                      console.log(errors)
                      $('#notification').notify(errors.message, 'error', { position:"right" ,autoHideDelay: 10000});
                      $('input#sendShow').val($('input#send').val())
                  }
              });
          });
      });
  </script>