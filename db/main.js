(function ($) {
  "use strict";

  function setButtonLoading($btn, isLoading, loadingText) {
    if (!$btn || !$btn.length) return;
    if (isLoading) {
      $btn.data("orig-html", $btn.html());
      $btn.prop("disabled", true).addClass("is-loading");
      $btn.html('<span class="spinner" aria-hidden="true"></span> ' + (loadingText || "Submitting..."));
    } else {
      $btn.prop("disabled", false).removeClass("is-loading");
      if ($btn.data("orig-html")) {
        $btn.html($btn.data("orig-html"));
      }
    }
  }

  function showInlineAlert($target, ok, message) {
    if (!$target || !$target.length) return;
    var cls = ok ? "alert alert-success" : "alert alert-danger";
    $target.html('<div class="' + cls + '" role="alert">' + $("<div>").text(message).html() + "</div>");
    $target[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
  }

  function bindAjaxForm(buttonSelector, endpointUrl, targetSelector, loadingText) {
    $(document).on("click", buttonSelector, function (event) {
      event.preventDefault();
      var $btn = $(this);
      var $form = $btn.closest("form");
      var $target = $(targetSelector);

      if ($form.length && typeof $form[0].checkValidity === "function" && !$form[0].checkValidity()) {
        $form[0].reportValidity();
        return;
      }

      setButtonLoading($btn, true, loadingText);
      if ($target.length) {
        $target.empty();
      }

      $.ajax({
        url: endpointUrl,
        method: "POST",
        dataType: "json",
        data: $form.serialize(),
        success: function (res) {
          var ok = Boolean(res && res.ok);
          var msg = (res && res.message) || (ok ? "Completed successfully." : "Request failed.");
          showInlineAlert($target, ok, msg);

          if (typeof swal === "function") {
            swal({
              title: ok ? "Success" : "Notice",
              text: msg,
              icon: ok ? "success" : "error",
              button: ok ? "OK" : "Close",
            }).then(function () {
              if (ok && res.redirect) {
                window.location.href = res.redirect;
              }
            });
          } else if (ok && res.redirect) {
            setTimeout(function () {
              window.location.href = res.redirect;
            }, 1500);
          }

          if (ok && !res.redirect && $form.length) {
            $form[0].reset();
          }
        },
        error: function (xhr) {
          var msg = "An unexpected network error occurred. Please try again.";
          if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }
          showInlineAlert($target, false, msg);
          if (typeof swal === "function") {
            swal({ title: "Error", text: msg, icon: "error", button: "Close" });
          }
        },
        complete: function () {
          setButtonLoading($btn, false);
        },
      });
    });
  }

  $(document).ready(function () {
    bindAjaxForm("#msubmit", "memberReg.php", "#member_sign", "Registering...");
    bindAjaxForm("#msubmit1", "memberReg2.php", "#member_sign1", "Renewing...");
    bindAjaxForm("#hospitalsubmit", "hospitaldonate.php", "#hospital_sign", "Processing...");
    bindAjaxForm("#transfer", "transferReg.php", "#transfer_sign", "Submitting...");
    bindAjaxForm("#organ", "organReg.php", "#organ_sign", "Submitting...");
    bindAjaxForm("#cregister", "cregister.php", "#csign", "Saving...");
    bindAjaxForm("#contactSubmit", "contactSubmit.php", "#contact_sign", "Sending...");
  });
})(jQuery);
