/*UTILITY FUNCTIONS */

function toggleDarkmode() {
    var b = (getCookie('darkMode')=='false');
    if(b){
        document.cookie= 'darkMode=true';
    } else {
        document.cookie= 'darkMode=false';
    }
    
    
}
$(document).ready(function(){
    var c = (getCookie('darkMode')=='false');
    if(c==null) {
        document.cookie = "darkMode=false";
    } 
    
    if(c){
        console.log((getCookie("darkMode")));
        var element = document.body;
        element.classList.toggle("dark-mode");
    }
 })

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
