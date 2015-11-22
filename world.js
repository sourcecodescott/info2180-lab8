// On load, set button handler
window.onload = function () {
    $$('#lookup')[0].onclick = lookupClick;
};

// Some variables
var term;       // The search term (Country name)
var all;        // The all checkbox
var formatXML;  // The XML format checkbox

// Lookup button handler
function lookupClick() {
    // Set variables
    term = $$('#term')[0].value;
    all = $$("#all")[0];
    formatXML = $$("#format")[0];

    // Set base request string for AJAX
    var requestString = "https://lab8-sourcecodescott.c9users.io/world.php";
    var optCnt = 0;

    // If there are any parameters, prepare to add them to string above
    if ((term !== '') || (all.checked === true || (formatXML.checked === true))) {
        requestString += "?";
    }

    if (term !== '') {                               // Adds lookup term
        requestString += "lookup=" + term;
        optCnt++;
    }
    if (all.checked === true) {                        // Adds all=true
        if (optCnt > 0) {
            requestString += "&";
        }
        requestString += "all=" + all.checked;
        optCnt++;
    }
    if (formatXML.checked === true) {                  // Adds format=xml
        if (optCnt > 0) {
            requestString += "&";
        }
        requestString += "format=" + formatXML.value;
    }

    // Create AJAX request object
    new Ajax.Request(requestString,
        {
            method: "get",
            onSuccess: updateInfo,          // NOTE: can switch to using alert box display by replacing with 'alertInfo' function.
            onFailure: ajaxFailure,
            onException: ajaxFailure
        }
        );
}

// Display response content in an alert dialog box
// ( Now modified to behave similarly to updateInfo() )
function alertInfo(ajax) {
    if (formatXML.checked) {
        window.alert(ajax.responseXML);
    } else {
        window.alert(ajax.responseText);
    }
}

// Inserts appropriate response content into 'results' div
function updateInfo(ajax) {
    if (formatXML.checked) {
        $$("#result")[0].innerHTML = ajax.responseXML;
    } else {
        $$("#result")[0].innerHTML = ajax.responseText;
    }
}

// In case ajax request doesn't work.
function ajaxFailure(ajax, exception) {
    alert("Ajax request error: \n\nServer status: " + ajax.status + " " + ajax.statusText +
    "\n\nServer Response: " + ajax.responseText);
}