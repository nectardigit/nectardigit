<script type="text/javascript">

window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar_top");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

 // end js 
 
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
// end js
  function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  // document.body.style.backgroundColor = "white";
}
// end js
                 var sp = document.querySelector('.search-open');
            var searchbar = document.querySelector('.search-inline');
            var shclose = document.querySelector('.search-close');
            function changeClass() {
                searchbar.classList.add('search-visible');
            }
            function closesearch() {
                searchbar.classList.remove('search-visible');
            }
            sp.addEventListener('click', changeClass);
            shclose.addEventListener('click', closesearch);


            // End js
                
            
function yourFunction() {
  document.getElementById("panel").style.display = "block";
}
// end js

function tajaFunction() {
  document.getElementById("tajapanel").style.display = "block";
}


   // end js 
  $(document).ready(function() {
$(window).scroll(function() {
if ($(this).scrollTop() > 20) {
$('#toTopBtn').fadeIn();
} else {
$('#toTopBtn').fadeOut();
}
});

$('#toTopBtn').click(function() {
$("html, body").animate({
scrollTop: 0
}, 1000);
return false;
});
});
</script>

