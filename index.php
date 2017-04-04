<?php 
ini_set('display_errors', '');
error_reporting();
 error_reporting(E_STRICT | E_ALL);  

/**********************************************************************/
/*** I.        Standard Functions Available in KupieTools           ***/
/**********************************************************************/ /*
 Javascript functions provided to the user:
 getParams() - returns a hash of the current url params  
 getQuery() - returns value of parameter 'bs' from the URL that called the page  
 
 PHP functions available to the person adding their own code into this framework:
 curPageURL()- full URL (including parameters) of this file as it runs 
 curPageURLNoParams() same as above but without parameters, just the base URL of the file
 makeSafe("text string") - sanitize "text string" for output to prevent XSS attacks, etc.
 queryParameter() - returns value of parameter 'bs' from the URL that called the page
 */
 
/**********************************************************************/
/*** II.  Standard User Settable URL Parameters in KupieTools       ***/
/**********************************************************************/ /*
IE, for http://bsdetector.host.com/thisfile.php?param1&param2&param3
Where a param is...  It will do this...
c=is                 Install a custom search engine that queries this tool (Mozilla-based browsers only)
c=fbt                Output the image to be used as thumbnail when sharing this tool's URL on Facebook. Isn't that neat?
c=dl                 Download a copy of this php source code file
c=vh                 Output the version history (set in $user__versionHistory in III below)
c=d                  Display this documentation (not implemented yet)
bs=xxx               Set function queryParameter() to return "xxx"
any other parameter  If the parameter is of the form param=value, getParams()["param"] in javascript will return "value"

Not all of these may be mentioned in the UI. 

*/

/**********************************************************************/
/*** III.          Set User-Changeable Variables:                   ***/
/**********************************************************************/

/* If you work on this file, add lines to top of version history: */ 
$user__versionHistory = "
December 1, 2016 - moved to domain bsdetector.info and updated internal references
December 3, 2013 8:03:15 PM PDT - add warning about results page not loading in browsers that block mixed content and provide link to open in new window, bugfix for alert not appearing when bookmarklet triggered with no text selected
June 3, 2013 4:45:29 PM PDT - Add opensearch plugin link back to welcome page
June 2, 2013 8:21:52 PM PDT - work on documentation, continue work on making portable, strip CR & LF from queries
May 31, 2013 7:41:11 PM PDT - search form at upper right of results page wasn't working, remove final hardcoded references to original file - the code is totally portable!
May 30, 2013 9:14:12 PM PDT - Now displays version history when bookmarklet notifies of new version
May 29, 2013 9:56:06 PM PDT - Added PHP error output,moved stock graphics to SVG format and included in assignImage function
May 23, 2013 3:02:28 PM PDT - updated welcome text, added vh param to display version history
May 22, 2013 - released source code";

$user__toolName = "Internet BS Detector"; //full name of tool - INSERT THESE TOKENS THROUGHOUT FILE
$user__toolShortName = "BS Detector";     //short version of name for use in body text
$user__bookmarkletLabel = "Detect BS";    //text that appears on installable bookmarklet button

/* favicon url - url can be a php data URI or standard http:// image URL. You probably shouldn't futz with this. Look, right now this is an elegant, entirely self-contained tool. It's beautiful. You're not going to start linking to external resources, are you? */
$user__favIcon=
"data:image/icon;base64,R0lGODlhEAAQAPYAAAAAABISEnhDAH1FAH9aMYBGAIJJAIFOAIRIAIdMAIhPAYxMAYtRAY9SAY1UAY9YAJZPAJFSAJFUAJFWBpdXAJFYDJpaAJpbB51bAJpaDZ1bCpJaFpVdHZleFpZeIJhhJp9nJpllKppnLp5nLppjMpprNZxqMJxrN51uPKNjF6NrK6FuMalsO6h2PoNiRY5pQoFpUIdtV6N3Tat2QqeKbKCJcLOHarucgLqpl7usmqSlpsWwoMzBr93TyebZxeLX0PDp3+3u7vPw7fXx6/Pz8/X2+fX4+fj08f///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAnQB0kAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAAH/oBISEhISEgsR0hISEhISEhISEhISEhIGik3SEhISEhISEhISEhIOxYWGBBISEhISEhISEhISC8RFhYUNEhISEhISEhISDYqFhQUERNISEhISEhISEIXEhENDBMzGUhISEhISEgyAkAIDi0gQAgySEhISEhIDEA6QCsdQDpADEhISJAgIVECSQAkERYgCYDkhAEkSJAgWaAAiQ4iCTYQ0YFkwQIkSJAgGXAARxEZKEagMJKjwQAkSH6gMCEiRAwXBAgQgKHggIcGPT5wqODgAY8gQ4YE4THgw4YGCBY0YMCAwQIeQIDwWNCAAQMGBWoMMDBAwAABAxQkUJAAgYEDFUiS+JAxYcIEGTJ8+PDhQ4YMH0kCAQAh+QQJHgBDACwAAAAAEAAQAIYAAABKKwF4QwB/RwB/WjGARgCDSQCDTQCESACHTACKSQCJTQGLUQGPUgGNVAGWTwCRUgCRVACRVgaXVwCRWAyaWgCaWwedWwCaWg2dWwqSWhaVXR2ZXhaWXiCYYSafZyaZZSqeZy6aYzKaazWcajCebjqjYxejayuhbjGpbDuodj6DYkWOaUKBaVCHbVejd02rdkKnimygiXCzh2q7nIC6qZe7rJrFsKDDuKXMwa/d08nm2cXi19Dw6d/t7u7z8O318ev49PH///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH/oBCQkJCQkIpQUJCQkJCQkJCQkJCQkJCGSY0QkJCQkJCQkJCQkJCNxUVFw9CQkJCQkJCQkJCQiwQFRUTMUJCQkJCQkJCQjMnFRMTEDFCQkJCQkJCQj8WERANDBIwGEJCQkJCQkI4AgwIDiofDAg5QkJCQkJCDAwMDCgcDAwMDEJCQoQIETGCAQMGEBYwaMCghAEhQoQIWaAgAIMACTQEaBBgwQIhQoQIGXCgRoAXJUKwCGCjwQAhQniUIEEChIsVBAgQaNHgQIcGOjxsoCDBQQ4fQID4yDHAg4YGCBYwYMCAwYIcPXrkWNCAAYMFBWQUMDBAwAABAxIkSJAggYEDFUKG7HjhQIKEFy927Nix48WLHUMCAQA7";

