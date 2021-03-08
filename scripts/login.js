function showLogin() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const loginstate = urlParams.get('state');
    
    if(loginstate=='S') {
        console.log(loginstate);
        $('#login').modal('show');
    } else if(loginstate=='F') {
    
    }
    }
    