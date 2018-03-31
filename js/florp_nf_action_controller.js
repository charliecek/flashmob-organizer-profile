jQuery( document ).on( 'nfFormReady', function() {
  add_florp_submit_controller();
});

function add_florp_submit_controller() {
  var florpSubmitController = Marionette.Object.extend( {
    formModel: null,
    formID: florp.form_id || 2,
    initialize: function() {
      // On the Form Submission's field validaiton...
      var submitChannel = Backbone.Radio.channel( 'submit' );
      this.listenTo( submitChannel, 'validate:field', this.validateSubmit);
      this.listenTo( Backbone.Radio.channel( 'forms' ), 'submit:response', this.actionSubmit );

      // other validation types: http://developer.ninjaforms.com/codex/client-side-field-validation/
    },

    validateSubmit: function( model ) {
      jQuery(".nf-response-msg").children().remove()

      if (this.formModel === null || typeof this.formModel === "undefined") {
        this.formModel = nfRadio.channel( 'app' ).request( 'get:form', this.formID );
        if (this.formModel === null || typeof this.formModel === "undefined") {
          console.warn("formModel wasn't set (is this the right form?)");
          return;
        }
      }

      var errors = this.formModel.get( 'errors' );
      if (errors.length > 0) {
        for (var i in errors.models) {
          var error = errors.models[i];
          var model_id = model.get('id');
          var error_id = error.get('id');
          this.formModel.removeError(error_id);
        }
      }
    },

     actionSubmit: function( response ) {
      if (response.data.form_id != this.formID) {
        console.info("This is not form with ID="+this.formID);
        return;
      }
      if ("undefined" === typeof florp || "undefined" !== typeof florp.user_id || florp.user_id > 0) {
        console.info("This is not the registration form");
        return;
      }
      var errorCount = 0;
      if ("undefined" === typeof response.errors.length) {
        if ("undefined" === typeof this.formModel) {
          var i;

          for (i in response.errors) {
            if (response.errors.hasOwnProperty(i)) {
              errorCount++;
            }
          }
        } else {
          var errors = this.formModel.get( 'errors' );
          errorCount = errors.length;
        }
      } else {
        errorCount = response.errors.length;
      }
      if (errorCount == 0) {
        // response.data.fields_by_key -> use to login
        var successMessageSpan = jQuery(".florp_success_message");
        var successMessage = successMessageSpan.html();

        // wait .1 sec before showing the success message //
        setTimeout(function() {
          successMessageSpan.html(successMessage + " " + florp.logging_in_msg);

          // wait 2 sec before filling in the login form //
          setTimeout(function() {
            var form = jQuery("#pum-"+florp.popup_id+" .lwa");
            var idPrefix = form.data("idPrefix");
            var loginForm = jQuery("#pum-"+florp.popup_id+" form.lwa-form");
            var loginUsernameInput = jQuery("#pum-"+florp.popup_id+" #"+idPrefix+"lwa_user_login");
            var loginPasswordInput = jQuery("#pum-"+florp.popup_id+" #"+idPrefix+"lwa_user_pass");
            var loginUsername = response.data.fields_by_key.user_login.value;
            var loginPassword = response.data.fields_by_key.user_pass.value;

            loginUsernameInput.val(loginUsername);
            loginPasswordInput.val(loginPassword);

            florp.doNotSetCookie = true;

            // hide registration form //
            jQuery("#pum-"+florp.popup_id+" .lwa-register").hide('slow');
            loginForm.show('slow');

            // wait .5 sec before submitting the login form
            setTimeout(function() {
              // submit login form //
              loginForm.submit();
            }, 500);
          }, 2000);
        }, 100);
      }
    },
  });

  // Instantiate our custom field's controller, defined above.
  new florpSubmitController();
}