/*** ENTER URL FOR FACEBOOK THUMBNAIL IMAGE BETWEEN QUOTES IN FOLLOWING BLOCK ***/
/*** url can be a php data URI or standard http:// image URL.                 ***/
/*** You don't reaaaaaallly want to change this, do you? **/
$user__facebookThumbnail = 
"data://image/GIF;base64,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";


/**********************************************************************/
/*** Set Variables User Can Change If They Have To, But Shouldn't:  ***/
/**********************************************************************/

/* Here is a reference timezone just so PHP doesn't complain - there's no real reason to ever change this, it doesn't affect anything important. */
date_default_timezone_set('America/Los_Angeles');

/* Specify original source URL. Right now this is not used or needed. Eventually, this will allow you & your downstream users can be notified of changes to the original master source code. 
$user__originalMasterSource = 'http://bsdetector.info/bsdetector.php'; */

$image_gplLogo = "data:image/GIF;base64,R0lGODlhfwAzAKECAL8AALwFAv///////yH+GkNyZWF0ZWQgd2l0aCBHSU1QIG9uIGEgTWFjACH5
BAEKAAIALAAAAAB/ADMAQAL+lI+py+0Po4Sg1gAgttPWKXiIx4XkiaafWYLHurQsuomvOmb3mai8
UOP5ZAdMICLz5XS7IXP269mgTstRClNktVllsVW1LnG3cdjL2DZkx64h8/vI36YXi17XRV0SousM
GChoFYBBMcWXGDPICEjV6ChhuNhF9laZkmOGOfj45OmgtrQ5RJr0ZNkUB/m51jqqSgJ7GYYQhMIV
y4qoGbr7W4Vny3h41QGMXGWs2MTMlwwd7VQIQM0w6SrN6vkLlShKO1I4Tj78SY7eSyvLHYnLDB6u
e/p0i0iPaO+0fp8qdVgvkCkY+HgFA7LNF0Azy7A8Q5UJC7uEHRpKHLisYKn+eaKmEGuX5tWYgRBL
HuT3rgzHRq6Q8HrQr5bLapckflQIggMxOTyuIAu5cSY8nnqYYMpoFE4GbHnocPLj7IvIh9q0GRka
L6rWrVtPbOAKNqzYsX9SfAVYNW0yIxa1tF2p1scRfVXL+oorsB3LPTnvTgX6lxIplCypOMuqMSZJ
daAIu+PLzwFTwXBngVRJmKSXiI7jZZXXueRizI3hsuMWuuPndZr3oKkzzyYZVm1fAm19+nJNjrJX
QXIJM/Hr4SZzd06971jw4iKhLh/I5fTvP8uZKzYdM+VI5GZNhXy+0iF24eAISvu+MPwO3OQvaGGf
d5HQyjeQykTeA/79GG90Ked8GhR4wnB3Enp94LWLT9HdFFJ/2ehHU2Yh6BWMamE4yBgIZ1kjjHnu
hXDWhO/poZIx9hSzmn/fEKWUiHDQ0gZNMU4oR0OowKaUcWE59x8gdAnyoxWccWWbIghGo1WRhx25
ViEuBEFWlFJeQ8IG4+g4ZQEAOw==";

