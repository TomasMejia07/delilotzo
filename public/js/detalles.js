function toggleTable(categoriaNombre) {
    var table = document.getElementById('table_' + categoriaNombre);
    if (table.style.display === 'none' || table.style.display === '') {
        table.style.display = 'table';
    } else {
        table.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    function calcularTotal() {
        var total = 0;
        var productosSeleccionados = document.querySelectorAll('input[name="productos_seleccionados[]"]:checked');

        productosSeleccionados.forEach(function (checkbox) {
            var productoId = checkbox.value;
            var cantidadInput = document.getElementById("cantidad_" + productoId);
            var valorInput = document.querySelector(`.pedido-value[name="valor_${productoId}"]`);
            var cantidad = parseInt(cantidadInput.value, 10);
            var valor = parseFloat(valorInput.value);

            if (!isNaN(cantidad) && !isNaN(valor)) {
                total += cantidad * valor;
            }
        });

        var totalInput = document.getElementById('total');
        totalInput.value = total.toFixed(0);
    }

    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', calcularTotal);
    });

    var quantityInputs = document.querySelectorAll('.pedido-quantity');
    quantityInputs.forEach(function (quantityInput) {
        quantityInput.addEventListener('input', calcularTotal);
    });

    calcularTotal();
});

function mostrarSalsas(checkbox, productoId) {
    var cantidad = parseInt(document.getElementById("cantidad_" + productoId).value);
    var salsasContainer = document.getElementById("salsas_" + productoId);
    salsasContainer.innerHTML = '';

    var salsas = [
        'Roja', 'Piña', 'Mostaza', 'Rosada', 'BBQ', 'Tártara', 'Mayonesa', 'Guacamole',
        'Maíz dulce', 'Salsa ahumada', 'Guacamole Especial', 'BBQ Especial', 'Ajo Especial',
        'Queso Cheddar', 'Queso en Polvo', 'Cebolla', 'Cebolla Caramelizada', 'Todas las Salsas'
    ];

    if (checkbox.checked) {
        for (var i = 0; i < cantidad; i++) {
            var salsaGroup = document.createElement('div');
            salsaGroup.className = 'salsa-group';
            salsaGroup.innerHTML = `<h3 class="salsas-title">Salsa ${i + 1}</h3>`;

            var columnCount = 3; // Tres columnas
            var salsasPerColumn = Math.ceil(salsas.length / columnCount);
            for (var col = 0; col < columnCount; col++) {
                var salsaColumns = '';
                for (var j = col * salsasPerColumn; j < (col + 1) * salsasPerColumn && j < salsas.length; j++) {
                    salsaColumns += `<input type="checkbox" name="salsa${j + 1}_${productoId}_${i + 1}" value="${salsas[j]}"> ${salsas[j]}<br>`;
                }
                var columnDiv = document.createElement('div');
                columnDiv.className = 'checkbox-column';
                columnDiv.innerHTML = salsaColumns;
                salsaGroup.appendChild(columnDiv);
            }

            salsasContainer.appendChild(salsaGroup);
        }

        salsasContainer.classList.add("show"); // Mostrar la columna de salsas
    } else {
        salsasContainer.classList.remove("show"); // Ocultar la columna de salsas si no está seleccionada la casilla
    }
}
