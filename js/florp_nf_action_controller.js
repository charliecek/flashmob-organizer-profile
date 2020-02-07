jQuery(document).on('nfFormReady', function () {
    add_florp_action_controllers()
})

function add_florp_action_controllers() {
    var florpRecaptchaOnlyLoggedOutController = Marionette.Object.extend({
        initialize: function () {
            var $elements = jQuery('.recaptcha_logged-out-only-container .g-recaptcha')
            $elements.each(function () {
                var $this = jQuery(this)
                var fnCallback = $this.data("callback")
                var fieldID = $this.data('fieldid')
                window[fnCallback] = function (response) {
                    var field = nfRadio.channel("fields").request("get:field", fieldID)
                    field.set("value", response),
                        nfRadio.channel("fields").request("remove:error", field.get("id"), "required-error")
                }
            })
            this.listenTo(nfRadio.channel("forms"), "submit:response", this.resetRecaptchaOLO)
        },
        resetRecaptchaOLO: function () {
            // console.info("Recaptcha reset")
            var e = 0
            jQuery(".g-recaptcha").each(function () {
                try {
                    grecaptcha.reset(e)
                } catch (e) {
                    console.warn("Notice: Error trying to reset grecaptcha.")
                }
                e++
            })
        }
    })

    // Instantiate //
    new florpRecaptchaOnlyLoggedOutController()

    var florpSubmitController = Marionette.Object.extend({
        formModel: null,
        initialize: function () {
            // On the Form Submission's field validaiton...
            var submitChannel = Backbone.Radio.channel('submit')
            this.listenTo(submitChannel, 'validate:field', this.validateSubmit)
            this.listenTo(Backbone.Radio.channel('forms'), 'submit:response', this.actionSubmit)

            // other validation types: http://developer.ninjaforms.com/codex/client-side-field-validation/
        },

        validateSubmit: function (model) {
            var formID = model.attributes.formID
            if (formID != florp.form_id_main && formID != florp.form_id_flashmob && formID != florp.form_id_intf) {
                console.info("This is not a FLORP form")
                return
            }
            jQuery(".nf-response-msg").children().remove()

            if (this.formModel === null || typeof this.formModel === "undefined") {
                this.formModel = nfRadio.channel('app').request('get:form', formID)
                if (this.formModel === null || typeof this.formModel === "undefined") {
                    console.log(model)
                    console.warn("formModel wasn't set (is this the right form?)")
                    return
                }
            }

            var errors = this.formModel.get('errors')
            if (errors.length > 0) {
                for (var i in errors.models) {
                    var error = errors.models[i]
                    // var model_id = model.get('id');
                    var error_id = error.get('id')
                    this.formModel.removeError(error_id)
                }
            }
        },

        actionSubmit: function (response) {
            var formID = response.data.form_id
            if (formID != florp.form_id_main && formID != florp.form_id_flashmob && formID != florp.form_id_intf) {
                console.info("This is not a FLORP form")
                return
            }
            if ("undefined" === typeof florp || (-1 == jQuery.inArray("main", florp.blog_types) && -1 == jQuery.inArray("flashmob", florp.blog_types) && -1 == jQuery.inArray("international", florp.blog_types))) {
                console.info("This is not the main, flashmob or international flashmob blog")
                return
            }
            var errorCount = 0
            if ("undefined" === typeof response.errors.length) {
                if ("undefined" === typeof this.formModel) {
                    var i

                    for (i in response.errors) {
                        if (response.errors.hasOwnProperty(i)) {
                            errorCount++
                        }
                    }
                } else {
                    var errors = this.formModel.get('errors')
                    errorCount = errors.length
                }
            } else {
                errorCount = response.errors.length
            }
            if (errorCount == 0) {
                sessionStorage.setItem("florpFormSubmitSuccessful", "1")
                if (formID == florp.form_id_flashmob || formID == florp.form_id_intf) {
                    if (formID == florp.form_id_flashmob) {
                        console.info("Successful submission on the flashmob blog => clearing form")
                    } else {
                        console.info("Successful submission on the international flashmob blog => clearing form")
                    }
                    jQuery('.florp-clear-on-submission').find("input, select").each(function () {
                        var $this = jQuery(this)
                        if ($this.is("select")) {
                            if ($this.val() !== "null") {
                                $this.val("null").trigger('change')
                            }
                        } else if ($this.is("input") && ($this.prop("type") === "checkbox")) {
                            if ($this.prop("checked")) {
                                if ($this.val() !== "flashmob_participant_tshirt") {
                                    $this.prop("checked", false).trigger('change')
                                }
                            } else if ($this.val() === "flashmob_participant_tshirt" && florp.tshirt_ordering_disabled !== "1") {
                                if (formID == florp.form_id_intf) {
                                    $this.prop("checked", false).trigger('change')
                                } else {
                                    $this.prop("checked", true).trigger('change')
                                }
                            }
                        } else if ($this.is("input") && $this.prop("type") !== "radio") {
                            if ($this.val().length > 0) {
                                $this.val("").trigger('change')
                            }
                        }
                        // Remove form field errors //
                        var fieldID = $this.parents(".field-wrap").data('fieldId')
                        if ("undefined" === typeof fieldID) {
                            fieldID = $this.prop("id").replace("nf-field-", "").split("-")[0]
                        }
                        var field = nfRadio.channel("fields").request("get:field", fieldID)
                        nfRadio.channel("fields").request("remove:error", field.get("id"), "required-error")
                    })
                    // Remove selected radiobuttons and manually change the value of the field //
                    jQuery(".florp-clear-on-submission .listradio-container").each(function () {
                        var $this = jQuery(this)
                        var $inputs = $this.find("input[type=radio]")
                        $inputs.removeAttr("checked").removeClass("nf-checked")
                        $this.find("label").removeClass("nf-checked-label")

                        var fieldID = $this.find(".field-wrap").data("fieldId")
                        nfRadio.channel("fields").request("get:field", fieldID).set("value", "")
                        nfRadio.channel("fields").request("remove:error", fieldID, "required-error")
                    })

                    // Remove form errors //
                    var errors = this.formModel.get('errors')
                    if (errors.length > 0) {
                        for (var i in errors.models) {
                            var error = errors.models[i]
                            // var model_id = model.get('id');
                            var error_id = error.get('id')
                            this.formModel.removeError(error_id)
                        }
                    }
                    setTimeout(function () {
                        jQuery(".nf-response-msg").children().fadeOut(500, function () {
                            jQuery(this).remove()
                        })
                    }, 2000)
                    return
                }

                if (formID == florp.form_id_flashmob && ("undefined" !== typeof florp.user_id || florp.user_id > 0)) {
                    console.info("This is the main blog's profile form")

                    // Replace the "flashmobbers" tab //
                    $tableOld = jQuery("." + florp.leader_participant_table_class)
                    if ($tableOld.length > 0) {
                        var data = {
                            action: florp.get_leaderParticipantsTable_action || "",
                            security: florp.security,
                            iUserID: florp.user_id
                        }
                        window["florpGetLeaderParticipantsTableAjaxRunning"] = true
                        jQuery.ajax({
                            type: "POST",
                            url: florp.ajaxurl,
                            data: data,
                            success: function (response) {
                                // console.log(response);
                                try {
                                    var aResponse = JSON.parse(response)
                                    if (aResponse.tableHtml) {
                                        // console.log(aResponse)
                                        $table = jQuery(aResponse.tableHtml)
                                        jQuery("." + florp.leader_participant_table_class).html($table)
                                    }
                                    window["florpGetLeaderParticipantsTableAjaxRunning"] = false
                                } catch (e) {
                                    console.warn(e)
                                    window["florpGetLeaderParticipantsTableAjaxRunning"] = false
                                }
                            }
                        })
                    } else {
                        console.info("No element with class '" + florp.leader_participant_table_class + "' to replace")
                    }
                    var strMessageSelector = ".florp_success_message", iTimeout = 5000
                    if (!window["florpSuccessMessageTimeout"]) {
                        window["florpSuccessMessageTimeout"] = setTimeout(function (strMessageSelector) {
                            jQuery(strMessageSelector).fadeOut(800, function () {
                                // jQuery(this).remove()
                            })
                            window["florpSuccessMessageTimeout"] = null
                        }, iTimeout, strMessageSelector)
                    }
                    return
                }

                console.info("This is the main blog's registration form")

                // response.data.fields_by_key -> use to login
                var successMessageSpan = jQuery(".florp_success_message")
                var successMessage = successMessageSpan.html()

                // wait .1 sec before showing the success message //
                setTimeout(function () {
                    successMessageSpan.html(successMessage + " " + florp.logging_in_msg)

                    // wait 2 sec before filling in the login form //
                    setTimeout(function () {
                        var form = jQuery(".florp-profile-wrapper .lwa")
                        var idPrefix = form.data("idPrefix")
                        var loginForm = jQuery(".florp-profile-wrapper form.lwa-form")
                        var loginUsernameInput = jQuery(".florp-profile-wrapper #" + idPrefix + "lwa_user_login")
                        var loginPasswordInput = jQuery(".florp-profile-wrapper #" + idPrefix + "lwa_user_pass")
                        var loginUsername = response.data.fields_by_key.user_email.value
                        var loginPassword = response.data.fields_by_key.user_pass.value

                        loginUsernameInput.val(loginUsername)
                        loginPasswordInput.val(loginPassword)

                        florp.doNotSetCookie = true

                        // hide registration form //
                        jQuery(".florp-profile-wrapper .lwa-register").hide('slow')
                        loginForm.show('slow')

                        // wait .5 sec before submitting the login form
                        setTimeout(function () {
                            // submit login form //
                            loginForm.submit()
                        }, 500)
                    }, 2000)
                }, 100)
            }
        }
    })

    // Instantiate //
    new florpSubmitController()
}
