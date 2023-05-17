// Title on hover in home images gallery

const focusImgs = document.querySelectorAll(".focus-img");
const focusTitles = document.querySelectorAll(".focus-title");

focusImgs.forEach((focusImg, index) => {
  focusImg.addEventListener("mouseover", () => {
    focusTitles[index].classList.replace("hidden", "visible");
  });
});
focusImgs.forEach((focusImg, index) => {
  focusImg.addEventListener("mouseout", () => {
    focusTitles[index].classList.replace("visible", "hidden");
  });
});

/*** Booking Form ***/

flatpickr("#reservation_form_date_time", {
  enableTime: true,
  minDate: "today",
  time_24hr: true,
  dateFormat: "Y-m-d H:i",
  minuteIncrement: 15,
  locale: "fr",
});

/** Remaining seats**/
document
  .getElementById("reservation_form_date_time")
  .addEventListener("change", function () {
    var dateTimeObject = new Date(this.value);
    var year = dateTimeObject.getFullYear();
    var month = String(dateTimeObject.getMonth() + 1).padStart(2, "0");
    var day = String(dateTimeObject.getDate()).padStart(2, "0");
    var hours = String(dateTimeObject.getHours()).padStart(2, "0");
    var minutes = String(dateTimeObject.getMinutes()).padStart(2, "0");

    var formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    fetch("/api/remainingSeats/" + formattedDateTime)
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          document.getElementById("remainingSeats").innerHTML =
            "<span style='color: red;'>" + data.error + "</span>";
        } else {
          document.getElementById("remainingSeats").innerText =
            "Places restantes pour le service sélectionné : " +
            data.remainingSeats;
        }
      });
  });
