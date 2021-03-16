function showLogin() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const loginstate = urlParams.get('state');
    const calstate = urlParams.get('c');
    if(loginstate=='S') {
        console.log(loginstate);
        $('#login').modal('show');
    } else if(loginstate=='F') {
        $('#inputToast').toast('show');
    } else if(loginstate =='L') {
        
        
        
        
        }
    }


    