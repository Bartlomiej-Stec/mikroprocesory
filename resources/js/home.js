document.addEventListener('DOMContentLoaded', function () {
    var copyButton = document.getElementById('copyButton');
    var textToCopy = document.querySelector('.card-body p');

    copyButton.addEventListener('click', function () {
        var textArea = document.createElement('textarea');
        textArea.value = textToCopy.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Token został skopiowany do schowka: ' + textToCopy.textContent);
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});