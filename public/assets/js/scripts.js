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
    var date_time = this.value;
    var dateTimeObject = new Date(date_time);
    var formattedDateTime = dateTimeObject.toISOString().substring(0, 16);
    fetch("/api/remainingSeats/" + formattedDateTime)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("remainingSeats").innerText =
          "Places restantes pour le service sélectionné : " + data;
      });
  });
