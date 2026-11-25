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
