jQuery( document ).ready( function() {
    var fnFlorpButtonLabel = function( strLabel, strInfo ) {
        return strLabel + " (" + strInfo + ")"
    }
    var fnFlorpShowMessage = function( strMessage, strMessageId, strType = "info", iTimeout = false, $insertBefore = false, bReplace = false, fadeOutCallback = undefined, fadeOutCallbackInput = {}, iTableCell = false ) {
        strType = strType || "info"
        strMessageId = strMessageId.replace( /[^a-zA-Z0-9_-]/g, "_" )
        jQuery( "#" + strMessageId ).remove()
        var $msg
        if ("undefined" !== typeof iTableCell && false !== iTableCell) {
            var strColspan = ""
            if (iTableCell !== true && iTableCell > 1) {
                strColspan = " colspan='" + iTableCell + "'"
            }
            $msg = jQuery( "<tr id='" + strMessageId + "'><td" + strColspan + "><div class='notice notice-" + strType + "'><p>" + strMessage + "</p></div></td></tr>" )
        } else {
            $msg = jQuery( "<div id='" + strMessageId + "' class='notice notice-" + strType + "'><p>" + strMessage + "</p></div>" )
        }
        if ("undefined" === typeof window["florpAdminTimeouts"]) {
            window["florpAdminTimeouts"] = {}
        }
        if ("undefined" !== typeof $insertBefore && false !== $insertBefore && $insertBefore.length > 0) {
            if (bReplace) {
                $insertBefore.children().addClass( 'forceHide' ).hide()
            }
            $msg.insertBefore( $insertBefore )
        } else {
            $msg.insertBefore( jQuery( ".wrap table" ).first() )
        }
        if ("undefined" !== typeof iTimeout && false !== iTimeout && iTimeout > 0) {
            window["florpAdminTimeouts"][strMessageId] = setTimeout( function( strMessageId, fadeOutCallbackLoc, fadeOutCallbackInputLoc ) {
                if ("undefined" !== typeof fadeOutCallbackLoc) {
                    jQuery( "#" + strMessageId ).fadeOut( 800, function() {
                        fadeOutCallbackLoc( fadeOutCallbackInputLoc )
                        jQuery( this ).remove()
                    } )
                } else {
                    jQuery( "#" + strMessageId ).fadeOut( 800, function() {
                        jQuery( this ).remove()
                    } )
                }
                window["florpAdminTimeouts"][strMessageId] = null
            }, iTimeout, strMessageId, fadeOutCallback, fadeOutCallbackInput )
        }
    }
    jQuery( ".button.double-check" ).click( function() {
        var $this = jQuery( this )
        var data = $this.data()
        var sure = data.sure, strButtonId = data.buttonId, strRowId = data.rowId, strAction = data.action,
            textDoubleCheck = data.textDoubleCheck, textDefault = data.textDefault
        if ("undefined" === typeof strButtonId || "undefined" === typeof strRowId || "undefined" === typeof strAction) {
            console.warn( "No buttonId, rowId or action!" )
            console.log( data )
            return
        }
        if (data.useInputNames) {
            var strInputNames = data.useInputNames
            var bError = false
            jQuery.each( strInputNames.split( "," ), function( index, value ) {
                var $input = jQuery( "[data-row-id=" + strRowId + "] [name=" + value + "]" )
                if ($input.length > 0) {
                    var val = $input.val()
                    if (val.length === 0) {
                        console.warn( "Required input with name = '" + value + "' is empty!" )
                        bError = true
                        return false
                    } else {
                        data[value] = val
                    }
                }
            } )
            if (bError) {
                console.log( data )
                return
            }
        }
        if ("undefined" === typeof window[strButtonId]) {
            window[strButtonId] = {}
        }
        if ("undefined" !== typeof sure && 1 === sure) {
            if ("undefined" === typeof ajaxurl) {
                console.warn( "No ajaxurl!" )
            } else {
                $this.data( "wait", 1 )
                $this.text( fnFlorpButtonLabel( textDoubleCheck, "waiting for response..." ) )
                jQuery.post( ajaxurl, data, function( response ) {
                    if (response) {
                        try {
                            var aResponse = JSON.parse( response )
                            // console.log(aResponse)
                            var strMessageId = "florpMessage-" + aResponse.buttonId
                            var $button = jQuery( ".button.double-check[data-button-id=" + aResponse.buttonId + "]" )
                            var $container = $button.parents( "tr" )
                            var iTableCell = false
                            if ($container.length === 0) {
                                $container = $button.parents( "table" )
                                if ($container.length === 0) {
                                    $container = $button.parents( "p" )
                                }
                            } else {
                                $container = $container.first()
                                iTableCell = $container[0].cells ? $container[0].cells.length : false
                            }
                            if ($container.length === 0) {
                                $container = false
                            }
                            if (aResponse.ok) {
                                // console.log(aResponse)
                                var strButtonIdLocal = aResponse.buttonId
                                clearInterval( window[strButtonIdLocal]["interval"] )
                                window[strButtonIdLocal]["interval"] = null
                                $button.text( aResponse.textDefault ).removeClass( "button-primary" ).data( "sure", 0 )
                                if ($button.hasClass( "button-warning-removed" )) {
                                    $button.removeClass( "button-warning-removed" ).addClass( "button-warning" )
                                }
                                var $row = jQuery( ".row[data-row-id=" + aResponse.rowId + "]" )
                                if (aResponse.removeRowOnSuccess && aResponse.removeRowOnSuccess === true) {
                                    console.log( aResponse )
                                    if ($row.length > 0) {
                                        if (aResponse.message) {
                                            fnFlorpShowMessage( aResponse.message, strMessageId + "-ok", "success", 2000, $row, true, function( input ) {
                                                var $row = input['$row'], aResponse = input['aResponse']
                                                $row.fadeOut( 800, function() {
                                                    jQuery( this ).addClass( 'forceHide' )
                                                } ).addClass( "florpRowRemoved" )
                                                var $table = $row.parents( "table" )
                                                if ($table.length > 0) {
                                                    $table.trigger( "florpRowDelete" )
                                                }
                                                if (aResponse.hideSelector) {
                                                    jQuery( aResponse.hideSelector ).fadeOut( 800, function() {
                                                        jQuery( this ).addClass( 'forceHide' )
                                                    } )
                                                }
                                            }, {
                                                '$row': $row,
                                                'aResponse': aResponse
                                            }, $row.first()[0] && $row.first()[0].cells ? $row.first()[0].cells.length : false )
                                        } else {
                                            $row.fadeOut( 800, function() {
                                                jQuery( this ).addClass( 'forceHide' )
                                            } ).addClass( "florpRowRemoved" )
                                            var $table = $row.parents( "table" )
                                            if ($table.length > 0) {
                                                $table.trigger( "florpRowDelete" )
                                            }
                                            if (aResponse.hideSelector) {
                                                jQuery( aResponse.hideSelector ).fadeOut( 800, function() {
                                                    jQuery( this ).addClass( 'forceHide' )
                                                } )
                                            }
                                        }
                                    } else {
                                        if (aResponse.message) {
                                            fnFlorpShowMessage( aResponse.message, strMessageId + "-ok", "success", 2000 )
                                        }
//                     var $table = $button.parents("table")
//                     if ($table.length > 0) {
//                       $table.trigger( "florpRowDelete" )
//                     }
                                        if (aResponse.hideSelector) {
                                            jQuery( aResponse.hideSelector ).fadeOut( 800, function() {
                                                jQuery( this ).addClass( 'forceHide' )
                                            } )
                                        }
                                        console.warn( "No row to fade out!" )
                                    }
                                } else {
                                    console.log( aResponse )
                                    if (aResponse.message) {
                                        fnFlorpShowMessage( aResponse.message, strMessageId + "-ok", "success", 2000, $row, false, function( input ) {
                                            var aResponse = input['aResponse'], $button = input['$button'],
                                                data = input['data']
                                            if (aResponse.replaceButton && aResponse.replaceButtonHtml) {
                                                var newButton = jQuery( aResponse.replaceButtonHtml )
                                                newButton.insertBefore( $button )
                                                $button.remove()
                                            }
                                            if (aResponse.hideSelector) {
                                                jQuery( aResponse.hideSelector ).addClass( 'forceHide' ).hide()
                                            }
                                            if (aResponse.insertAfterSelector && jQuery( aResponse.insertAfterSelector ).length > 0 && aResponse.insertHtml) {
                                                jQuery( aResponse.insertHtml ).insertAfter( jQuery( aResponse.insertAfterSelector ) )
                                            }
                                            if (aResponse.useInputNames && aResponse.clearInputNames) {
                                                var strInputNames = data.useInputNames
                                                jQuery.each( strInputNames.split( "," ), function( index, value ) {
                                                    var $input = jQuery( "[data-row-id=" + aResponse.rowId + "] input[name=" + value + "]" )
                                                    if ($input.length > 0) {
                                                        $input.val( "" )
                                                    }
                                                } )
                                            }
                                            if (aResponse.reload_page) {
                                                location.reload()
                                            }
                                        }, {
                                            'aResponse': aResponse,
                                            '$button': $button,
                                            'data': data
                                        }, $row.first()[0] && $row.first()[0].cells ? $row.first()[0].cells.length : false )
                                    } else {
                                        if (aResponse.replaceButton && aResponse.replaceButtonHtml) {
                                            var newButton = jQuery( aResponse.replaceButtonHtml )
                                            newButton.insertBefore( $button )
                                            $button.remove()
                                        }
                                        if (aResponse.hideSelector) {
                                            jQuery( aResponse.hideSelector ).addClass( 'forceHide' ).hide()
                                        }
                                        if (aResponse.insertAfterSelector && jQuery( aResponse.insertAfterSelector ).length > 0 && aResponse.insertHtml) {
                                            jQuery( aResponse.insertHtml ).insertAfter( jQuery( aResponse.insertAfterSelector ) )
                                        }
                                        if (aResponse.useInputNames && aResponse.clearInputNames) {
                                            var strInputNames = data.useInputNames
                                            jQuery.each( strInputNames.split( "," ), function( index, value ) {
                                                var $input = jQuery( "[data-row-id=" + aResponse.rowId + "] input[name=" + value + "]" )
                                                if ($input.length > 0) {
                                                    $input.val( "" )
                                                }
                                            } )
                                        }
                                        if (aResponse.reload_page) {
                                            location.reload()
                                        }
                                    }
                                }
                            } else {
                                if (aResponse.message) {
                                    fnFlorpShowMessage( aResponse.message, strMessageId + "-error", "error", 10000, $container, false, undefined, {}, iTableCell )
                                } else {
                                    fnFlorpShowMessage( "An error occurred", strMessageId + "-error", "error", 10000, $container, false, undefined, {}, iTableCell )
                                }
                                console.log( aResponse )
                            }
                        } catch (e) {
                            console.warn( e )
                            console.log( response )
                            fnFlorpShowMessage( "An error occurred", "exception-error", "error", 10000 )
                        } finally {
                            $this.data( "wait", 0 )
                        }
                    } else {
                        console.warn( "No response" )
                        fnFlorpShowMessage( "An error occurred", "no-response-error", "error", 10000 )
                    }
                    $this.data( "wait", 0 )
                } ).fail( function( jqXHR, textStatus, errorThrown ) {
                    console.warn( textStatus, errorThrown, jqXHR )
                    fnFlorpShowMessage( errorThrown + ": " + (jqXHR.responseText) + "<br/>" + "Please reload page and try again", "post-fail-error", "error", 10000 )
                    $this.data( "wait", 0 )
                } )
            }
        } else {
            window[strButtonId]["timeLeft"] = 5, window[strButtonId]["wait"] = 0, window[strButtonId]["timeout"] = 30
            $this.text( fnFlorpButtonLabel( textDoubleCheck, window[strButtonId]["timeLeft"] ) ).addClass( "button-primary" ).data( "sure", 1 ).data( "wait", 0 )
            if ($this.hasClass( "button-warning" )) {
                $this.removeClass( "button-warning" ).addClass( "button-warning-removed" )
            }

            window[strButtonId]["interval"] = setInterval( function() {
                wait = $this.data( "wait" )
                if ("undefined" !== typeof wait && wait === 1) {
                    window[strButtonId]["wait"]++
                    if (window[strButtonId]["wait"] >= window[strButtonId]["timeout"]) {
                        clearInterval( window[strButtonId]["interval"] )
                        window[strButtonId]["interval"] = null
                        $this.text( textDefault ).removeClass( "button-primary" ).data( "sure", 0 )
                        if ($this.hasClass( "button-warning-removed" )) {
                            $this.removeClass( "button-warning-removed" ).addClass( "button-warning" )
                        }
                        fnFlorpShowMessage( "The operation timed out", "timeout-error", "error", 10000 )
                    }
                } else {
                    window[strButtonId]["timeLeft"]--
                    if (window[strButtonId]["timeLeft"] <= 0) {
                        clearInterval( window[strButtonId]["interval"] )
                        window[strButtonId]["interval"] = null
                        $this.text( textDefault ).removeClass( "button-primary" ).data( "sure", 0 )
                        if ($this.hasClass( "button-warning-removed" )) {
                            $this.removeClass( "button-warning-removed" ).addClass( "button-warning" )
                        }
                    } else {
                        $this.text( fnFlorpButtonLabel( textDoubleCheck, window[strButtonId]["timeLeft"] ) )
                    }
                }
//         console.log($this.data())
            }, 1000 )
        }
    } )

    jQuery( ".button.pop-in" ).click( function() {
        var $this = jQuery( this )
        if ($this.hasClass( "disabled" )) {
            return
        }

        var data = $this.data()
        var position = $this.position()
        var $div = jQuery( "#" + data.popInId )
        if ($div.length === 0) {
            return
        }

        var $form = $div.children( "form" )
        if ($form.length === 0) {
            return
        }

        if ($form.data( "wait" ) === "1") {
            return
        }

        var $row = jQuery( "tr[data-row-id=" + data.rowId + "]" ).first()
        var $button = $row.find( "span[data-button-id=" + data.buttonId + "]" ).first()

        if (!$div.data( "buttonId" ) || $div.data( "buttonId" ) === data.buttonId) {
            var hiddenBeforeStop = $div.hasClass( "hide" )
            $div.stop( true, true )
            if (hiddenBeforeStop !== $div.hasClass( "hide" )) {
                return
            }

            $div.toggleClass( "hide" )
        } else {
            $div.stop( true, true )
            $div.removeClass( "hide" )
        }

        if ($div.hasClass( "hide" )) {
            $button.removeClass( "active" )
            return
        } else {
            jQuery( ".button.pop-in.active" ).filter( ( i, el ) => jQuery( el ).data().popInId === data.popInId ).removeClass( "active" )
        }

        $button.addClass( "active" )
        $form.find( "p#error,p#success" ).addClass( "hide" ).text( "" )
        $div.data( "buttonId", data.buttonId )
        $div.css( {top: position.top, left: position.left + $this.width()} )

        $form.find( "select" ).each( function( i, el ) {
            var $el = jQuery( el )
            if (data.changeAction === "change") {
                $el.val( data[$el.attr( "id" )] )
            } else {
                $el.val( "null" )
            }
        } )
        $form.find( "input#data" ).val( JSON.stringify( data ) )
    } )

    jQuery( "form.florp-pop-in-form" ).on( "submit", function( event ) {
        event.preventDefault()

        var $form = jQuery( event.target ), data
        try {
            data = JSON.parse( $form.find( "input#data" ).val() )
        } catch (e) {
            console.warn( e )
            return
        }

        data = $form.serializeArray().reduce( function( obj, item ) {
            if (item.name !== "data") {
                obj[item.name] = item.value
            }
            return obj
        }, data )

        if (data.popInId === "florp-admin-tshirt-change") {
            if (!checkTshirtSubmission( $form, data )) {
                return
            }
        }

        $form.find( "p#error,p#success" ).addClass( "hide" ).text( "" )
        $form.data( "wait", 1 )

        var $row = jQuery( "tr[data-row-id=" + data.rowId + "]" ).first()
        var $button = $row.find( "span[data-button-id=" + data.buttonId + "]" ).first()
        $button.addClass( "disabled" )

        jQuery.post( ajaxurl, data, function( response ) {
            if (response) {
                try {
                    var aResponse = JSON.parse( response )

                    if (!aResponse.ok) {
                        console.log( aResponse )
                        $form.find( "p#error" ).removeClass( "hide" ).text( aResponse.message || "An error occurred" )
                        return
                    }

                    if (aResponse.popInId === "florp-admin-tshirt-change") {
                        processTshirtChange( aResponse )
                    } else {
                        console.log( aResponse )
                    }

                    $form.find( "p#success" ).removeClass( "hide" ).text( aResponse.message || "Success!" )

                    $form.parent( ".florp-pop-in-div" ).fadeOut( 3000, function() {
                        jQuery( this ).addClass( "hide" ).css( {opacity: "", display: ""} )
                        $button.removeClass( "active" )
                    } )
                } catch (e) {
                    console.warn( e )
                    console.log( response )
                    $form.find( "p#error" ).removeClass( "hide" ).text( "An error occurred" )
                } finally {
                    $button.removeClass( "disabled" )
                    $form.data( "wait", 0 )
                }
            } else {
                console.warn( "No response" )
                $form.find( "p#error" ).removeClass( "hide" ).text( "An error occurred" )
                $form.data( "wait", 0 )
            }
        } ).fail( function( jqXHR, textStatus, errorThrown ) {
            $form.find( "p#error" ).removeClass( "hide" ).html( errorThrown + ": " + (jqXHR.responseText) + "<br/>" + "Please reload page and try again" )
            console.log( textStatus, errorThrown, jqXHR )

            $button.removeClass( "disabled" )
            $form.data( "wait", 0 )
        } )
    } )

    function checkTshirtSubmission( $form, data ) {
        var aKeys = ["tshirt_color", "tshirt_gender", "tshirt_size"]

        for (let i = 0; i < aKeys.length; i++) {
            if (data[aKeys[i]] === "" || data[aKeys[i]] === "null") {
                $form.find( "p#error" ).removeClass( "hide" ).text( "All fields are required!" )
                return false
            }
        }

        return true
    }

    function processTshirtChange( aResponse ) {
        console.log( aResponse )

        var dataFieldPrefix = ""
        if (aResponse.action === "florp_intf_change_tshirt" || aResponse.action === "florp_change_tshirt") {
            dataFieldPrefix = "flashmob_participant_"
        }

        var $row = jQuery( "tr[data-row-id=" + aResponse.rowId + "]" ).first()
        var $button = $row.find( "span[data-button-id=" + aResponse.buttonId + "]" ).first()
        var aKeys = ["tshirt_color", "tshirt_gender", "tshirt_size"]

        for (var key in aResponse) {
            if (aResponse.hasOwnProperty( key )) {
                $button.data( key, aResponse[key] )
            }
        }

        if (aResponse.changeAction === "change") {
            for (let i = 0; i < aKeys.length; i++) {
                var sKey = aKeys[i]
                $row.find( "span[data-field=" + dataFieldPrefix + sKey + "] span.florp-val" ).text( aResponse[dataFieldPrefix + sKey] || aResponse[sKey] )
            }
        } else {
            $button.text( "Zmeniť tričko" ).data( "changeAction", "change" )

            var $col = $row.find( "td.column-profil" )
            if ($col.length > 0) {
                if (aResponse.preferences) {
                    $pref = $col.find( "span[data-field=preferences]" )
                    if ($pref.length > 0) {
                        $pref.find( "span.florp-val" ).text( aResponse.preferences )
                    } else {
                        $col.append( jQuery( "<span data-field-id='preferences'><strong>Preferences</strong>: <span class='florp-val'>" + aResponse.preferences + "</span></span></br>" ) )
                    }
                }

                for (let i = 0; i < aKeys.length; i++) {
                    var sKey = aKeys[i]
                    var fieldKey = dataFieldPrefix + sKey
                    var fieldLabel = fieldKey.replace( /_/g, " " )
                    fieldLabel = fieldLabel[0].toUpperCase() + fieldLabel.toLowerCase().slice( 1 )
                    $col.append( jQuery( "<span data-field-id='" + fieldKey + "'><strong>" + fieldLabel + "</strong>: <span class='florp-val'>" + aResponse[sKey] + "</span></span>" + (i === aKeys.length - 1 ? "" : "</br>") ) )
                }
            }
        }
    }

    // Filter for admin tables //
    var fnRemoveAccents = function( str ) {
        if ("string" !== typeof str) {
            return str
        }
        return str.normalize( 'NFD' ).replace( /[\u0300-\u036f]/g, "" )
    }

    var $tables = jQuery( "table" )
    window["florpFilterColumnInputValues"] = {}
    window["florpFilterRowsTimeoutId"] = null
    if ($tables.length > 0) {
        function fnFlorpFilterRows( fromTimeout = false ) {
            if (window["florpFilterRowsTimeoutId"]) {
                clearTimeout( window["florpFilterRowsTimeoutId"] )
                window["florpFilterRowsTimeoutId"] = null
            }

            if (!fromTimeout) {
                window["florpFilterRowsTimeoutId"] = setTimeout( fnFlorpFilterRows.bind( this ), 500, true )
                return
            }

            var $this = jQuery( this )
            var val = fnRemoveAccents( $this.val().trim() ).toLowerCase()
            var tableId = $this.data( "florpFilterTableId" )
            var columnId = $this.data( "florpFilterColumnId" )
            if (window["florpFilterColumnInputValues"][tableId][columnId] === val) {
                // Don't reevaluate on the same value - mainly the case of multiple events firing for the same field //
                return
            }
            window["florpFilterColumnInputValues"][tableId][columnId] = val

            jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + " .florpFakeCell" ).remove()

            if (val === "") {
                // Show all rows hidden by this column //
                jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + ".florpFilterHiddenColumn" + columnId ).removeClass( "florpFilterHiddenColumn" + columnId )
                jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + " .florpFilterColumn" + columnId ).each( ( i, el ) => {
                    new Hilitor( el ).setMatchType( "open" ).setColorCount( 1 ).remove()
                } )
            } else {
                // Hide all //
                jQuery( "tr.florpFilterRow.florpFilterTable" + tableId ).addClass( "florpFilterHiddenColumn" + columnId )

                // Show matching rows //
                jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + ".florpFilterHiddenColumn" + columnId ).filter( function() {
                    var colHtml = jQuery( this ).find( "td.florpFilterCell.florpFilterColumn" + columnId ).html()
                    var $colClone = jQuery( "<div>" + colHtml + "</div>" )
                    $colClone.find( "br,span.button" ).remove()
                    var colTxt = $colClone.text()
                    if (!colTxt) {
                        return false
                    }

                    var res = fnRemoveAccents( colTxt ).toLowerCase().indexOf( val ) !== -1

                    var $col = jQuery( this ).find( "td.florpFilterCell.florpFilterColumn" + columnId )
                    $col.each( ( i, el ) => {
                        var h = new Hilitor( el ).setMatchType( "open" ).setColorCount( 1 )
                        if (res) {
                            // debugger
                            h.apply( val )
                        } else {
                            h.remove()
                        }
                    } )

                    return res
                } ).removeClass( "florpFilterHiddenColumn" + columnId )
            }

            jQuery( "tr.florpFilterRow.florpFilterTable" + tableId ).each( function() {
                if (this.className.indexOf( "florpFilterHiddenColumn" ) !== -1) {
                    jQuery( this ).addClass( "florpFilterHidden" )
                } else {
                    var $row = jQuery( this )
                    $row.removeClass( "florpFilterHidden" )

                    // Supply fake row-spanned columns for visible rows
                    var rowspanParentRowId = $row.data( "florpRowspanParent" )
                    if (rowspanParentRowId !== undefined && rowspanParentRowId !== null) {
                        rowspanParentRowId = parseInt( rowspanParentRowId )
                        var $rowspanParentRow = jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + ".florpFilterRow" + rowspanParentRowId )
                        if (!$rowspanParentRow.hasClass( "florpFilterHidden" )) {
                            return
                        }

                        $rowspanParentRow.find( ".florpFilterCell" )
                            .filter( ( i, el ) => jQuery( el ).attr( "rowspan" ) && jQuery( el ).attr( "rowspan" ) > 1 && !jQuery( el ).hasClass( "florpFakeCell" ) )
                            .each( function() {
                                var $cell = jQuery( this )
                                var id = parseInt( $cell.data( "florpFilterColumnId" ) )
                                var $clone = $cell.clone().addClass( "florpFakeCell" ).attr( "rowspan", null )

                                if (id === 0) {
                                    $row.prepend( $clone )
                                } else {
                                    $row.find( ".florpFilterCell:nth-child(" + id + ")" ).after( $clone )
                                }
                            } )
                    }
                }
            } )

            for (var ir in window["florpRowspanChildren"][tableId]) {
                if (window["florpRowspanChildren"][tableId].hasOwnProperty( ir ) && window["florpRowspanChildren"][tableId][ir]) {
                    var $row = jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + ".florpFilterRow" + ir )
                    var visibleCount = 0
                    window["florpRowspanChildren"][tableId][ir].forEach( function( rowId ) {
                        if (!jQuery( "tr.florpFilterRow.florpFilterTable" + tableId + ".florpFilterRow" + rowId ).hasClass( "florpFilterHidden" )) {
                            visibleCount++
                        }
                    } )
                    $row.find( ".florpFilterCell" ).filter( function( i, el ) {
                        var $cell = jQuery( this )
                        return $cell.data( "rowspan" ) && $cell.data( "rowspan" ) > 1
                    } ).each( function() {
                        var $cell = jQuery( this )
                        $cell.attr( "rowspan", visibleCount + 1 )
                    } )
                }
            }

            fnUpdateFilterRowCount( tableId )
        }

        function fnUpdateFilterRowCount( tableId ) {
            var iCountMax = jQuery( "table.florpFilterTable" + tableId ).data( "rowCount" )
            var iCountHidden = jQuery( "table.florpFilterTable" + tableId + " tr.florpFilterHidden:not(.florpRowRemoved)" ).length
            var $countInfoCount = jQuery( "span.tableCountInfo.florpFilterTable" + tableId + " .count" )
            if (iCountHidden === 0) {
                $countInfoCount.text( iCountMax )
            } else {
                $countInfoCount.text( (iCountMax - iCountHidden) + " / " + iCountMax )
            }
        }

        window["florpRowspanChildren"] = window["florpRowspanChildren"] || {}
        $tables.each( function( it ) {
            window["florpFilterColumnInputValues"][it] = {}
            var $table = jQuery( this )
            if ($table.hasClass( "noFilter" )) {
                return false
            }
            var $rows = $table.find( "tr" )
            if ($rows.length === 0) {
                return false
            }

            var bInsertAfterFirstRow = false
            var $firstRow = $rows.first()
            var $firstRowCells = $firstRow.find( "th" )
            var iColumns = $firstRowCells.length
            var $countInfo = jQuery( '<span class="tableCountInfo florpFilterTable' + it + '"></span>' )
            var iRowCount
            if (iColumns > 0) {
                bInsertAfterFirstRow = true
                $table.data( "hasHeader", 1 )
                iRowCount = $rows.length - 1
                $table.data( "rowCount", iRowCount )
            } else {
                $firstRowCells = $firstRow.find( "td" )
                iColumns = $firstRowCells.length
                $table.data( "hasHeader", 0 )
                var iRowCount = $rows.length
                $table.data( "rowCount", iRowCount )
            }
            if (iColumns === 0) {
                return false
            }
            $table.data( "florpFilterTableId", it )
            $table.on( 'florpRowDelete', function() {
                var $t = jQuery( this )
                var tableId = $t.data( "florpFilterTableId" )
                var maxRowCount = $t.data( "rowCount" )
                $t.data( "rowCount", maxRowCount - 1 )
                fnUpdateFilterRowCount( tableId )
            } )
            $table.addClass( "florpFilterTable" + it )
            $countInfo.insertBefore( $table )
            $countInfo.html( "Count: <span class=\"count\">" + iRowCount + "</span>" )
            var filterRowHtml = '<tr class="florpFilterHeaderRow">'
            for (var i = 0; i < iColumns; i++) {
                window["florpFilterColumnInputValues"][it][i] = ""
                var strPlaceholder = ''
                if (bInsertAfterFirstRow) {
                    strPlaceholder = ' placeholder="Filter: ' + jQuery( $firstRow.find( "th" )[i] ).text() + '"'
                }
                var classes = $firstRowCells[i].classList.toString()
                filterRowHtml += '<th class="florpFilterHeaderCell ' + classes + '">'
                filterRowHtml += '<input class="florpFilterInput" type="text" data-florp-filter-table-id="' + it + '" data-florp-filter-column-id="' + i + '"' + strPlaceholder + '/>'
                filterRowHtml += "</th>"
            }
            filterRowHtml += "</tr>"
            var $filterRow = jQuery( filterRowHtml )
            if (bInsertAfterFirstRow) {
                $filterRow.insertAfter( $firstRow )
            } else {
                $filterRow.insertBefore( $firstRow )
            }

            var rowspan = {}
            window["florpRowspanChildren"][it] = window["florpRowspanChildren"][it] || {}
            $rows.each( function( ir ) {
                rowspan[ir] = rowspan[ir] || {}

                var $row = jQuery( this )
                if (ir !== 0 || !bInsertAfterFirstRow) {
                    $row.addClass( "florpFilterRow florpFilterRow" + ir + " florpFilterTable" + it )
                }
                $row.data( "florpFilterRowId", ir )

                var $cells = $row.find( "td" )
                $cells.each( function( ic ) {
                    while (rowspan[ir][ic] !== undefined) {
                        ic++
                    }

                    var $cell = jQuery( this )

                    rowspan[ir][ic] = $cell.attr( "rowspan" ) ? parseInt( $cell.attr( "rowspan" ) ) : 1
                    $cell.data( "rowspan", rowspan[ir][ic] )
                    if (rowspan[ir][ic] > 1) {
                        window["florpRowspanChildren"][it][ir] = []
                        for (var rs = 1; rs < rowspan[ir][ic]; rs++) {
                            rowspan[ir + rs] = rowspan[ir + rs] || {}
                            rowspan[ir + rs][ic] = 0
                            window["florpRowspanChildren"][it][ir].push( ir + rs )
                        }
                    }

                    $cell.data( "florpFilterColumnId", ic ).addClass( "florpFilterCell florpFilterColumn" + ic + " florpFilterTable" + it )
                } )

                var parent = null
                for (var c in rowspan[ir]) {
                    if (rowspan[ir].hasOwnProperty( c ) && rowspan[ir][c] === 0) {
                        for (var r = ir - 1; r >= 0; r--) {
                            if (rowspan[r][c] > 1) {
                                parent = r
                                break
                            }
                        }
                    }
                    if (parent !== null) {
                        break
                    }
                }

                if (parent !== null) {
                    $row.data( "florpRowspanParent", parent )
                }
            } )
            rowspan = undefined

            jQuery( document ).on( "change keyup paste input textInput", "input.florpFilterInput", fnFlorpFilterRows )
        } )
    }

    // Date/time picker //
    jQuery( "input.jquery-datetimepicker" ).each( function() {
        var $this = jQuery( this )
        var options = {
            controlType: 'select',
            oneLine: true,
            timeInput: false,
            timeFormat: 'HH:mm:ss',
            currentText: "Teraz",
            closeText: "Hotovo"
        }
        if ($this.data( "altField" )) {
            $altField = jQuery( $this.data( "altField" ) )
            if ($altField.length > 0) {
                options["onSelect"] = function( dateTimeText, datePickerInstance ) {
                    var $input = datePickerInstance['$input'] || datePickerInstance['input'] || false
                    if (typeof $input !== 'undefined') {
                        // console.log(datePickerInstance);
                        var date = $input.datepicker( "getDate" )
                        var timestamp = Math.round( new Date( date ).getTime() / 1000 )
                        // console.log(timestamp);
                        // console.log(datePickerInstance)
                        $altField.val( timestamp )
                    } else {
                        console.log( dateTimeText )
                        console.log( datePickerInstance )
                    }
                }
            }
        }
        $this.datetimepicker( options )
    } )

    var tableIndex = 0
    jQuery( "table:not(.noFilter)" ).each( function() {
        var $table = jQuery( this )
        $table.data( "buttonTogglerTableId", tableIndex )

        // BEGIN: Column toggling //
        var columnClasses = []
        $table.find( "td.column, th.column" ).each( function() {
            this.classList.forEach( function( cl ) {
                if (cl.indexOf( "column-" ) === 0 && columnClasses.indexOf( cl ) === -1) {
                    columnClasses.push( cl )
                }
            } )
        } )
        var $insertColTogglersBefore = jQuery( "span.tableCountInfo.florpFilterTable" + tableIndex )
        if ($insertColTogglersBefore.length === 0) {
            $insertColTogglersBefore = $table
        }
        if (columnClasses.length > 0) {
            var $colTogglerRow = jQuery( "<span class='columnTogglerRow'></span>" )
            $colTogglerRow.insertBefore( $insertColTogglersBefore )
            jQuery( "<span class='columnTogglerCheckboxWrapper'>Zobraziť stĺpce: </span>" ).appendTo( $colTogglerRow )
        }
        columnClasses.forEach( function( value, i ) {
            var label = value.replace( "column-", "" )
            var label = label.charAt( 0 ).toUpperCase() + label.slice( 1 )
            var checkboxSpan = jQuery( "<span class='columnTogglerCheckboxWrapper'><input type='checkbox' id='" + value + "-" + tableIndex + "' checked='checked' onchange='window.florpToggleColumns(this, \"" + value + "\", " + tableIndex + ")' /><label for='" + value + "-" + tableIndex + "'>" + label + "</label></span>" )
            checkboxSpan.appendTo( $colTogglerRow )
            if (window.florpIsHidden( value, tableIndex, "columns" )) {
                var checkbox = checkboxSpan.find( "input" )
                checkbox.prop( "checked", false ).trigger( "change" )
            }
        } )
        // if (columnClasses.length > 0) {
        //   jQuery("<span style='height: 0; clear: both; display: block;'></span>").insertBefore($insertColTogglersBefore)
        // }
        // END: Column toggling //

        var buttons = [], notices = [], hideByDefault = {}
        $table.find( "span.button.double-check,span.button.pop-in" ).each( function() {
            var $this = jQuery( this ),
                text = ("undefined" !== typeof $this.data( "text" ) && null !== $this.data( "text" )) ? $this.data( "text" ) : $this.data( "textDefault" )
            if (buttons.indexOf( text ) === -1) {
                buttons.push( text )
                if ($this.data( "hide" )) {
                    hideByDefault[text] = true
                }
            }
        } )
        $table.find( "span.notice" ).each( function() {
            var $this = jQuery( this ),
                text = ("undefined" !== typeof $this.data( "text" ) && null !== $this.data( "text" )) ? $this.data( "text" ) : $this.text(),
                i = buttons.indexOf( text )
            if (i === -1 && notices.indexOf( text ) === -1) {
                notices.push( text )
                if ($this.data( "hide" )) {
                    hideByDefault[text] = true
                }
            }
        } )

        if (Object.keys( hideByDefault ).length > 0) {
            var hideTexts = Object.keys( hideByDefault )
            var key = window.florpGetLocalStorageKey( tableIndex, "buttons" )
            var hidden = localStorage.getItem( key )
            if ("undefined" === typeof hidden || null === hidden) {
                localStorage.setItem( key, JSON.stringify( hideTexts ) )
            }
        }
        buttons.sort()
        notices.sort()

        if (buttons.length + notices.length > 0) {
            var $btnTogglerRow = jQuery( "<span class='buttonTogglerRow'></span>" )
            $btnTogglerRow.insertBefore( $insertColTogglersBefore )
            jQuery( "<span class='buttonTogglerCheckboxWrapper'>Zobraziť: </span>" ).appendTo( $btnTogglerRow )
        }
        buttons.forEach( function( value, i ) {
            var checkboxSpan = jQuery( "<span class='buttonTogglerCheckboxWrapper'><input type='checkbox' id='button-" + i + "-" + tableIndex + "' checked='checked' onchange='window.florpToggleButtons(this, \"" + value + "\", " + tableIndex + ")' /><label for='button-" + i + "-" + tableIndex + "'>" + value + "</label></span>" )
            checkboxSpan.appendTo( $btnTogglerRow )
            if (window.florpIsHidden( value, tableIndex, "buttons" )) {
                var checkbox = checkboxSpan.find( "input" )
                checkbox.prop( "checked", false ).trigger( "change" )
            }
        } )
        notices.forEach( function( value, i ) {
            var j = buttons.length + i
            var checkboxSpan = jQuery( "<span class='buttonTogglerCheckboxWrapper'><input type='checkbox' id='button-" + j + "-" + tableIndex + "' checked='checked' onchange='window.florpToggleNotices(this, \"" + value + "\", " + tableIndex + ")' /><label for='button-" + j + "-" + tableIndex + "'>" + value + "</label></span>" )
            checkboxSpan.appendTo( $btnTogglerRow )
            if (window.florpIsHidden( value, tableIndex, "buttons" )) {
                var checkbox = checkboxSpan.find( "input" )
                checkbox.prop( "checked", false ).trigger( "change" )
            }
        } )
        jQuery( "<span style='height: 0; clear: both; display: block;'></span>" ).insertBefore( $table )
        // console.log($table, buttons, notices)

        tableIndex++
    } )
} )

