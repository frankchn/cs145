/* Getting Query String from URL
   http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values
 */
var qs = (function(a) {
    if (a == "") return {};
    var b = {};
    for (var i = 0; i < a.length; ++i)
    {
        var p=a[i].split('=');
        if (p.length != 2) continue;
        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
    }
    return b;
})(window.location.search.substr(1).split('&'));

google.load('search', '1');
var imageSearch;

function GISOnLoad() {
    imageSearch = new google.search.ImageSearch();
    google.search.Search.getBranding('branding');
}
google.setOnLoadCallback(GISOnLoad);