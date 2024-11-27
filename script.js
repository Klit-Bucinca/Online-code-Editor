document.addEventListener('DOMContentLoaded', () => {
  const main = document.querySelector('.main');
  const layouts = ['layout-vertical-left', 'layout-horizontal', 'layout-vertical-right'];
  let layoutIndex = 0;

  const prompts = []; // Store saved prompts

  // update iframe output
  function updateOutput() {
    const html = document.getElementById('html-input').value;
    const css = `<style>${document.getElementById('css-input').value}</style>`;
    const js = document.getElementById('js-input').value;

    // Recreate the iframe per clean slate
    const oldIframe = document.getElementById('output');
    const newIframe = document.createElement('iframe');
    newIframe.id = 'output';
    newIframe.style.width = '100%';
    newIframe.style.height = '100%';
    newIframe.style.border = 'none';
    oldIframe.replaceWith(newIframe);

    const iframeDoc = newIframe.contentDocument || newIframe.contentWindow.document;

    try {
      iframeDoc.open();
      iframeDoc.write(`${css}${html}`);
      iframeDoc.close();

      const script = iframeDoc.createElement('script');
      script.textContent = js;
      iframeDoc.body.appendChild(script);
    } catch (error) {
      alert('Error updating output: ' + error.message);
      console.error('Update error:', error);
    }
  }

  // Save prompt function
  function savePrompt() {
    const name = document.getElementById('prompt-name').value.trim();
    const html = document.getElementById('html-input').value.trim();
    const css = document.getElementById('css-input').value.trim();
    const js = document.getElementById('js-input').value.trim();

    // Validate inputs
    if (!name) {
      alert('Please provide a name for the prompt.');
      return;
    }
    if (!html && !css && !js) {
      alert('Please provide some code in at least one field.');
      return;
    }
    if (prompts.some(prompt => prompt.name === name)) {
      alert('A prompt with this name already exists. Choose a different name.');
      return;
    }

    // Save the prompt
    const prompt = { name, html, css, js };
    prompts.push(prompt);

    // Update the UI
    const savedPromptsContainer = document.querySelector('.saved-prompts');
    const promptElement = document.createElement('div');
    promptElement.className = 'prompt';
    promptElement.innerHTML = `<span>${name}</span><button class="delete-btn">Delete</button>`;

    // Load the prompt on click
    promptElement.addEventListener('click', () => {
      document.getElementById('html-input').value = prompt.html;
      document.getElementById('css-input').value = prompt.css;
      document.getElementById('js-input').value = prompt.js;
      updateOutput();
    });

    // Delete the prompt
    promptElement.querySelector('.delete-btn').addEventListener('click', (e) => {
      e.stopPropagation();
      const index = prompts.findIndex(p => p.name === name);
      if (index > -1) {
        prompts.splice(index, 1);
        promptElement.remove();
      }
    });

    savedPromptsContainer.appendChild(promptElement);

    // Clear the input field for the prompt name
    document.getElementById('prompt-name').value = '';
  }

  // Event listeners
  document.getElementById('toggle-layout').addEventListener('click', () => {
    main.classList.remove(...layouts);
    layoutIndex = (layoutIndex + 1) % layouts.length;
    main.classList.add(layouts[layoutIndex]);
  });

  ['html-input', 'css-input', 'js-input'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateOutput);
  });

  document.getElementById('save-prompt').addEventListener('click', savePrompt);
});
