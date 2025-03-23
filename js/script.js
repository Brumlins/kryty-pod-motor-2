document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            openEditModal(productId);
        });
    });
    
    const closeButton = document.querySelector('.close');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            document.getElementById('edit-modal').style.display = 'none';
        });
    }
    
    function openEditModal(productId) {
        document.getElementById('product-id').value = productId;
        
        fetch('php/get_product.php?id=' + productId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server vrátil chybu: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Chyba při parsování JSON:', e);
                    console.error('Přijatá data:', text);
                    throw new Error('Neplatná odpověď ze serveru');
                }
            })
            .then(data => {
                document.getElementById('kod').value = data.kod;
                document.getElementById('znacka').value = data.znacka_id;
                document.getElementById('material').value = data.material_id;
                document.getElementById('cena').value = data.cena;
                document.getElementById('popis').value = data.popis;
                
                document.getElementById('edit-modal').style.display = 'block';
            })
            .catch(error => {
                console.error('Chyba:', error);
                alert('Nepodařilo se načíst data produktu: ' + error.message);
            });
    }
    
    
    const editForm = document.getElementById('edit-form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                id: document.getElementById('product-id').value,
                kod: document.getElementById('kod').value,
                znacka_id: document.getElementById('znacka').value,
                material_id: document.getElementById('material').value,
                cena: document.getElementById('cena').value,
                popis: document.getElementById('popis').value
            };
            
            fetch('php/update_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('edit-modal').style.display = 'none';
                    window.location.reload();
                } else {
                    alert('Chyba při aktualizaci produktu: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
