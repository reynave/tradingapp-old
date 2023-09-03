function handleCredentialResponse(res) {
    console.log(res);
    if (res['clientId'] == clientId) {
        let data = res['credential'];
        console.log("clientId valid");
        $.ajax({
            type: "POST",
            url: api + "login/auth0",
            data: { 
                data: res['credential'] 
            },
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                localStorage.setItem("app.mirrel.com",data['token']);
                setTimeout(()=>{
                    location.href =  home+"/login?id="+data['accountTokenId'];
                },500)
            },
            error: function(e){
                console.log(e.responseJSON.message);
                console.log(e);
            }

        });

      

    } else {
        console.log("clientId not valid");
    }
}

 

