document.getElementById('url-form').addEventListener("submit", function(evt) {
    evt.preventDefault();
    postData();
});

function postData() {

    var url = encodeURIComponent(document.getElementById("url").value);

    // Checks if fields are filled-in or not, returns response "<p>Please enter your details.</p>" if not.
    if (url == "") {
        document.getElementById("response").innerHTML = "<p>Please enter url.</p>";
        return;
    }

    // Parameters to send to PHP script. The bits in the "quotes" are the POST indexes to be sent to the PHP script.
    var params = "url=" + url;

    var http = new XMLHttpRequest();
    http.open("POST", "/create", true);

    // Set headers
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            document.getElementById("result").innerHTML = http.responseText;
        }
    }

    http.send(params);
}