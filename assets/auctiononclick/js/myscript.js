//----------------Header fix-------------------//
$(window).scroll(function(){
    if ($(window).scrollTop() >= 112)
    {
        $('.position-fix').addClass('fixed-header');
    }
    else {
        $('.position-fix').removeClass('fixed-header');
    }
});

//----------------Header fix End-------------------//

//----------------Side Navbar-----------------//
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


//----------------Side Navbar end-----------------//






















