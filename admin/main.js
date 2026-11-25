<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {
  var toggle = document.getElementById("sidebarToggle");
  var navigation = document.getElementById("adminSidebar");
  var main = document.getElementById("adminMain");
  var backdrop = document.getElementById("sidebarBackdrop");

  function closeMobileSidebar() {
    if (navigation) navigation.classList.remove("mobile-open");
    if (backdrop) backdrop.classList.remove("show");
  }

  if (toggle && navigation && main) {
    toggle.addEventListener("click", function () {
      if (window.innerWidth <= 768) {
        navigation.classList.toggle("mobile-open");
        if (backdrop) backdrop.classList.toggle("show");
      } else {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
      }
    });
  }

  if (backdrop) {
    backdrop.addEventListener("click", closeMobileSidebar);
  }

  // Reusable client-side table search
  document.querySelectorAll("[data-table-search]").forEach(function (input) {
    var tableSelector = input.getAttribute("data-table-search");
    var table = document.querySelector(tableSelector);
    if (!table) return;

    input.addEventListener("keyup", function () {
      var keyword = input.value.trim().toUpperCase();
      var rows = table.querySelectorAll("tbody tr");
      rows.forEach(function (row) {
        var text = (row.textContent || row.innerText || "").toUpperCase();
        row.style.display = text.indexOf(keyword) > -1 ? "" : "none";
      });
    });
  });

  // Reusable SweetAlert + AJAX action handler (delete or certificate send)
  if (typeof window.jQuery !== "undefined") {
    jQuery(document).on("click", ".js-confirm-action", function (e) {
      e.preventDefault();
      var $btn = jQuery(this);
      var id = $btn.data("id");
      var csrf = $btn.data("csrf");
      var title = $btn.data("title") || "Are you sure?";
      var text = $btn.data("text") || "Once deleted, you will not be able to recover this record.";
      var confirmText = $btn.data("confirm-text") || "Yes, continue";
      var actionKey = $btn.data("action-key") || "delete_btn_set";

      function runRequest() {
        $btn.prop("disabled", true).addClass("is-loading");
        var payload = { delete_id: id, csrf_token: csrf };
        payload[actionKey] = 1;

        jQuery.ajax({
          type: "POST",
          url: window.location.href,
          dataType: "json",
          data: payload,
          success: function (res) {
            var ok = Boolean(res && res.ok);
            var msg = (res && res.message) || (ok ? "Action completed." : "Action failed.");
            swal({
              title: ok ? "Success" : "Error",
              text: msg,
              icon: ok ? "success" : "error",
            }).then(function () {
              if (ok) location.reload();
            });
          },
          error: function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) || "Request failed. Please try again.";
            swal({ title: "Error", text: msg, icon: "error" });
          },
          complete: function () {
            $btn.prop("disabled", false).removeClass("is-loading");
          },
        });
      }

      if (typeof swal === "function") {
        swal({
          title: title,
          text: text,
          icon: "warning",
          buttons: ["Cancel", confirmText],
          dangerMode: true,
        }).then(function (confirmed) {
          if (confirmed) runRequest();
        });
      } else if (window.confirm(text)) {
        runRequest();
      }
    });
  }
});
=======
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

//add hoverd class in selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => item.classList.remove("hovered"));
  this.classList.add("hovered");
}
list.forEach((item) => item.addEventListener("mouseover", activeLink));
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
