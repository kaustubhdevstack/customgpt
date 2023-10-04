<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// Footer template

?>


<!-- jQuery & Javascripts -->
<script>
/* Script to reload window without confirm submission prompt */

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

/* Script for copy button */
document.getElementById('copy-button').addEventListener('click', function() {
// Select the text inside the pre element
var text = document.querySelector('#resultAI pre').innerText;
// Create a temporary input element
var input = document.createElement('input');
// Set the value of the input to the selected text
input.setAttribute('value', text);
// Append the input to the body
document.body.appendChild(input);
// Select the text inside the input
input.select();
// Copy the selected text
document.execCommand('copy');
// Remove the input from the body
document.body.removeChild(input);
// Result copied
alert('Result copied to clipboard!');
});

function typeOutText(text) {
  const element = document.getElementById('resultAI');
  const delay = 50; // milliseconds per character
  let i = 0;
  function typeNextChar() {
    if (i < text.length) {
      element.innerHTML += text.charAt(i);
      i++;
      setTimeout(typeNextChar, delay);
    }
  }
  typeNextChar();
}

fetch('tools/strategy_maker')
  .then(response => response.json())
  .then(data => {
    typeOutText(data.resultTxt);
  });
</script>
<script src="<?= base_url(); ?>/public/assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/bootstrap-slider.min"></script>
<script src="<?= base_url(); ?>/public/assets/js/adminlte.min.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/init.js"></script>
</body>
</html>