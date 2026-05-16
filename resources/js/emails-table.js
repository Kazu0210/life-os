import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#emails-table');

    if (! table) {
        return;
    }

    new DataTable(table, {
        searchable: true,
        sortable: true,
        perPage: 10,
        labels: {
            placeholder: 'Search emails…',
            noRows: 'No emails yet',
            noResults: 'No matching emails',
        },
    });
});
