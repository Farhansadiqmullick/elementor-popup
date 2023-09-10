(function ($) {
  $(document).on("ready", function () {
    // Function to show the popup after a delay
    function showPopup() {
      const popup = document.getElementById("popup");
      $(popup).addClass("show").fadeIn();
    }

    var timer = $(".popup-timer").data("timer");
    timersec = timer * 1000;

    var closeBtn = $("#popup .close-btn");
    closeBtn.on("click", function () {
      $(this).parent().fadeOut().close();
    });

    setTimeout(showPopup, timersec); // Delay for 10 seconds (10000 milliseconds)

    // Telephone Flag
    var telephone = document.querySelector("#phone");
    window.intlTelInput(telephone, {
      allowDropdown: true,
      separateDialCode: true,
      initialCountry: "in",
      placeholderNumberType: "MOBILE",
      hiddenInput: "mobile-form-submission",
      utilsScript: "assets/js/utils.js",
    });

    $("form #submit").click(function (event) {
      event.preventDefault();

      var phoneNumber = $("#phone").val();
      var recipientEmail = $("#submit").data("send");

      $.ajax({
        type: "POST",
        url: phoneurl.ajaxurl,
        data: {
          action: "send_phone_number",
          phone: phoneNumber,
          recipient_email: recipientEmail,
        },
        success: function (response) {
          var result = JSON.parse(response);

          if (result.success) {
            alert("Phone number sent successfully.");
          } else {
            alert("Error: " + result.message);
          }
        },
        error: function () {
          alert("Error sending phone number.");
        },
      });
    });
  });
})(jQuery);
