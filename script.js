document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.querySelector(".navbar");
  const toggleButton = document.getElementById("navbar-toggle");
  const closeButton = document.getElementById("navbar-close");
  const main = document.querySelector(".main");
  const inputAreas = document.querySelectorAll("textarea");
  const layouts = ["layout-vertical-left", "layout-horizontal", "layout-vertical-right"];
  let layoutIndex = 0;

  const savedPromptsContainer = document.querySelector(".saved-prompts");

  // Function to update the layout dynamically
  const updateLayout = () => {
      const screenWidth = window.innerWidth;

      if (screenWidth <= 800) {
          navbar.style.transform = navbar.classList.contains("open") ? "translateX(0)" : "translateX(-100%)";
          main.style.marginLeft = navbar.classList.contains("open") ? "350px" : "0";
          main.style.width = navbar.classList.contains("open") ? "calc(100% - 350px)" : "100%";
      } else if (screenWidth <= 1200) {
          navbar.style.transform = navbar.classList.contains("open") ? "translateX(0)" : "translateX(-100%)";
          main.style.marginLeft = navbar.classList.contains("open") ? "350px" : "0";
          main.style.width = navbar.classList.contains("open") ? "calc(100% - 350px)" : "100%";
      } else {
          navbar.style.transform = "translateX(0)";
          main.style.marginLeft = "350px";
          main.style.width = "calc(100% - 350px)";
      }
  };

  // Toggle Navbar
  const toggleNavbar = () => {
      navbar.classList.toggle("open");
      updateLayout();
  
      if (navbar.classList.contains("open") && window.innerWidth <= 1200) {
          toggleButton.style.display = "none";
      } else {
          toggleButton.style.display = "block";
      }
      if (navbar.classList.contains("open") && window.innerWidth <= 660) {
          document.getElementById("toggle-layout").style.display = "none";
      } else {
          document.getElementById("toggle-layout").style.display = "block";
      }
  };

  // Close Navbar
  const closeNavbar = () => {
      navbar.classList.remove("open");
      updateLayout();
      toggleButton.style.display = "block";
      document.getElementById("toggle-layout").style.display = "block";
  };

  // Update the iframe output
  const updateOutput = () => {
      const html = document.getElementById("html-input").value;
      const css = `<style>${document.getElementById("css-input").value}</style>`;
      const js = document.getElementById("js-input").value;

      const oldIframe = document.getElementById("output");
      const newIframe = document.createElement("iframe");
      newIframe.id = "output";
      newIframe.style.width = "100%";
      newIframe.style.height = "100%";
      newIframe.style.border = "none";
      oldIframe.replaceWith(newIframe);

      const iframeDoc = newIframe.contentDocument || newIframe.contentWindow.document;

      try {
          iframeDoc.open();
          iframeDoc.write(`${css}${html}`);
          iframeDoc.close();

          const script = iframeDoc.createElement("script");
          script.textContent = js;
          iframeDoc.body.appendChild(script);
      } catch (error) {
          alert("Error updating output: " + error.message);
          console.error("Update error:", error);
      }
  };

  // Load prompts from database
  const loadPrompts = () => {
      fetch("fetch_prompts.php")
          .then(response => response.json())
          .then(prompts => {
              savedPromptsContainer.innerHTML = "";
              prompts.forEach(prompt => {
                  const promptElement = createPromptElement(prompt.id, prompt.name, prompt.html, prompt.css, prompt.js);
                  savedPromptsContainer.appendChild(promptElement);
              });
          })
          .catch(error => console.error("Error fetching prompts:", error));
  };

  // Save prompt function
  const savePrompt = () => {
      const name = document.getElementById("prompt-name").value.trim();
      const html = document.getElementById("html-input").value.trim();
      const css = document.getElementById("css-input").value.trim();
      const js = document.getElementById("js-input").value.trim();

      if (!name) {
          alert("Please provide a name for the prompt.");
          return;
      }

      fetch("save_prompt.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ name, html, css, js }),
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              const promptElement = createPromptElement(data.id, name, html, css, js);
              savedPromptsContainer.appendChild(promptElement);
              document.getElementById("prompt-name").value = "";
          } else {
              alert("Error saving prompt.");
          }
      })
      .catch(error => console.error("Error saving prompt:", error));
  };

  // Delete prompt function
  window.deletePrompt = (id) => {
      fetch("delete_prompt.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id }),
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              document.querySelector(`.prompt[data-id='${id}']`).remove();
          } else {
              alert("Error deleting prompt.");
          }
      })
      .catch(error => console.error("Error deleting prompt:", error));
  };

  // Create Prompt Element
  function createPromptElement(id, name, html, css, js) {
      const promptElement = document.createElement("div");
      promptElement.className = "prompt";
      promptElement.dataset.id = id;
      promptElement.innerHTML = `
          <span>${name}</span>
          <button class="delete-btn" onclick="deletePrompt(${id})">Delete</button>
      `;

      // Load the prompt data when clicked
      promptElement.addEventListener("click", () => {
          document.getElementById("html-input").value = html;
          document.getElementById("css-input").value = css;
          document.getElementById("js-input").value = js;
          updateOutput();
      });

      return promptElement;
  }

  // Attach Event Listeners
  toggleButton.addEventListener("click", toggleNavbar);
  closeButton.addEventListener("click", closeNavbar);

  inputAreas.forEach((input) => {
      input.addEventListener("focus", () => {
          navbar.classList.remove("open");
          updateLayout();
      });
  });

  document.getElementById("toggle-layout").addEventListener("click", () => {
      main.classList.remove(...layouts);
      layoutIndex = (layoutIndex + 1) % layouts.length;
      main.classList.add(layouts[layoutIndex]);
  });

  ["html-input", "css-input", "js-input"].forEach(id => {
      document.getElementById(id).addEventListener("input", updateOutput);
  });

  window.addEventListener("resize", updateLayout);

  document.getElementById("save-prompt").addEventListener("click", savePrompt);

  // Load prompts on page load
  loadPrompts();

  // Fetch and display logged-in username
  fetch("getUser.php")
      .then(response => response.text())
      .then(username => {
          if (username.trim()) {
              document.querySelector(".username").textContent = username;
          }
      })
      .catch(error => console.error("Error fetching username:", error));
});
