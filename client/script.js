const quoteContainer = document.getElementById('quote-container');
const modeToggle = document.getElementById('mode-toggle');
const newQuoteBtn = document.getElementById('new-quote-btn');

function googleTranslateElementInit() {
    new google.translate.TranslateElement({ layout: google.translate.TranslateElement.InlineLayout.SIMPLE, includedLanguages: 'en,hy' }, 'google_translate_element');
}

const fetchRandomQuote = async () => {
    try {
        const response = await fetch('https://donttrip.org/quotes/backend/root.php/quote/random');
        const data = await response.json();
        quoteContainer.innerHTML = data.quote;
    } catch (error) {
        console.error('Error fetching quote:', error);
    }
};

fetchRandomQuote();

newQuoteBtn.addEventListener('click', fetchRandomQuote);

modeToggle.addEventListener('click', () => {
    // Toggle the dark mode class
    document.body.classList.toggle('dark-mode');
    modeToggle.classList.toggle('dark-mode');
    newQuoteBtn.classList.toggle('dark-mode');

    // Get the current mode after toggling
    const isDarkMode = document.body.classList.contains('dark-mode');

    // Set the text content of the button based on the current mode
    modeToggle.textContent = isDarkMode ? '֍' : '☾';
});

// Check the initial mode and set the button text accordingly
const initialMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark-mode' : 'light-mode';
document.body.classList.add(initialMode);
modeToggle.classList.add(initialMode);
newQuoteBtn.classList.add(initialMode);
modeToggle.textContent = initialMode === 'dark-mode' ? '֍' : '☾';

