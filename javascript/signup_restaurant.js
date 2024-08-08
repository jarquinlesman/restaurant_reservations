        function previewImage() {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = ''; // Limpiar el contenido previo del contenedor

            const file = document.getElementById('image').files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }

        function validatePhone() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');
            const validCharacters = /^[0-9-]*$/;

            if (!validCharacters.test(phoneInput.value)) {
                phoneError.style.display = 'inline';
            } else {
                phoneError.style.display = 'none';
            }

            phoneInput.value = phoneInput.value.replace(/[^0-9-]/g, '');
        }

        function updateTotalTables() {
            const tables2 = parseInt(document.getElementById('tables-2').value) || 0;
            const tables4 = parseInt(document.getElementById('tables-4').value) || 0;
            const tables6 = parseInt(document.getElementById('tables-6').value) || 0;
            const tables10 = parseInt(document.getElementById('tables-10').value) || 0;

            const totalTables = tables2 + tables4 + tables6 + tables10;
            document.getElementById('total-tables').value = totalTables;
        }

