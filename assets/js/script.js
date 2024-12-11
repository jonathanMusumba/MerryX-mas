document.getElementById('generateBtn').addEventListener('click', function () {
    const sender = document.getElementById('sender').value.trim();
    if (sender) {
        const message = `✨ Wishing you a joyous Christmas, filled with love, peace, and happiness! ✨\n\n🎄 Best wishes from ${sender}! 🎅🎁`;
        document.getElementById('messageText').textContent = message;

        // Show the greeting and share options
        document.querySelector('.form').classList.add('hidden');
        document.getElementById('greeting').classList.remove('hidden');
    } else {
        alert('Please enter your name to generate a wish!');
    }
});

document.getElementById('copyBtn').addEventListener('click', function () {
    const sender = document.getElementById('sender').value.trim();
    const link = `${window.location.origin}?name=${encodeURIComponent(sender)}`;
    navigator.clipboard.writeText(link).then(() => {
        alert('Link copied to clipboard! Share it with friends.');
    });
});

document.getElementById('whatsappBtn').addEventListener('click', function () {
    const sender = document.getElementById('sender').value.trim();
    const message = `✨ Wishing you a joyous Christmas, filled with love, peace, and happiness! ✨\n\n🎄 Best wishes from ${sender}! 🎅🎁`;
    const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
});

document.getElementById('facebookBtn').addEventListener('click', function () {
    const sender = document.getElementById('sender').value.trim();
    const message = `✨ Wishing you a joyous Christmas, filled with love, peace, and happiness! ✨\n\n🎄 Best wishes from ${sender}! 🎅🎁`;
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
});

document.getElementById('createNewBtn').addEventListener('click', function () {
    document.querySelector('.form').classList.remove('hidden');
    document.getElementById('greeting').classList.add('hidden');
    document.getElementById('sender').value = '';
});