?><?php 
function commandParameter() {if ($_GET["c"] == undefined) {return false;} else {return $_GET["c"];}}
function queryParameter() {if ($_GET["bs"] == undefined) {return "";} else {return $_GET["bs"];}} ?><?php 
if ($_GET["c"] == "fbt") {header('Content-disposition: inline; filename=bsdetector.gif');header('Content-type: image/GIF');readfile($user__facebookThumbnail);}  ?><?php 
if ($_GET["c"] == "dl") {header('Content-disposition: attachment; filename=bsdetector.php');header('Content-type: text/html');readfile(__FILE__);}  ?><?php 

function makeSafe($theString) {return htmlspecialchars($theString,ENT_QUOTES);}
 if (commandParameter() == "vh") {

echo "<pre>".makeSafe($user__versionHistory)."</pre>"; die;

 }; 
 /* To dos: "under the hood" section. Entry in my blog about including opensearch plugin into page. Search for everywhere 'bsdetector.php' is mentioned and make portable. something about how newer issues may not be in yet... maybe a tips sections? do one for synonyms antonyms etymology etc. with tabs separating each. Tabs 'top sources','all'. Do page 'KyoopTools' or 'KupieTools' hosting all "KupieTools a re bookmarklets that ... and allow install bookmarklet or search engine direct from page (which means php page will have to provide bookmarklet code like ti provides xml.) Serve favicon like fb thumbnail. Maybe call the word detective "Wordilie". Include tip 'to search for an exact phrase, put it in quotation marks'. label it "artisanal portable code" somewhere. Popup bookmarklet calculator, "KupieCalc".  Need a name for this type of software distribution... it's like the inverse of a virus... you spread it, you add a payload into it, people know it's there and choose to use it,  other people use it to intentionally download it and repost or add their own payload. Someday the code is all over the internet, helping people at their request, purely intentionally. */
 if (commandParameter() == "is") {function callback(){global $user__favIcon;return ('<SearchPlugin xmlns="http://www.mozilla.org/2006/browser/search/" xmlns:os="http://a9.com/-/spec/opensearch/1.1/"><os:ShortName>Internet BS Detector</os:ShortName><os:Description>Look up using BS Detector </os:Description><os:InputEncoding>UTF-8</os:InputEncoding><os:Image width="16" height="16" type="image/x-icon">'.$user__favIcon.' ?></os:Image><os:Url type="text/html" method="GET" template="'.curPageURLNoParams().'?bs={searchTerms}"></os:Url></SearchPlugin>');}
header('Content-type: application/opensearchdescription+xml'); ob_start("callback");} ?><html><head> <?php if ($_GET["bs"] == "") {echo '<title> Internet BS Detector - beta</title><meta property="og:title" content="Internet BS Detector - beta" /><meta property="og:description" content="The internet Bad Statement Detector is a tool to help you check the truth of any online information with credible, well-established research sites." />';} else {echo '<title> BS Detector results for &quot;'.makeSafe($_GET["bs"]).'&quot; </title><meta name="title" content="BS Detector results for &quot;'.makeSafe($_GET["bs"]).'&quot; - beta" /><meta name="description" content="Here are some links to helpful information on &quot;'.makeSafe($_GET["bs"]).'&quot; from credible, well-established research sites." />';} ?> <meta property="og:image" content="<?php echo curPageURLNoParams().'?c=fbt' ?>" /><link href='https://fonts.googleapis.com/css?family=Tinos' rel='stylesheet' type='text/css'>

<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];} else { $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];}
 return makeSafe($pageURL);}

function curPageURLNoParams() {
if ('http:/'.'/'.$_SERVER['HTTP_HOST'].$_SERVER[PHP_SELF] == 'http://bsdetector.info/bsdetector.php') { $theURL = 'http:/'.'/'.$_SERVER['HTTP_HOST'];} else {$theURL = 'http:/'.'/'.$_SERVER['HTTP_HOST'].$_SERVER[PHP_SELF];}
return makeSafe($theURL);
}
 ?>
