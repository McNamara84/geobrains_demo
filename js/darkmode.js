// darkmode.js
document.addEventListener("DOMContentLoaded", function () {
  const themeDropdown = document.getElementById("bd-theme");
  const themeDropdownItems = themeDropdown.parentElement.querySelectorAll(".dropdown-item");
  const themeToggle = document.querySelector("#bd-theme span");

  function setTheme(theme) {
    document.documentElement.setAttribute("data-bs-theme", theme);
    localStorage.setItem("theme", theme);
    themeDropdownItems.forEach((item) => {
      item.classList.toggle("active", item.getAttribute("data-bs-theme-value") === theme);
    });
    themeToggle.textContent = theme.charAt(0).toUpperCase() + theme.slice(1);
  }

  themeDropdownItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const theme = this.getAttribute("data-bs-theme-value");
      setTheme(theme);
    });
  });

  const storedTheme = localStorage.getItem("theme");
  if (storedTheme) {
    setTheme(storedTheme);
  }
});
