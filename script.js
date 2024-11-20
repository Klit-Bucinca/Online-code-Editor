document.addEventListener('DOMContentLoaded', () => {
  const main = document.querySelector('.main');
  const layouts = ['layout-vertical-left', 'layout-horizontal', 'layout-vertical-right'];
  let layoutIndex = 0;

  function updateOutput() {
    const html = document.getElementById('html-input').value;
    const css = `<style>${document.getElementById('css-input').value}</style>`;
    const js = document.getElementById('js-input').value;
    const iframe = document.getElementById('output');
    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

    // Write HTML and CSS to the iframe
    iframeDoc.open();
    iframeDoc.write(`${css}${html}`);
    iframeDoc.close();

    // Execute JavaScript in the iframe
    const script = iframeDoc.createElement('script');
    script.textContent = js;
    iframeDoc.body.appendChild(script);
  }

  document.getElementById('toggle-layout').addEventListener('click', () => {
    main.classList.remove(...layouts);
    layoutIndex = (layoutIndex + 1) % layouts.length;
    main.classList.add(layouts[layoutIndex]);
  });

  ['html-input', 'css-input', 'js-input'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateOutput);
  });

  const prompts = [];
  document.getElementById('save-prompt').addEventListener('click', () => {
    const name = document.getElementById('prompt-name').value.trim();
    const html = document.getElementById('html-input').value.trim();
    const css = document.getElementById('css-input').value.trim();
    const js = document.getElementById('js-input').value.trim();

    if (!name || (!html && !css && !js)) {
      alert('Provide a name and some code!');
      return;
    }

    if (prompts.some(p => p.name === name)) {
      alert('Name already exists!');
      return;
    }

    prompts.push({ name, html, css, js });
    const promptEl = document.createElement('div');
    promptEl.className = 'prompt';
    promptEl.innerHTML = `<span>${name}</span><button class="delete-btn">Delete</button>`;

    promptEl.addEventListener('click', () => {
      const prompt = prompts.find(p => p.name === name);
      if (prompt) {
        document.getElementById('html-input').value = prompt.html;
        document.getElementById('css-input').value = prompt.css;
        document.getElementById('js-input').value = prompt.js;
        updateOutput();
      }
    });

    promptEl.querySelector('.delete-btn').addEventListener('click', (e) => {
      e.stopPropagation();
      prompts.splice(prompts.findIndex(p => p.name === name), 1);
      promptEl.remove();
    });

    document.querySelector('.saved-prompts').appendChild(promptEl);
    document.getElementById('prompt-name').value = '';
  });
});
