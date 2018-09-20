jQuery( document ).ready(function() {
  var fnFlorpButtonLabel = function(strLabel, strInfo) {
    return strLabel + " ("+strInfo+")"
  }
  var fnFlorpShowMessage = function(strMessage, strMessageId, strType = "info", iTimeout = false, $insertBefore = false, bReplace = false, fadeOutCallback = undefined, iTableCell = false) {
    strType = strType || "info"
    strMessageId = strMessageId.replace(/[^a-zA-Z0-9_-]/g, "_")
    jQuery("#"+strMessageId).remove()
    var $msg
    if ("undefined" !== typeof iTableCell && false !== iTableCell) {
      var strColspan = ""
      if (iTableCell !== true && iTableCell > 1) {
        strColspan = " colspan='"+iTableCell+"'"
      }
      $msg = jQuery("<tr id='"+strMessageId+"'><td"+strColspan+"><div class='notice notice-"+strType+"'><p>"+strMessage+"</p></div></td></tr>")
    } else {
      $msg = jQuery("<div id='"+strMessageId+"' class='notice notice-"+strType+"'><p>"+strMessage+"</p></div>")
    }
    if ("undefined" === typeof window["florpAdminTimeouts"]) {
      window["florpAdminTimeouts"] = {}
    }
    if ("undefined" !== typeof $insertBefore && false !== $insertBefore && $insertBefore.length > 0) {
      if (bReplace) {
        $insertBefore.children().hide()
      }
      $msg.insertBefore($insertBefore)
    } else {
      $msg.insertBefore(jQuery(".wrap table"))
    }
    if ("undefined" !== typeof iTimeout && false !== iTimeout && iTimeout > 0) {
      window["florpAdminTimeouts"][strMessageId] = setTimeout(function(strMessageId, fadeOutCallbackLoc) {
        if ("undefined" !== typeof fadeOutCallbackLoc) {
          jQuery("#"+strMessageId).fadeOut(800, function() {
            fadeOutCallbackLoc()
            jQuery(this).remove()
          })
        } else {
          jQuery("#"+strMessageId).fadeOut(800, function() {
            jQuery(this).remove()
          })
        }
        window["florpAdminTimeouts"][strMessageId] = null
      }, iTimeout, strMessageId, fadeOutCallback)
    }
  }
  jQuery(".button.double-check").click(function() {
    var $this = jQuery(this)
    var data = $this.data()
    var sure = data.sure, strButtonId = data.buttonId, strRowId = data.rowId, strAction = data.action,
        textDoubleCheck = data.textDoubleCheck, textDefault = data.textDefault
    if ("undefined" === typeof strButtonId || "undefined" === typeof strRowId || "undefined" === typeof strAction) {
      console.warn("No buttonId, rowId or action!")
      console.log(data)
      return
    }
    if (data.useInputNames) {
      var strInputNames = data.useInputNames
      var bError = false
      jQuery.each(strInputNames.split(","), function(index, value) {
        var $input = jQuery("[data-row-id="+strRowId+"] [name="+value+"]")
        if ($input.length > 0) {
          var val = $input.val()
          if (val.length === 0) {
            console.warn("Required input with name = '"+value+"' is empty!")
            bError = true
            return false
          } else {
            data[value] = val
          }
        }
      })
      if (bError) {
        console.log(data)
        return
      }
    }
    if ("undefined" === typeof window[strButtonId]) {
      window[strButtonId] = {}
    }
    if ("undefined" !== typeof sure && 1 === sure) {
      if ("undefined" === typeof ajaxurl) {
        console.warn("No ajaxurl!")
      } else {
        $this.data("wait", 1)
        $this.text(fnFlorpButtonLabel(textDoubleCheck, "waiting for response..."))
        jQuery.post(ajaxurl, data, function(response) {
          if (response) {
            try{
              var aResponse = JSON.parse(response)
              // console.log(aResponse)
              var strMessageId = "florpMessage-"+aResponse.buttonId
              if (aResponse.ok) {
                var strButtonIdLocal = aResponse.buttonId
                clearInterval(window[strButtonIdLocal]["interval"])
                window[strButtonIdLocal]["interval"] = null
                var button = jQuery(".button.double-check[data-button-id="+aResponse.buttonId+"]")
                button.text(aResponse.textDefault).removeClass("button-primary").data("sure", 0)
                if (button.hasClass("button-warning-removed")) {
                  button.removeClass("button-warning-removed").addClass("button-warning")
                }
                var $row = jQuery(".row[data-row-id="+aResponse.rowId+"]")
                if (aResponse.removeRowOnSuccess && aResponse.removeRowOnSuccess === true) {
                  if ($row.length > 0) {
                    if (aResponse.message) {
                      fnFlorpShowMessage(aResponse.message, strMessageId+"-ok", "success", 2000, $row, true, function() {
                        $row.fadeOut(800)
                      }, $row.first()[0] && $row.first()[0].cells ? $row.first()[0].cells.length : false)
                    } else {
                      $row.fadeOut(800)
                    }
                  } else {
                    if (aResponse.message) {
                      fnFlorpShowMessage(aResponse.message, strMessageId+"-ok", "success", 2000)
                    }
                    console.warn("No row to fade out!")
                  }
                } else {
                  if (aResponse.message) {
                    fnFlorpShowMessage(aResponse.message, strMessageId+"-ok", "success", 2000, $row, false, function() {
                      if (aResponse.replaceButton && aResponse.replaceButtonHtml) {
                        var newButton = jQuery(aResponse.replaceButtonHtml)
                        newButton.insertBefore(button)
                        button.remove()
                      }
                      if (aResponse.hideSelector) {
                        jQuery( aResponse.hideSelector ).hide()
                      }
                      if (aResponse.insertAfterSelector && jQuery(aResponse.insertAfterSelector).length > 0 && aResponse.insertHtml) {
                        jQuery(aResponse.insertHtml).insertAfter(jQuery(aResponse.insertAfterSelector))
                      }
                      if (aResponse.useInputNames && aResponse.clearInputNames) {
                        var strInputNames = data.useInputNames
                        jQuery.each(strInputNames.split(","), function(index, value) {
                          var $input = jQuery("[data-row-id="+aResponse.rowId+"] [name="+value+"]")
                          if ($input.length > 0) {
                            $input.val("");
                          }
                        })
                      }
                    }, $row.first()[0] && $row.first()[0].cells ? $row.first()[0].cells.length : false)
                  } else {
                    if (aResponse.replaceButton && aResponse.replaceButtonHtml) {
                      var newButton = jQuery(aResponse.replaceButtonHtml)
                      newButton.insertBefore(button)
                      button.remove()
                    }
                    if (aResponse.hideSelector) {
                      jQuery( aResponse.hideSelector ).hide()
                    }
                    if (aResponse.insertAfterSelector && jQuery(aResponse.insertAfterSelector).length > 0 && aResponse.insertHtml) {
                      jQuery(aResponse.insertHtml).insertAfter(jQuery(aResponse.insertAfterSelector))
                    }
                    if (aResponse.useInputNames && aResponse.clearInputNames) {
                      var strInputNames = data.useInputNames
                      jQuery.each(strInputNames.split(","), function(index, value) {
                        var $input = jQuery("[data-row-id="+aResponse.rowId+"] [name="+value+"]")
                        if ($input.length > 0) {
                          $input.val("");
                        }
                      })
                    }
                  }
                }
              } else {
                if (aResponse.message) {
                  fnFlorpShowMessage(aResponse.message, strMessageId+"-error", "error", 10000)
                } else {
                  fnFlorpShowMessage("An error occured", strMessageId+"-error", "error", 10000)
                }
                console.log(aResponse)
              }
            } catch (e) {
              console.warn(e)
              console.log(response)
              fnFlorpShowMessage("An error occured", "exception-error", "error", 10000)
            }
          } else {
            console.warn("No response")
            fnFlorpShowMessage("An error occured", "no-response-error", "error", 10000)
          }
          $this.data("wait", 0)
        })
      }
    } else {
      window[strButtonId]["timeLeft"] = 5, window[strButtonId]["wait"] = 0, window[strButtonId]["timeout"] = 10
      $this.text(fnFlorpButtonLabel(textDoubleCheck, window[strButtonId]["timeLeft"])).addClass("button-primary").data("sure", 1).data("wait", 0)
      if ($this.hasClass("button-warning")) {
        $this.removeClass("button-warning").addClass("button-warning-removed")
      }

      window[strButtonId]["interval"] = setInterval(function() {
        wait = $this.data("wait")
        if ("undefined" !== typeof wait && wait === 1) {
          window[strButtonId]["wait"]++
          if (window[strButtonId]["wait"] >= window[strButtonId]["timeout"]) {
            clearInterval(window[strButtonId]["interval"])
            window[strButtonId]["interval"] = null
            $this.text(textDefault).removeClass("button-primary").data("sure", 0)
            if ($this.hasClass("button-warning-removed")) {
              $this.removeClass("button-warning-removed").addClass("button-warning")
            }
            fnFlorpShowMessage("The operation timed out", "timeout-error", "error", 10000)
          }
        } else {
          window[strButtonId]["timeLeft"]--
          if (window[strButtonId]["timeLeft"] <= 0) {
            clearInterval(window[strButtonId]["interval"])
            window[strButtonId]["interval"] = null
            $this.text(textDefault).removeClass("button-primary").data("sure", 0)
            if ($this.hasClass("button-warning-removed")) {
              $this.removeClass("button-warning-removed").addClass("button-warning")
            }
          } else {
            $this.text(fnFlorpButtonLabel(textDoubleCheck, window[strButtonId]["timeLeft"]))
          }
        }
//         console.log($this.data())
      }, 1000)
    }
  })

  // Filter for admin tables //
  var fnRemoveAccents = function( str ) {
    if ("string" !== typeof str) {
      return str
    }
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, "")
  }

  var $tables = jQuery("table")
  window["florpFilterColumnInputValues"] = {}
  if ($tables.length > 0) {
    function fnFlorpFilterRows() {
      var $this = jQuery( this )
      var val = fnRemoveAccents($this.val().trim()).toLowerCase()
      var tableId = $this.data("florpFilterTableId")
      var columnId = $this.data("florpFilterColumnId")
      if (window["florpFilterColumnInputValues"][tableId][columnId] === val) {
        // Don't reevaluate on the same value - mainly the case of multiple events firing for the same field //
        return
      }
      window["florpFilterColumnInputValues"][tableId][columnId] = val

      if (val === "") {
        // Show all rows hidden by this column //
        jQuery("tr.florpFilterRow.florpFilterTable"+tableId+".florpFilterHiddenColumn"+columnId).removeClass("florpFilterHiddenColumn"+columnId)
      } else {
        // Hide all //
        jQuery("tr.florpFilterRow.florpFilterTable"+tableId).addClass("florpFilterHiddenColumn"+columnId)

        // Show matching rows //
        jQuery("tr.florpFilterRow.florpFilterTable"+tableId+".florpFilterHiddenColumn"+columnId).filter(function() {
          var colHtml = jQuery(this).find("td.florpFilterCell.florpFilterColumn"+columnId).html()
          var $colClone = jQuery("<div>"+colHtml+"</div>")
          $colClone.find("br,span.button").remove()
          var colTxt = $colClone.text()
          if (!colTxt) {
            return false
          }
          return fnRemoveAccents(colTxt).toLowerCase().indexOf(val) !== -1
        }).removeClass("florpFilterHiddenColumn"+columnId)
      }

      jQuery("tr.florpFilterRow").each(function () {
        if (this.className.indexOf("florpFilterHiddenColumn") !== -1) {
          jQuery(this).addClass("florpFilterHidden")
        } else {
          jQuery(this).removeClass("florpFilterHidden")
        }
      })
    }

    $tables.each(function( it ) {
      window["florpFilterColumnInputValues"][it] = {}
      var $table = jQuery(this)
      var $rows = $table.find("tr")
      if ($rows.length === 0) {
        return false
      }

      var bInsertAfterFirstRow = false
      var $firstRow = $rows.first()
      var iColumns = $firstRow.find("th").length
      if (iColumns > 0) {
        bInsertAfterFirstRow = true
      } else {
        iColumns = $firstRow.find("td").length
      }
      if (iColumns === 0) {
        return false
      }
      var filterRowHtml = '<tr class="florpFilterHeaderRow">'
      for (var i = 0; i < iColumns; i++) {
        window["florpFilterColumnInputValues"][it][i] = ""
        var strPlaceholder = ''
        if (bInsertAfterFirstRow) {
          strPlaceholder = ' placeholder="Filter: '+jQuery($firstRow.find("th")[i]).text()+'"'
        }
        filterRowHtml += '<th class="florpFilterHeaderCell">'
        filterRowHtml += '<input class="florpFilterInput" type="text" data-florp-filter-table-id="'+it+'" data-florp-filter-column-id="'+i+'"'+strPlaceholder+'/>'
        filterRowHtml += "</th>"
      }
      filterRowHtml += "</tr>"
      var $filterRow = jQuery(filterRowHtml)
      if (bInsertAfterFirstRow) {
        $filterRow.insertAfter($firstRow)
      } else {
        $filterRow.insertBefore($firstRow)
      }

      $rows.each(function( ir ) {
        var $row = jQuery(this)
        if (ir !== 0 || !bInsertAfterFirstRow) {
          $row.addClass("florpFilterRow florpFilterTable"+it)
        }
        var $cells = $row.find("td")
        $cells.each(function( ic ) {
          var $cell = jQuery(this)
          $cell.data("florpFilterColumnId", ic).addClass("florpFilterCell florpFilterColumn"+ic+" florpFilterTable"+it)
        })
      })

      jQuery( document ).on( "change keyup paste input textInput", "input.florpFilterInput", fnFlorpFilterRows )
    })
  }
})