window.florpToggleButtons = function( checkbox, text, tableId ) {
    var elements = jQuery( "table.florpFilterTable" + tableId ).find( "span.button.double-check[data-text='" + text + "'],span.button.double-check[data-text-default='" + text + "'],span.button.pop-in[data-text='" + text + "'],span.button.pop-in[data-text-default='" + text + "'],span.notice[data-text='" + text + "'],span.notice:contains('" + text + "')" )
    if (jQuery( checkbox ).is( ":checked" )) {
        elements.removeClass( "hide" )
        window.florpSetUnhidden( text, tableId, "buttons" )
    } else {
        elements.addClass( "hide" )
        window.florpSetHidden( text, tableId, "buttons" )
    }
}
window.florpToggleNotices = function( checkbox, text, tableId ) {
    var elements = jQuery( "table.florpFilterTable" + tableId ).find( "span.notice[data-text='" + text + "'],span.notice:contains('" + text + "')" )
    if (jQuery( checkbox ).is( ":checked" )) {
        elements.removeClass( "hide" )
        window.florpSetUnhidden( text, tableId, "buttons" )
    } else {
        elements.addClass( "hide" )
        window.florpSetHidden( text, tableId, "buttons" )
    }
}
window.florpToggleColumns = function( checkbox, cl, tableId ) {
    var elements = jQuery( "table.florpFilterTable" + tableId ).find( "td." + cl + ",th." + cl )
    if (jQuery( checkbox ).is( ":checked" )) {
        elements.removeClass( "hide" )
        window.florpSetUnhidden( cl, tableId, "columns" )
    } else {
        elements.addClass( "hide" )
        window.florpSetHidden( cl, tableId, "columns" )
    }
}

