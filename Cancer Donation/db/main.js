$(document).ready(function () {
  $("#pregister").click(function (event) {
    event.preventDefault();

    $.ajax({
      url: "pregister.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#psign").html(data);
      },
    });
  });

  $("#cregister").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "cregister.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#csign").html(data);
      },
    });
  });

  $("#sregister").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "sregister.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#ssign").html(data);
      },
    });
  });

  $("#news").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "newsReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#news_sign").html(data);
      },
    });
  });

  $("#event").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "eventReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#event_sign").html(data);
      },
    });
  });

  $("#salon").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "salonReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#salon_sign").html(data);
      },
    });
  });

  $("#msubmit").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "memberReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#member_sign").html(data);
      },
    });
  });

  $("#msubmit1").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "memberReg2.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#member_sign1").html(data);
      },
    });
  });

  $("#mupdate").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "memberUpdate.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#member_update").html(data);
      },
    });
  });

  $("#hospitalsubmit").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "hospitaldonate.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#hospital_sign").html(data);
      },
    });
  });

  $("#transfer").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "transferReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#transfer_sign").html(data);
      },
    });
  });

  $("#organ").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "organReg.php",
      method: "POST",
      data: $("form").serialize(),
      success: function (data) {
        $("#organ_sign").html(data);
      },
    });
  });
});
