$(document).ready(function() {
    // Verifica si #servicesTable existe
    if ($('#servicesTable').length) {
        // Si existe, inicializa el DataTable
        $('#servicesTable').DataTable({            
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '40%', targets: 1 },
                { width: '10%', targets: 2 },
                { width: '15%', targets: 3 },
                { width: '10%', targets: 4 },
                { width: '20%', targets: 5 },
            ]
        });
    }
    if ($('#statusTable').length) {
        // Si existe, inicializa el DataTable
        $('#statusTable').DataTable({            
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '55%', targets: 1 },
                { width: '10%', targets: 2 },
                { width: '30%', targets: 3 },
            ]
        });
    }
    if ($('#rolesTable').length) {
        // Si existe, inicializa el DataTable
        $('#rolesTable').DataTable({            
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '55%', targets: 1 },
                { width: '10%', targets: 2 },
                { width: '30%', targets: 3 },
            ]
        });
    }
    if ($('#modulesTable').length) {
        // Si existe, inicializa el DataTable
        $('#modulesTable').DataTable({            
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '55%', targets: 1 },
                { width: '10%', targets: 2 },
                { width: '30%', targets: 3 },
            ]
        });
    }
    if ($('#accommodationTable').length) {
        // Si existe, inicializa el DataTable
        $('#accommodationTable').DataTable({            
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
            },
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '25%', targets: 1 },
                { width: '25%', targets: 2 },
                { width: '25%', targets: 3 },
                { width: '10%', targets: 3 },
                { width: '10%', targets: 3 },
            ]
        });
    }
});

// Script para manejar la selección de íconos
if ($('#fa_icon').length) {
    document.querySelectorAll('.select-icon').forEach(button => {
        button.addEventListener('click', function () {
            let icon = this.getAttribute('data-icon');
            document.getElementById('fa_icon').value = icon;
            document.getElementById('selectedIcon').className = 'fas ' + icon;
            $('.modal').modal('hide');
        });
    });
}

 function loadCountries() {
    fetch('https://restcountries.com/v3.1/region/america')
        .then(response => response.json())
        .then(data => {
            // Ordenar los países alfabéticamente
            const countries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            const destinationSelect = document.getElementById('destination');
            // Agregar las opciones al select
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.cca2;
                option.textContent = country.name.common;
                destinationSelect.appendChild(option);
            });
            // Inicializar Select2
            $(destinationSelect).select2();
        })
        .catch(error => {
            console.error('Error al cargar los países:', error);
        });
}

function updateGuestsSummary() {
    const adults = document.getElementById('adults').value;
    const children = document.getElementById('children').value;
    const beds = document.getElementById('beds').value;

    let summary = `${adults} adulto${adults > 1 ? 's' : ''}`;
    if (children > 0) {
        summary += `, ${children} niño${children > 1 ? 's' : ''}`;
    }
    summary += `, ${beds} cama${beds > 1 ? 's' : ''}`;

    document.getElementById('guestsSummary').innerText = summary;
    // Cierra el dropdown después de aplicar
    const dropdown = document.getElementById('guestsDropdown');
    const bsDropdown = bootstrap.Dropdown.getInstance(dropdown);
    bsDropdown.hide();
}

if ($('#destination').length){
    window.onload = loadCountries;
}


