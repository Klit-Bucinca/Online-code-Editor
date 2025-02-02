document.addEventListener('DOMContentLoaded', () => {
    const savedPromptsContainer = document.querySelector('.saved-prompts');
    const htmlInput = document.getElementById('html-input');
    const cssInput = document.getElementById('css-input');
    const jsInput = document.getElementById('js-input');
    const outputFrame = document.getElementById('output');
    const saveButton = document.getElementById('save-prompt');
    const userSelect = document.getElementById('user-select');
    const promptNameInput = document.getElementById('prompt-name');

    //  Function to update the output preview
    function updateOutput() {
        const html = htmlInput.value;
        const css = `<style>${cssInput.value}</style>`;
        const js = jsInput.value;

        const iframeDoc = outputFrame.contentDocument || outputFrame.contentWindow.document;

        try {
            iframeDoc.open();
            iframeDoc.write(`${css}${html}`);
            iframeDoc.close();

            const script = iframeDoc.createElement('script');
            script.textContent = js;
            iframeDoc.body.appendChild(script);
        } catch (error) {
            console.error('Error updating output:', error);
            alert('Error updating output: ' + error.message);
        }
    }

    //  Function to fetch all saved prompts from the database
    function loadSavedPrompts() {
        fetch('getPrompts.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && Array.isArray(data.prompts)) {
                    savedPromptsContainer.innerHTML = ''; // Clear existing prompts
                    data.prompts.forEach(prompt => {
                        addPromptToNavbar(prompt.id, prompt.name, prompt.html, prompt.css, prompt.js);
                    });
                } else {
                    console.error('Failed to load prompts:', data.error);
                }
            })
            .catch(error => {
                console.error('Error fetching prompts:', error);
            });
    }

    //  Function to add a saved prompt to the navbar
    function addPromptToNavbar(id, name, html, css, js) {
        const promptElement = document.createElement('div');
        promptElement.className = 'prompt';
        promptElement.setAttribute('data-id', id);

        promptElement.innerHTML = `
            <div class="prompt-content">
                <span class="prompt-name">${name}</span>
                <button class="delete-btn">Delete</button>
            </div>
        `;

        // Click event to load the prompt into the editor
        promptElement.querySelector('.prompt-name').addEventListener('click', () => {
            htmlInput.value = html;
            cssInput.value = css;
            jsInput.value = js;
            updateOutput();
        });

        // Delete event
        promptElement.querySelector('.delete-btn').addEventListener('click', (e) => {
            e.stopPropagation();
            deletePromptFromDatabase(id, promptElement);
        });

        savedPromptsContainer.appendChild(promptElement);
    }

    // Function to delete a prompt from the database and remove it from UI
    function deletePromptFromDatabase(promptId, promptElement) {
        fetch('deletePrompt.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: promptId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    promptElement.remove();
                    alert('Prompt deleted successfully!');
                } else {
                    alert('Failed to delete the prompt: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error deleting prompt:', error);
                alert('An error occurred while deleting the prompt.');
            });
    }

    //  Function to save a new prompt to the database
    function savePrompt() {
        const name = promptNameInput.value.trim();
        const html = htmlInput.value.trim();
        const css = cssInput.value.trim();
        const js = jsInput.value.trim();
        const userId = userSelect.value;

        if (!name) {
            alert('Please provide a name for the prompt.');
            return;
        }
        if (!userId) {
            alert('Please select a user.');
            return;
        }
        if (!html && !css && !js) {
            alert('Please provide some code in at least one field.');
            return;
        }

        fetch('savePrompt.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, html, css, js, user_id: userId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Prompt saved successfully!');
                    addPromptToNavbar(data.id, name, html, css, js);
                } else {
                    alert('Failed to save the prompt: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error saving prompt:', error);
                alert('An error occurred while saving the prompt.');
            });
    }

    // Attach event listeners
    saveButton.addEventListener('click', savePrompt);

    //  Hook up the inputs to update the iframe output
    [htmlInput, cssInput, jsInput].forEach((input) => {
        input.addEventListener('input', updateOutput);
    });

    updateOutput();
    loadSavedPrompts();
});
