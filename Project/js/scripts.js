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
