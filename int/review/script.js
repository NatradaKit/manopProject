let toggleBtn = document.getElementById('toggle-btn');
let body = document.body;
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () => {
   toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () => {
   toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if (darkMode === 'enabled') {
   enableDarkMode();
}

toggleBtn.onclick = (e) => {
   darkMode = localStorage.getItem('dark-mode');
   if (darkMode === 'disabled') {
      enableDarkMode();
   } else {
      disableDarkMode();
   }
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
   profile.classList.toggle('active');
   search.classList.remove('active');
}

let search = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () => {
   search.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () => {
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

document.querySelector('#close-btn').onclick = () => {
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

window.onscroll = () => {
   profile.classList.remove('active');
   search.classList.remove('active');

   if (window.innerWidth < 1200) {
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }
}

var clickStar = document.getElementsByClassName("star");
console.log(clickStar);

// ==== 星號的重要性 ===== //
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
