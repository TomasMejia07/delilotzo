document.addEventListener("DOMContentLoaded", function() {
  var reminderTitles = document.getElementsByClassName("reminder-title");

  Array.from(reminderTitles).forEach(function(title) {
    var reminderContent = title.nextElementSibling;
    var imgDesplegar = title.querySelector(".imgDesplegar");

    reminderContent.style.maxHeight = "0";
    reminderContent.style.overflow = "hidden";
    reminderContent.style.transition = "max-height 0.3s ease-in-out";

    title.addEventListener("click", function() {
      if (reminderContent.style.maxHeight === "0px") {
        reminderContent.style.maxHeight = reminderContent.scrollHeight + "px";
        imgDesplegar.style.transform = "rotate(180deg)";
      } else {
        reminderContent.style.maxHeight = "0";
        imgDesplegar.style.transform = "rotate(360deg)";
      }
    });
  });
});