<script>
function theQuery() {return <?php queryParameter() ?>
</script>

<script id="detectorsource">function () {
    var revision = "<?php $last_modified = date ('F d Y H:i:s.', filemtime(__FILE__)); print(makeSafe($last_modified)); ?>";
    var bmrevision = "<?php $last_modified = $_GET['dt']; print(makeSafe($last_modified)); ?>";
    var v = "1.3.2";
    var thisPage = "<?php echo (curPageURLNoParams()) ?>"
    // document.location.protocol + '//' + document.location.host + document.location.pathname;
    if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
    var done = false;
    var script = document.createElement("script");
    script.src = "https://ajax.googleapis.com/ajax/libs/jquery/" + v + "/jquery.min.js";
    script.onload = script.onreadystatechange = function () {
    if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
    done = true;
    bmklt() ;
    }
    };
    document.getElementsByTagName("head")[0].appendChild(script);
    } else {bmklt() ;}
    
    function bmklt() {
   
    if (jQuery("#b").length == 0) {
    var bssel = '';
     if (window.getSelection) { bssel = window.getSelection(); }
      if ( bssel =='' && !!document.getSelection) { bssel = document.getSelection(); } 
      if ( bssel =='' && !!document.selection) { bssel = document.selection.createRange().text; } 
      if ( bssel =='' && !!document.activeElement && document.activeElement.selectionStart) { bssel = document.activeElement.value.substring(document.activeElement.selectionStart,document.activeElement.selectionEnd); } 
      
       if ( bssel =='' && !!document.getElementById("__mkbsd_manentry1_a") && document.getElementById("__mkbsd_manentry1_a").value != "") {bssel= document.getElementById("__mkbsd_manentry1_a").value;}
    if ( bssel == '') {var theSuggestion="";
    if (document.location.search.replace("bs=","") !== document.location.search) { theSuggestion=("" + document.title).replace(" - Google Search", "");} else {theSuggestion = "Bigfoot is real";}
     bssel = prompt("No Bad Statement selected on page. Please enter your own BS and click 'OK'.", theSuggestion );
    }
    if (( bssel !== "") && ( bssel !== null)) {
    resultsUrlString = thisPage+"?bs=" + encodeURIComponent( bssel ).replace(/\%0a/gi, "") + "&bsdt=" + encodeURIComponent(document.title.replace('BS Detector results for ""', 'BS Detector Welcome Page'))  + "&bsdu=" + encodeURIComponent(document.location.href).replace("=","2kEQhere54theEQhere") + "&rd="+encodeURIComponent(revision);
    jQuery("body").append("\n <div id='b'>\n <div id='bdiv' style=''>\n <div id='closebutton'><img src='data:image/GIF;base64,R0lGODlhHAAcAKECAFFTUPz++gAAAAAAACH+GkNyZWF0ZWQgd2l0aCBHSU1QIG9uIGEgTWFjACH5BAEKAAAALAAAAAAcABwAAAJVhBOmy4uMXpsnqmgpxIlnDXgiBo7dSJkXuomt57AvV7mpKd84CdZ7H8MBZ7Rh0GYM/Yy7T6npnECLUpaqcfVRtbwjNUu0gLFTyRMGG6aVZnW0zUwYCgA7'></div> <p style='border: 2px solid rgba(0,0,0,.5); margin: -1px 0 0 -1px; color: black !important; '>Checking for BS...<br><img align='center' vspace=6 height=32 width=64 src='data:image/GIF;base64,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'>\n "+(thisPage.substr(0,5) == document.location.href.substr(0,5) ? "" : "<br><br><span style='font-weight:normal;font-size:.7em;'>Due to some browsers' security restrictions, the results page may not be able to load in this window. Click <a href='"+resultsUrlString+ "' target='_new' style='text-decoration:underline'>here</a> to open your BS Detector results in a separate window.</span>" )+"</p></div>\n <iframe src='"+resultsUrlString+"' onload=\"jQuery(' #b iframe').fadeIn(500);jQuery('#closebutton').fadeIn(500);\" style='background:#FFFFFF;'>Frames are blocked in your browser. Please enable iFrames, or click <a href='"+thisPage+"?bs=" +encodeURIComponent( bssel ) + "'>here</a> to view results.</iframe>\n <p style='font-size:.6em'>BS Detector version released: "+revision+"</p> <style type='text/css'>\n #bdiv { display: none; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background-color: rgba(0,0,0,.3); z-index: 900; }\n #bdiv p { font: normal normal bold 20px/20px Helvetica, sans-serif; position: absolute; top: 40%; left: 40%; width: 10em; padding: 12px; text-align: center;-moz-border-radius: 25px; -webkit-border-radius: 25px; -khtml-border-radius: 25px; border-radius: 25px; background: #f2f6f8; /* Old browsers */background: -moz-linear-gradient(top,  #f2f6f8 0%, #d8e1e7 50%, #b5c6d0 51%, #e0eff9 100%); /* FF3.6+ */ background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f2f6f8), color-stop(50%,#d8e1e7), color-stop(51%,#b5c6d0), color-stop(100%,#e0eff9)); /* Chrome,Safari4+ */ background: -webkit-linear-gradient(top,  #f2f6f8 0%,#d8e1e7 50%,#b5c6d0 51%,#e0eff9 100%); /* Chrome10+,Safari5.1+ */ background: -o-linear-gradient(top,  #f2f6f8 0%,#d8e1e7 50%,#b5c6d0 51%,#e0eff9 100%); /* Opera 11.10+ */ background: -ms-linear-gradient(top,  #f2f6f8 0%,#d8e1e7 50%,#b5c6d0 51%,#e0eff9 100%); /* IE10+ */ background: linear-gradient(to bottom,  #f2f6f8 0%,#d8e1e7 50%,#b5c6d0 51%,#e0eff9 100%); /* W3C */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f6f8', endColorstr='#e0eff9',GradientType=0 ); /* IE6-9 */ box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -moz-box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -webkit-box-shadow: 0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; text-shadow: 0 1px 2px #fff;}\n  #b iframe {  color: #0000aa; padding: .5em 1em; background: #cccccc; background: -moz-linear-gradient( top, #ffffff 0%, #ebebeb 50%, #dbdbdb 50%, #b5b5b5); background: -webkit-gradient( linear, left top, left bottom, from(#ffffff), color-stop(0.50, #ebebeb), color-stop(0.50, #dbdbdb), to(#b5b5b5)); -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; border: 1px solid #949494; -moz-box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); -webkit-box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); text-shadow: 0px -1px 0px rgba(000,000,000,0.2), 0px 1px 0px rgba(255,255,255,1); display: none; position: fixed; top: 10%; left: 10%; width: 80%; height: 80%; z-index: 902; border: 2px solid rgba(0,0,0,.2); margin: -5px 0 0 -5px; -moz-border-radius: 30px; -webkit-border-radius: 30px; -khtml-border-radius: 30px; border-radius: 30px;box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -moz-box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -webkit-box-shadow: 0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918;    text-shadow: 0 1px 2px #fff;}\n #closebutton{line-height:200px;margin:0px;padding:0px;border: 5px solid rgba(255,255,255,1); text-align:center;color:#FFF;font: normal normal bold 36px Helvetica;width:30px;height:30px;background:#444;display:none;position:fixed;top: 2%; right:2%; cursor:pointer; z-index:999;-moz-border-radius: 36px; -webkit-border-radius: 36px; -khtml-border-radius: 36px; border-radius: 36px;box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -moz-box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918; -webkit-box-shadow: 0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 12px 16px #090918;    text-shadow: 0 1px 2px #fff;} #closebutton span { height: 30px; display: inline-block; zoom: 1; *display: inline; vertical-align: middle; } #closebutton p { display: inline-block; zoom: 1; *display: inline; vertical-align: middle; color: #fff; }</style>\n </div>");
    jQuery("#bdiv").fadeIn(600);
    jQuery("#b #closebutton").fadeIn(600);
    }
    } else {
    jQuery("#bdiv").fadeOut(600);
    jQuery(" #b iframe").slideUp(500);
    setTimeout("jQuery('#b').remove()", 600);
    }
    jQuery("#bdiv,.closebutton").click(function (event) {
    jQuery("#bdiv").fadeOut(600);
    jQuery("#b iframe").slideUp(500);
    setTimeout("jQuery('#b').remove()", 600);
    });
    
    }
  
}
</script>
<script>function assignCX() {return '010962139000250496423:fbjyhlfv_4k';}</script>
<script>function writeAnchor(theLabel) {var lText=''; if(theLabel==""){lText=theLabel;}else{lText='<?php echo $user__bookmarkletLabel ?>';}document.write('<a class="bsbutton" href="javascript:('+encodeURIComponent(document.getElementById("detectorsource").innerHTML)+')();">'+lText+'</a>');} </script>

