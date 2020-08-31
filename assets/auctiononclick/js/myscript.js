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
$('body').on('click', function(){
    if( parseInt( $('#mySidenav').css('width') ) > 0 ){
        closeNav();
    }
});

//---------------------accordion--------------------------------------//


$(function() {
    $("#accordion > h3").on("click", function(e) {
        $(this).next().slideToggle(function(e) {
            if ($(this).is(":visible")) {
                $(this).addClass("ui-accordion-content-active")
                    .prev().toggleClass("ui-corner-all ui-corner-top").addClass("ui-accordion-header-active ui-state-active")
                    .children(".ui-accordion-header-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s");
            }
            else {
                $(this).removeClass("ui-accordion-content-active")
                    .prev().toggleClass("ui-corner-all ui-corner-top").removeClass("ui-accordion-header-active ui-state-active")
                    .children(".ui-accordion-header-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s");
            }
        });
    })
        .hover(function(e) { $(this).toggleClass("ui-state-hover"); });
})
/*    Strictly for Them Selector (Nothing to do with accordion)    */
$("select").change(function(e) {
    var thmURL = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/{theme}/jquery-ui.css".replace("{theme}", $(this).val()),
        thmLink = $("<link />", { id: "ui-theme-link", href: thmURL, rel: "stylesheet", type: "text/css" });
    $("head").append(thmLink);
    $("head .ui-theme-link").first().remove();
}).children("[value=redmond]").prop("selected", true).change();


//---------------------accordion_end--------------------------------------//

//---------------------accordion_remove_border--------------------------------------//
$(document).ready(function(){
    $(".ui-accordion-header").click(function(){
        $(this).toggleClass("border-none");
    });
});
//---------------------accordion_remove_border--------------------------------------//

/*------------------------Custom_Select---------------------------------------------*/


var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
        and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
  except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);


/*------------------------Custom_Select_end---------------------------------------------*/

/*------------------------multiselect_dropdown------------------------------------------*/
$(".chosen-select").chosen();
$('button').click(function(){
    $(".chosen-select").val('').trigger("chosen:updated");
});
/*------------------------multiselect_dropdown_end------------------------------------------*/


/*------------------------choose state list---------------------------------------------*/


$(document).ready(function(){
    $(".add_more_state").click(function(){
        $(".all_state_list").toggle();
    });
});

/*------------------------choose state list_end---------------------------------------------*/

/*------------------------show_password------------------------------------------*/
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});


/*------------------------show_password_end------------------------------------------*/

/*------------------------input_onchange_event------------------------------------*/

$(document).ready(function () {
    $('.floating-label').on('change', function() {
        $(this).find('.state-label').addClass("defalult_floating");
    });
});


/*------------------------input_onchange_event_end------------------------------------*/









