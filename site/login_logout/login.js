const urlParams = new URLSearchParams(window.location.search);

if(urlParams.get("logout")) {
    $.ajax({
        url: "logout.php",
        type:"GET",
        dataType: "json",
        success: (res) => {
            //if (res.sucess) 
            localStorage.removeitem("user");
        }
    });
}

$("form").submit((event) => {
    event.preventDefault();
    $.ajax({
        url:"login.php",
        type: "POST",
        dataType:"json",
        data: {
            username_email: $("#username_email").val(),
            pwd: $("#pwd").val(),
        },
        success: (res) => {
            if (res.success) {
                localStorage.setItem("user",JSON.stringify(res.user));
                window.location.replace("../page_acceuil/page_acceuil.html");
            }else{
                alert(res.error);
            }
        }
    })
})