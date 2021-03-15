function showLogin() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const loginstate = urlParams.get('state');
    const calstate = urlParams.get('c');
    if(loginstate=='S') {
        console.log(loginstate);
        $('#login').modal('show');
    } else if(loginstate=='F') {
        
    } else if(loginstate =='L') {
        

        }
    }

    if(calstate=='S') {
        console.log('c');
        
    } else if (calstate=='F'){
        $('#newExperiment').modal('show');
        var modal = document.getElementById('newExperiment')
        document.getElementById('newExpFeedback').text('Input failed')
    }

    