<!-- begin gCSE code -->
<script type="text/javascript"> (function() {var newgScript = document.createElement('script'); newgScript.type = 'text/javascript'; newgScript.async = true; newgScript.src = "http" + (document.location.protocol == 'https:' ? 's' : '') + '://www.google.com/cse/cse.js?cx=' + assignCX();  document.getElementsByTagName('script')[0].parentNode.insertBefore(newgScript, document.getElementsByTagName('script')[0]); })(); 
<!-- end gCSE code -->
function getQuery() {return "<?php echo queryParameter(); ?>";}
function getParams() {var params = {};
if (location.search) { var parts = location.search.substring(1).split('&');
    for (var i = 0; i < parts.length; i++) { var nv = parts[i].split('=');
    if (!nv[0]) continue;
    params[nv[0]] = nv[1] || true;
    }
} 

if(params.bsdu!== undefined) {params.bsdu = params.bsdu.replace("2kEQhere54theEQhere","=");}
return params;
}

</script>

<script type="text/javascript">

function addEngine(){ if ((typeof window.sidebar == "object") && (typeof window.sidebar.addSearchEngine == "function")) { window.sidebar.addSearchEngine( "<?php echo (__file__); ?>?c=is", "", "BS Detector", 0);

 } else {alert("Sorry, you need a Mozilla-based browser to install a search plugin."); } } 
</script>

 <link rel="shortcut icon" href="<?php echo $user__favIcon; ?>" type="image/x-icon" />
 <style>#wantmore {width:20%;float:right;font-size:.9em; padding:12px;line-height:1.2em;}
 #wantmore h3 {color:#FF7787;}
 #wantmore, #bwelcome {
 background: #ffdded; /* Old browsers */
