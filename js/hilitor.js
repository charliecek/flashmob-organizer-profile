// Original JavaScript code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

function Hilitor( el, id, tag ) {

    // private variables
    var targetNode = el || document.getElementById( id ) || document.body
    var hiliteTag = tag || "MARK"
    var skipTags = new RegExp( "^(?:" + hiliteTag + "|SCRIPT|FORM)$" )
    var colors = colors || ["#ff6", "#a0ffff", "#9f9", "#f99", "#f6f"]
    var wordColor = []
    var colorIdx = 0
    var matchRegExp = ""
    var openLeft = false
    var openRight = false

    // characters to strip from start and end of the input string
    var endRegExp = new RegExp( '^[^\\w]+|[^\\w]+$', "g" )

    // characters used to break up the input string into words
    var breakRegExp = new RegExp( '[^\\w\'-]+', "g" )

    this.setColorCount = function( count ) {
        if (count && !isNaN( count ) && !isNaN( parseInt( count ) )) {
            colors.splice( parseInt( count ) )
        }

        return this
    }

    this.setEndRegExp = function( regex ) {
        endRegExp = regex
        return endRegExp
    }

    this.setBreakRegExp = function( regex ) {
        breakRegExp = regex
        return breakRegExp
    }

    this.setMatchType = function( type ) {
        switch (type) {
            case "left":
                this.openLeft = false
                this.openRight = true
                break

            case "right":
                this.openLeft = true
                this.openRight = false
                break

            case "open":
                this.openLeft = this.openRight = true
                break

            default:
                this.openLeft = this.openRight = false

        }

        return this
    }

    this.setRegex = function( input ) {
        input = input.replace( endRegExp, "" )
        input = input.replace( breakRegExp, "|" )
        input = input.replace( /^\||\|$/g, "" )
        if (input) {
            input = this.removeAccents( input )
            var re = "(" + input + ")"
            if (!this.openLeft) {
                re = "\\b" + re
            }
            if (!this.openRight) {
                re = re + "\\b"
            }
            matchRegExp = new RegExp( re, "i" )
            return matchRegExp
        }
        return false
    }

    this.getRegex = function() {
        var retval = matchRegExp.toString()
        retval = retval.replace( /(^\/(\\b)?|\(|\)|(\\b)?\/i$)/g, "" )
        retval = retval.replace( /\|/g, " " )
        return retval
    }

    this.removeAccents = function( str ) {
        if ("string" !== typeof str) {
            return str
        }
        return str.normalize( 'NFD' ).replace( /[\u0300-\u036f]/g, "" )
    }

    // recursively apply word highlighting
    this.hiliteWords = function( node ) {
        if (node === undefined || !node) return
        if (!matchRegExp) return
        if (skipTags.test( node.nodeName )) return

        if (node.hasChildNodes()) {
            for (var i = 0; i < node.childNodes.length; i++)
                this.hiliteWords( node.childNodes[i] )
        }
        if (node.nodeType == 3) { // NODE_TEXT
            if ((nv = this.removeAccents( node.nodeValue )) && (regs = matchRegExp.exec( nv ))) {
                if (!wordColor[regs[0].toLowerCase()]) {
                    wordColor[regs[0].toLowerCase()] = colors[colorIdx++ % colors.length]
                }

                var match = document.createElement( hiliteTag )
                match.appendChild( document.createTextNode( node.nodeValue.substr( regs.index, regs[0].length ) ) )
                match.style.backgroundColor = wordColor[regs[0].toLowerCase()]
                match.style.color = "#000"

                var after = node.splitText( regs.index )
                after.nodeValue = after.nodeValue.substring( regs[0].length )
                node.parentNode.insertBefore( match, after )
            }
        }

    }

    // remove highlighting
    this.remove = function() {
        var arr = targetNode.getElementsByTagName( hiliteTag )
        while (arr.length && (el = arr[0])) {
            var parent = el.parentNode
            parent.replaceChild( el.firstChild, el )
            parent.normalize()
        }

        return this
    }

    // start highlighting at target node
    this.apply = function( input ) {
        this.remove()
        if (input === undefined || !(input = input.replace( /(^\s+|\s+$)/g, "" ))) {
            return
        }
        if (this.setRegex( input )) {
            this.hiliteWords( targetNode )
        }

        return this
    }

}