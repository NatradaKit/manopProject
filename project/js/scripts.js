let body = document.body;
let profile = document.querySelector(".header .flex .profile");
let sideBar = document.querySelector(".side-bar");

function ProfileClick() {
  profile.classList.toggle("active");
}

function MenuClick() {
  sideBar.classList.toggle("active");
  body.classList.toggle("active");
}

function CloseClick() {
  sideBar.classList.remove("active");
  body.classList.remove("active");
}

window.onscroll = () => {
  profile.classList.remove("active");
  search.classList.remove("active");

  if (window.innerWidth < 1200) {
    sideBar.classList.remove("active");
    body.classList.remove("active");
  }
};

var clickStar = document.getElementsByClassName("star");
console.log(clickStar);

for (let i = 0; i < clickStar.length; i++) {
   clickStar[i].addEventListener("click", function (e) {
      //alert("hello");
      if (e.target.closest("span")) {
         console.log(e);
         let span_el = e.target.closest("span");
         if (span_el.classList.contains("star")) {

            let current_star = parseInt(span_el.getAttribute("data-star"));
            let star_span = span_el.closest("div.star_block").querySelectorAll("span.star");
            //console.log(star_span);
            star_span.forEach(function (star_item, i) {

               if (parseInt(star_item.getAttribute("data-star")) <= current_star) {
                  star_span[i].classList.add("-on");
               } else {
                  star_span[i].classList.remove("-on");
               }
            });
         }
      }
   })
}