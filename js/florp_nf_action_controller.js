jQuery( document ).on( 'nfFormReady', function() {
  add_florp_submit_controller();
});

function add_florp_submit_controller() {
  var florpSubmitController = Marionette.Object.extend( {
    formModel: null,
    formID: 2,
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
          console.log("formModel wasn't set!");
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
      // Do stuff here.
      console.log(response);
      var errors = this.formModel.get( 'errors' );
      if (errors.length == 0) {
        console.log("Success");
        // response.data.fields_by_key -> use to login
//         var successMessageSpan = jQuery(".lwa-status.lwa-status-confirm");
//         var successMessage = successMessageSpan.html();
//         
//         // wait .1 sec before showing the success message //
//         setTimeout(function() {
//           successMessageSpan.html(successMessage + " " + data.loggingInMsg);
//           
//           // wait 3 sec before filling in the login form //
//           setTimeout(function() {
//             var idPrefix = form.data("idPrefix");
//             var loginForm = jQuery("form.lwa-form");
//             var loginUsernameInput = jQuery("#"+idPrefix+"lwa_user_login");
//             var loginPasswordInput = jQuery("#"+idPrefix+"lwa_user_pass");
//             if (idPrefix.length === 0) {
//               var cancelButton = jQuery(".lwa-links-register-inline-cancel.button");
//             }
//             var loginUsername = response.data.fields_by_key.user_name.value;
//             var loginPassword = response.data.fields_by_key.user_pass.value;
//             
//             loginUsernameInput.val(loginUsername);
//             loginPasswordInput.val(loginPassword);
//             
//             // hide registration form //
//             if (idPrefix.length === 0) {
//               cancelButton.click();
//             }
//             
//             // wait .1 sec before submitting the login form
//             setTimeout(function() {
//               // submit login form //
//               loginForm.submit();
//             }, 100);
//           }, 3000);
//         }, 100);
      }
    },
    
  });

  // Instantiate our custom field's controller, defined above.
  new florpSubmitController();
}