<<<<<<< HEAD
function lettersOnly(input) {
  if (!input) return;
  input.value = input.value.replace(/[^a-zA-Z\s]/g, "");
}

document.addEventListener("DOMContentLoaded", function () {
  var menuBtn = document.querySelector("#menu-btn");
  var navbar = document.querySelector(".navbar");

  if (menuBtn && navbar) {
    menuBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      navbar.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
      if (navbar.classList.contains("active") && !navbar.contains(e.target) && e.target !== menuBtn) {
        navbar.classList.remove("active");
      }
    });

    window.addEventListener("scroll", function () {
      navbar.classList.remove("active");
    });
  }
});
=======
let navbar = document.querySelector(".navbar");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  searchForm.classList.remove("active");
  cartItem.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  searchForm.classList.remove("active");
  cartItem.classList.remove("active");
};

let searchForm = document.querySelector(".search-form");

document.querySelector("#search-btn").onclick = () => {
  searchForm.classList.toggle("active");
  navbar.classList.remove("active");
  cartItem.classList.remove("active");
};

let cartItem = document.querySelector(".cart-items-container");

document.querySelector("#cart-btn").onclick = () => {
  cartItem.classList.toggle("active");
  navbar.classList.remove("active");
  searchForm.classList.remove("active");
};
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