window.florpGetLocalStorageKey = function( tableIndex, what = "buttons" ) {
    return window.location.pathname.split( '/' ).reverse()[0] + window.location.search + "-t" + tableIndex + "-hidden-" + what
}
window.florpIsHidden = function( text, tableIndex, what = "buttons", bDefault = false ) {
    var key = window.florpGetLocalStorageKey( tableIndex, what )
    var hidden = localStorage.getItem( key )
    if (hidden) {
        var aHidden = []
        try {
            aHidden = JSON.parse( hidden )
        } catch (e) {
        }
        if (aHidden.length === 0) {
            return bDefault
        }
        return -1 !== aHidden.indexOf( text )
    } else {
        return bDefault
    }
}
window.florpSetHidden = function( text, tableIndex, what = "buttons" ) {
    if (window.florpIsHidden( text, tableIndex, what )) {
        return
    }
    var key = window.florpGetLocalStorageKey( tableIndex, what )
    var hidden = localStorage.getItem( key )
    var aHidden = []
    if (hidden) {
        try {
            aHidden = JSON.parse( hidden )
        } catch (e) {
        }
    }
    aHidden.push( text )
    localStorage.setItem( key, JSON.stringify( aHidden ) )
}
window.florpSetUnhidden = function( text, tableIndex, what = "buttons" ) {
    if (!window.florpIsHidden( text, tableIndex, what )) {
        return
    }
    var key = window.florpGetLocalStorageKey( tableIndex, what )
    var hidden = localStorage.getItem( key )
    var aHidden = []
    if (hidden) {
        try {
            aHidden = JSON.parse( hidden )
        } catch (e) {
        }
    } else {
        return
    }
    if (aHidden.length === 0) {
        return
    }
    var i = aHidden.indexOf( text )
    aHidden.splice( i, 1 )
    localStorage.setItem( key, JSON.stringify( aHidden ) )
}
