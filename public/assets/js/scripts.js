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
  dateFormat: "d-m-Y H:i",
  minuteIncrement: 15,
});
