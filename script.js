// References
const htmlInput = document.getElementById('html-input');
const cssInput = document.getElementById('css-input');
const jsInput = document.getElementById('js-input');
const output = document.getElementById('output');
const savePromptBtn = document.getElementById('save-prompt');
const savedPrompts = document.querySelector('.saved-prompts');
const promptInput = document.getElementById('prompt-input');

// To store saved prompts
const prompts = {};

// Update Output
function updateOutput() {
  const html = htmlInput.value;
  const css = `<style>${cssInput.value}</style>`;
  const js = `<script>${jsInput.value}<\/script>`;

  output.innerHTML = html + css + js;
}

// Event Listeners
htmlInput.addEventListener('input', updateOutput);
cssInput.addEventListener('input', updateOutput);
jsInput.addEventListener('input', updateOutput);

// Save Prompt
savePromptBtn.addEventListener('click', () => {
  const promptName = promptInput.value.trim();
  if (promptName) {
    // Save the current content in the prompts object
    prompts[promptName] = {
      html: htmlInput.value,
      css: cssInput.value,
      js: jsInput.value,
    };

    // Create a clickable prompt item
    const prompt = document.createElement('div');
    prompt.textContent = promptName;
    prompt.classList.add('prompt');
    prompt.addEventListener('click', () => loadPrompt(promptName));
    savedPrompts.appendChild(prompt);

    // Clear the input field
    promptInput.value = '';
  }
});

// Load a saved prompt
function loadPrompt(promptName) {
  const saved = prompts[promptName];
  if (saved) {
    htmlInput.value = saved.html;
    cssInput.value = saved.css;
    jsInput.value = saved.js;
    updateOutput(); // Refresh the output area
  }
}
