/**
 *
 * @access public
 * @return void
 **/
function addLanguage(){
    var $shortcut = prompt("Enter the shortcut (example: EN = English )of your Language here:")
    //$shortcut = $shortcut.substr(0,2);
    $subform = document.silexTranslation;
    $shortcut = $shortcut.toLowerCase();
    $subform.action = $subform.action + "&destination=" + $shortcut + ".txt";
    $subform.submit();
}

function SubmitToCommunity(){
    alert('this function is coming soon!');
}

/**
    function UI_Translation (){

        // create a handle for the document
        if(document.all){
            docHandle = document.all;
        }
        else{
            docHandle = document;
        }

        // create a handle for Navigation
        naviHandle = docHandle.getElementById('Navigationbar');

        // AddLanguage - to add a new Language into SILEX

        AddLanguage  = function (){
            var $name = prompt( "Insert the language name!" );
            var $filename = prompt( "Insert the shortcut of the new language (DE = Deutsch, EN = English, etc...)" )
            //var $handle = docHandle.getElementsByName("SilexTranslation");
            //alert( loacation.search );
        }

        // ToggleLine - Hide's a specified line
        ToggleLine = function( $lineNumber ){}

        ToggleNavigation = function(){}

        NavigationReposition = function( $x , $y , $z ){}

        SubmitToCommunity = function (){}

        Submit = function(){}

    }

    SILEX_JS_TOOLS = function(){

        CssSplit = function( $string ){
            $newString = $string.split(";");
            altert( $newString.constructor );
            for (var $sc = 0; $sc < $string.lenght; $sc++){
                $dump = $newString[ $sc ].split( ":" );
                $string[ $dump[ 0 ] ] = $dump[ 1 ];
            }
            return $string;
        }

        CssMerge = function( $array ){

        }

    }
**/