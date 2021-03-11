function setTimeProtocol() {
  var minTime = document.getElementById("labtimeStart").value;
  document.getElementById("labtimeEnd").setAttribute('min', minTime);
  document.getElementById("labtimeEnd").value = minTime;
}


function earliestDate() {
  // Use Javascript
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
  var yyyy = today.getFullYear();
  if(dd<10){
    dd='0'+dd
  } 
  if(mm<10){
    mm='0'+mm
  } 

  today = yyyy+'-'+mm+'-'+dd;
  document.getElementById("labdate").setAttribute("min", today);
}

function validateProtocol() {
  var invalue = document.getElementById("protocolName").value
  if(data.indexOf(invalue)>-1 && invalue != ""){
    document.getElementById("protocolName").setCustomValidity("");

  } else {
    document.getElementById("protocolName").setCustomValidity("Invalid field.");
  }
}



