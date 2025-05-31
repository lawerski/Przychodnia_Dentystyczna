(function() {
    document.querySelector("html").dataset.bsTheme = localStorage.getItem("theme") || "light";
  })();

  function themeToggle() {
    let theme = localStorage.getItem("theme");
    if (theme && theme === "dark") {
      localStorage.setItem("theme", "light");
    } else {
      localStorage.setItem("theme", "dark");
    }
    document.querySelector("html").dataset.bsTheme = localStorage.getItem("theme");
}
