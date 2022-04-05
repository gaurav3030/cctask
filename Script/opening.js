// button for log in page
console.log("Welcome to magic task. This is opening.js");
 
const btn = document.getElementById("btn");

btn.addEventListener("click", function(){ window.open('http://127.0.0.1:5501/log.html?email=&pwd2='); });


// sticky navbar
const nav = document.querySelector('#navbar')
const nelements = document.querySelector('#nav-elements')
const topOfNav = nav.offsetTop;
function fixNav(){
    if(window.scrollY>=topOfNav){
        document.body.classList.add('fixed-nav');

    }else{
        document.body.classList.remove('fixed-nav');
    }
}

window.addEventListener('scroll', fixNav)

// back to top button

var mybutton = document.getElementById("myBtn");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }


