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
    
  });

  // Instantiate our custom field's controller, defined above.
  new florpSubmitController();
}