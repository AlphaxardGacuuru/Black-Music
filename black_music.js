/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}


//Function for checker snack bar
function checkerSnackbar() {
// Get the snackbar DIV
var x = document.getElementById("checker");

// Add the "show" class to DIV
x.className = "show";

// After 3 seconds, remove the show class from DIV
setTimeout(function () {
  x.className = x.className.replace("show", "");
}, 3000);
}

//Function for snack bar
function loveSnackbar() {
// Get the snackbar DIV
var x = document.getElementById("loveSnackbar");

// Add the "show" class to DIV
x.className = "show";

// After 3 seconds, remove the show class from DIV
setTimeout(function () {
  x.className = x.className.replace("show", "");
}, 3000);
}

//Function for snack bar
function unloveSnackbar() {
// Get the snackbar DIV
var x = document.getElementById("unloveSnackbar");

// Add the "show" class to DIV
x.className = "show";

// After 3 seconds, remove the show class from DIV
setTimeout(function () {
  x.className = x.className.replace("show", "");
}, 3000);
}

//tooltip for following images
$(document).ready(function () {
 $('[data-toggle="tooltip"]').tooltip();
});




// Jquery to make entire rows clickable 
jQuery(document).ready(function($) {
  $(".clickable-row").click(function() {
   window.location = $(this).data("href");
 });
});
//place class="clickable" on intended clickable row and data-ref="Play_Video.php?vsong_id=$vsong_id"




    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function cartFunction() {
      document.getElementById("cartDropdown").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function bellFunction() {
      document.getElementById("bellDropdown").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function avatarFunction() {
      document.getElementById("avatarDropdown").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function genreFunction() {
      document.getElementById("genreDropdown").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function postDropup() {
      document.getElementById("postDropup").classList.toggle("show");
    }

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

//functions to ensure poll parameters are input in the correct order
function inputPara2() {
  document.getElementById("para-2").innerHTML = 
  "<input type='text' name='poll_2' class='form-control' placeholder='Parameter 2' oninput='inputPara3()'>"; 
}

function inputPara3() {
  document.getElementById("para-3").innerHTML =
  "<input type='text' name='poll_3' class='form-control' placeholder='Parameter 3' oninput='inputPara4()'>"
}
function inputPara4() {
  document.getElementById("para-4").innerHTML = 
  "<input type='text' name='poll_4' class='form-control' placeholder='Parameter 4' oninput='inputPara5()'>"; 
}

function inputPara5() {
  document.getElementById("para-5").innerHTML =
  "<input type='text' name='poll_5' class='form-control' placeholder='Parameter 5'>"
}

//script to prevent entry of white spaces
function AvoidSpace(event) {
  var k = event ? event.which : window.event.keyCode;
  if (k == 32) return false;
}

//Function to copy text
function copyText() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
}

//Function for horizontal scroll buttons
var $content = $('div.hidden-scroll');

function changeContentScroll(pos) {
 var currentPos = $content.scrollLeft();
 $content.scrollLeft(currentPos + pos);
}

function onright() {
  changeContentScroll(-300);
}

function onleft() {
  changeContentScroll(+300);
}

$('button.right').on('click', onleft);
$('button.left').on('click', onright);