background: -moz-linear-gradient(top,  #ffdded 0%, #ffbcdb 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffdded), color-stop(100%,#ffbcdb)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffdded 0%,#ffbcdb 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffdded 0%,#ffbcdb 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffdded 0%,#ffbcdb 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffdded 0%,#ffbcdb 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffdded', endColorstr='#ffbcdb',GradientType=0 ); /* IE6-9 */

-moz-border-radius: 15px; -webkit-border-radius: 15px; -khtml-border-radius: 15px; border-radius: 15px; }

#bwelcome {padding:12px;position:relative;z-index:1;}

#gsc-above-wrapper-area {height:16px;background:#ff0000;}
 
#upgradeWarning  {border:solid 1px #c00;font-size:.7em;color:#c00;font-family:helvetica,arial,sans;padding:4px;margin-top:-3px;margin-bottom:12px;-moz-border-radius: 9px; -webkit-border-radius: 9px; -khtml-border-radius: 9px; border-radius: 9px;box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777,0px 8px 8px #090918; -moz-box-shadow:0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777,0px 8px 8px #090918; -webkit-box-shadow: 0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777,0px 8px 8px #090918;}
 
body {
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f3f3f3), color-stop(51%,#ededed), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

}
xdiv {background: -moz-linear-gradient(top,  rgba(30,87,153,0.01) 0%, rgba(125,185,232,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(30,87,153,0.01)), color-stop(100%,rgba(125,185,232,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  rgba(30,87,153,0.01) 0%,rgba(125,185,232,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  rgba(30,87,153,0.01) 0%,rgba(125,185,232,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  rgba(30,87,153,0.01) 0%,rgba(125,185,232,0) 100%); /* IE10+ */
background: linear-gradient(to bottom,  rgba(30,87,153,0.01) 0%,rgba(125,185,232,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#031e5799', endColorstr='#007db9e8',GradientType=0 ); /* IE6-9 */

}

.quickSearchBox {position:absolute;right:12px;top:12px;width:30%;font-size:.8em;-moz-border-radius: 8px; -webkit-border-radius: 12px; -khtml-border-radius:12px; border-radius:12px; background:#FFF;padding:2px;height:1.8em;}

.quickSearchBox:before, .quickSearchBox:after
{
	position: absolute;
	width: 40%;
	height: 10px;
	content: ' ';
	left: 12px;
	bottom: 12px;
	background: transparent;
	-webkit-transform: skew(-5deg) rotate(-5deg);
	-moz-transform: skew(-5deg) rotate(-5deg);
	-ms-transform: skew(-5deg) rotate(-5deg);
	-o-transform: skew(-5deg) rotate(-5deg);
	transform: skew(-5deg) rotate(-5deg);
	-webkit-box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
	-moz-box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
	box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
	z-index: -1;
}
.quickSearchBox:after
{
	left: auto;
	right: 12px;
	-webkit-transform: skew(5deg) rotate(5deg);
	-moz-transform: skew(5deg) rotate(5deg);
	-ms-transform: skew(5deg) rotate(5deg);
	-o-transform: skew(5deg) rotate(5deg);
	transform: skew(5deg) rotate(5deg);
}

a.bsbutton {font-size:.7em;
 color: #0000aa; padding: .5em 1em; background: #cccccc; background: -moz-linear-gradient( top, #ffffff 0%, #ebebeb 50%, #dbdbdb 50%, #b5b5b5); background: -webkit-gradient( linear, left top, left bottom, from(#ffffff), color-stop(0.50, #ebebeb), color-stop(0.50, #dbdbdb), to(#b5b5b5)); -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; border: 1px solid #949494; -moz-box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); -webkit-box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); box-shadow: 0px 1px 2px rgba(000,000,000,0.5), inset 0px 0px 2px rgba(255,255,255,1); text-shadow: 0px -1px 0px rgba(000,000,000,0.2), 0px 1px 0px rgba(255,255,255,1); }

</style>
<link rel="search" type="application/opensearchdescription+xml" title="BS Detector" href="<?php echo (__file__); ?>/?c=is"></head><body>
 
<div id="bwelcome" style=" margin-bottom:12px; display:none;"><div align="center" class="curlShadow quickSearchBox"><form method="get" action="<?php echo (curPageURL()); ?>"> Quick BS Detect: <input type="text" NAME="bs" value=""><script>document.write('<button type="submit">');</script> search now</button></form></div><center><h3>Welcome to the internet Bad Statements Detector! <sup style="color:red;font-size:.6em;">BETA</sup></h3></center>This page helps you check information you find on the internet. It's meant to help people stop passing along things on the internet that aren't true. If you check things with the BS Detector before you post them on Facebook, your friends might thank you for it.<p><b>Instructions: <span style="color:#FF7787">First, test it out.</span></b> Here are some sample phrases you might see on the web, for you to test. Select one of these phrases by clicking on it and dragging over it with your mouse to select it, then click the "Detect BS" button, and it will show you related links about it from Snopes.com and similar reputable sites: <p><table width="100%" border=0 cellspacing=0 cellpadding=0><tr><td><ul><li>Swimming after you eat<li>Reptilian people <li>Poison in green tomatoes<li>Hillary Clinton is dead<li>Donald Trump groped RuPaul<li>UFO crash in Roswell, NM<li>Dial 112 in an emergency<li>Vaccines cause autism<!-- li>The Pope endorsed Donald Trump --><li>Bill Gates will pay you $5000 to forward an email<li>the illuminati<li>NaturalNews.com<li>Energy healing<li>Health tips from Sheryl Crow</ul></td><td valign="middle" align="center"><span style="font-size:1.5em;"><script>writeAnchor();</script></span> <i><p>&nbsp;(If you click the "Detect BS" link without selecting a<br> phrase first, it will ask you to type something in by hand.)</i></td></tr></table><p><b><span style="color:#FF7787">Then, grab a copy you can use anywhere:</span></b> <b>Once you see how it works, you can drag the "Detect BS" button above to your bookmarks bar, so you always have it available.</b> Then, you can use your mouse to select words on any page on the web, and click the Detect BS link in your bookmark bar to check out if they're BS.	<p>
				<b>FIREFOX ONLY:</b> Install the BS Detector <a href="javascript:addEngine();">OpenSearch plugin</a> to add the BS Detector as an option in your Firefox search box.</b></div><div id="share"><script> var revision = "<?php $last_modified = date ('F d Y H:i:s.', filemtime(__FILE__)); print($last_modified); ?>";
    var bmrevision = "<?php $last_modified = $_GET['rd']; print($last_modified); ?>";
    if (bmrevision != "" && bmrevision !== revision) {
    
    function versionAlert() {if(document.getElementById("vNotes").style.display=="none") {document.getElementById("vNotes").style.display="inline";document.getElementById("bTriangle").innerHTML="&blacktriangle;";} else {document.getElementById("vNotes").style.display="none";document.getElementById("bTriangle").innerHTML="&blacktriangledown;";}}
    
    document.write('<div id="upgradeWarning"> <b>Hi there!</b> There is a <a href="#" onclick="versionAlert();">newer version<span id="bTriangle">&blacktriangledown;</span></a> of the BS Detector available. You can get it by deleting your &quot;Detect BS&quot; bookmark from your bookmark bar and dragging this button up to its place: ');writeAnchor();document.write(" &nbsp;&nbsp;<span style='font-size:1.4em;cursor:pointer' onclick='document.getElementById(\"upgradeWarning\").style.display=\"none\"'>close &#x2612</span><div id='vNotes' style='display:none'><p>Your version: updated "+bmrevision+"<br>Available version: updated "+revision+"<p>Notes:<br><iframe width='100%' src='<?php curPageURLNoParams(); ?>?c=vh'></iframe></div></div>");}</script><div style="text-align:right; width:40%; float:right; margin-right:15px;height:30px"><!-- table bgcolor="#CCCCCC" border=0><tr><td align="right" --><form action="<?php echo (curPageURL()); ?>">Search again: <input type="text" id="theSearchBox" name="bs" width=150 value=""><?php foreach($_GET as $key=>$value){if ($key != "bs") {echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';}} ?><button type="submit">Get Results</button><br><font size="-1"><a href="javascript:document.getElementById('bwelcome').style.display='block';void 0;">show instructions</a></font></form><!-- /td></tr></table --><br></div><font size="+1"><b>The following references for <script type="text/javascript">var params = getParams();
document.getElementById("theSearchBox").value=(params.bs ? decodeURIComponent(params.bs.replace(/\+/g," ")) : "Bigfoot is chasing me!");

document.write('<i>'+decodeURIComponent(params.bs.replace(/\+/g," "))+'</i>');</script> have been found on sites that debunk internet myths, hoaxes, urban legends, and other BS:</b></font><p><font size="-1">Note: you have to actually click through and read the articles, not just these headlines, because some sites give myths in the headlines, and then debunk them in the accompanying articles. <b>Just because the headline says it, that doesn't mean the article is saying it's true!</b><p></font> <div style="float:left;width:76%"><gcse:searchresults-only noResultsString="No results found. None of the sites the BS detector uses have written about this topic (yet.)"></gcse:searchresults-only>

<font size="-1"><i>Note: anything you read in these results may be BS too! You have to use your </i><b>brain</b><i>! <b>The BS Detector is meant to be a guide, not a substitute for conscious thought and reasoning.</b><!--  You might want to try sorting by 'date' instead of 'relevance' to get the most current info. --></i></font><p></div><div id="wantmore"><hr><h3>
		Share it!
	</h3><b>Now that you've checked your information - and <i>thank you for doing that</i> - if you still want to, you can <script type="text/javascript">var params = getParams();if (params.bsdt != undefined) {document.write('<a href="http://www.facebook.com/sharer/sharer.php?u='+params.bsdu+'" target="_new">');document.write('share the previous page</a> &quot;');document.write(decodeURIComponent(params.bsdt));document.write('&quot; on Facebook. Or, you can');}</script> <script type="text/javascript">var params = getParams();
document.write('<a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='+encodeURIComponent(document.location.href)+'&p[title]='+encodeURIComponent("BS Detector search results for ")+'%22'+params.bs+'%22&p[summary]='+encodeURIComponent("Here's some links to helpful information on "+decodeURIComponent(params.bs)+" from credible, well-established research sites.")+'" target="_new">');</script>share this results page</a> on Facebook to show it to someone else, <script type="text/javascript">var params = getParams();
document.write('<a href="mailto:?body='+encodeURIComponent('Here are some links to helpful information on "'+decodeURIComponent(params.bs)+'" from credible, well-established research sites: \n\n')+encodeURIComponent(document.location.href)+'&subject='+encodeURIComponent("BS Detector search results for ")+'%22'+params.bs+'%22">');</script>email it</a>, or copy the URL to your clipboard by hand: <script>thisURL=document.location.protocol + '//' + document.location.host + document.location.pathname+document.location.search;document.write("<textarea rows='2' id='URLinput' style='font: normal normal .7em sans-serif;width:100%;' onclick='this.select()'>"+thisURL+"</textarea>")</script></b><hr></p><p>

	<h3>
		Want more?
	</h3>
	<p>
		<a name="bookmarklet">You</a> can grab a copy of this bookmarklet to be able to Detect BS on your own. Just drag this button to 
		
			your Bookmarks bar:<nobr style="line-spacing:2.2em;">&nbsp;<script>
writeAnchor();
			</script>
			Detect BS</a>&nbsp;</nobr> and then 
			<script>
thisURL=document.location.protocol + '//' + document.location.host + document.location.pathname;document.write('<a href="'+thisURL+'" target="_new">read the instructions</a>');
			</script>
			<p>
				<b>FIREFOX ONLY:</b> Install the BS Detector <a href="javascript:addEngine();">OpenSearch plugin</a> to add the BS Detector as an option in your Firefox search box.</b>
			</div>
<script id="starter">var params = getParams();if (params.welcome ||params.bs == undefined ) {document.getElementById("bwelcome").style.display="block";document.title = "Internet BS Detector (beta) - Welcome Page";}
if (params.bs == undefined ) {document.getElementById("share").style.display="none";
document.getElementById("theSearchBox").value="Bigfoot is chasing me!";}</script>

<!-- LICENSE BLOCK BEGINS HERE. DO NOT ALTER THIS SECTION. -->
<div style="padding:12px;width:20%;float:right;opacity:.6;align:center;font: normal normal .5em Helvetica, sans-serif"><a rel="license" href="http://www.gnu.org/licenses/gpl.html"><img alt="GPLv3 License" align="center" width="50%" style="border-width:0" src="http://www.gnu.org/graphics/gplv3-127x51.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Internet BS Detector</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.kupietz.com" property="cc:attributionName" rel="cc:attributionURL" target="_new">Mike Kupietz</a>, This is free software; you can redistribute it and/or modify it
under the terms of the <a
href="http://www.gnu.org/licenses/gpl-3.0.html" rel="license">GNU
General Public License</a> as published by the Free Software
Foundation; either version 3 of the License, or (at your option)
any later version. <a href="mailto:bsd-513-sp@kupietz.com">Email the author</a>.<p></div>
<!-- END LICENSE BLOCK -->

<script type="text/javascript"><!--
google_ad_client = "ca-pub-1917326431230348";
/* dummy ad */ 
google_ad_slot = "6711823110";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<!-- div style="font: normal normal .5em Helvetica, sans-serif;">If you need to copy this page's full URL: <script>thisURL=document.location.protocol + '//' + document.location.host + document.location.pathname+encodeURI(document.location.search);document.write("<input type='text'  style='font: normal normal 1em Helvetica, sans-serif;width:"+(thisURL.length*4 < 200?thisURL.length*4 : 200) +"' value='"+thisURL+"'")</script></div -->

<div style="float:right;width:100%;"><center><i>&#3898; &ldquo;In the age of information, ignorance is a choice.&rdquo; --Anon. &#3899;</i></center></div>
</body>
</html>

<!-- "My problem isn't piracy, it's obscurity." -Tim O'Reilly -->

<!-- [19:37:40.772] document.getElementById("___gcse_0")document.getElementsByClassName("gsc-table-result") -->
