import axios from 'axios';
import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

function formatDate(isoDate) {
    return new Date(isoDate).toLocaleString(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
}

const actionButtonClass =
    'inline-flex items-center rounded-md border px-2.5 py-1 text-xs font-medium transition-colors focus:outline-none focus:ring-2';

const copyButtonClass =
    `${actionButtonClass} border-emerald-500/25 text-emerald-700 hover:bg-emerald-50 focus:ring-emerald-500/40 dark:border-emerald-400/30 dark:text-emerald-400 dark:hover:bg-emerald-950/50`;

const deleteButtonClass =
    `${actionButtonClass} border-red-500/25 text-red-700 hover:bg-red-50 focus:ring-red-500/40 dark:border-red-400/30 dark:text-red-400 dark:hover:bg-red-950/50`;

async function copyEmail(email, button) {
    const label = button.textContent;

    try {
        await navigator.clipboard.writeText(email);
        button.textContent = 'Copied';
        button.disabled = true;

        setTimeout(() => {
            button.textContent = label;
            button.disabled = false;
        }, 1500);
    } catch {
        button.textContent = 'Failed';

        setTimeout(() => {
            button.textContent = label;
        }, 1500);
    }
}

async function deleteEmail(id, email, button, deleteBaseUrl, dataTable) {
    if (! confirm(`Delete ${email}?`)) {
        return;
    }

    const label = button.textContent;
    button.disabled = true;
    button.textContent = 'Deleting…';

    try {
        await axios.delete(`${deleteBaseUrl}/${id}`);
        button.closest('tr')?.remove();
        dataTable.update();
    } catch {
        button.textContent = 'Failed';
        button.disabled = false;

        setTimeout(() => {
            button.textContent = label;
        }, 1500);
    }
}

function appendRow(tbody, { id, email, created_at }, deleteBaseUrl, dataTable) {
    const row = document.createElement('tr');

    const emailCell = document.createElement('td');
    emailCell.textContent = email;

    const dateCell = document.createElement('td');
    dateCell.textContent = formatDate(created_at);

    const actionsCell = document.createElement('td');

    const actionsWrapper = document.createElement('div');
    actionsWrapper.className = 'flex items-center gap-2';

    const copyButton = document.createElement('button');
    copyButton.type = 'button';
    copyButton.textContent = 'Copy';
    copyButton.className = copyButtonClass;
    copyButton.setAttribute('aria-label', `Copy ${email}`);
    copyButton.addEventListener('click', () => copyEmail(email, copyButton));

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.textContent = 'Delete';
    deleteButton.className = deleteButtonClass;
    deleteButton.setAttribute('aria-label', `Delete ${email}`);
    deleteButton.addEventListener('click', () => deleteEmail(id, email, deleteButton, deleteBaseUrl, dataTable));

    actionsWrapper.append(copyButton, deleteButton);
    actionsCell.appendChild(actionsWrapper);

    row.append(emailCell, dateCell, actionsCell);
    tbody.appendChild(row);
}

document.addEventListener('DOMContentLoaded', async () => {
    const table = document.querySelector('#emails-table');

    if (! table) {
        return;
    }

    const tbody = table.querySelector('tbody');
    const url = table.dataset.url;
    const deleteBaseUrl = table.dataset.deleteUrl;

    const dataTable = new DataTable(table, {
        searchable: true,
        sortable: true,
        perPage: 10,
        columns: [
            { select: 2, sortable: false },
        ],
        labels: {
            placeholder: 'Search emails…',
            noRows: 'No emails yet',
            noResults: 'No matching emails',
        },
    });

    try {
        const { data } = await axios.get(url);

        data.forEach((email) => {
            appendRow(tbody, email, deleteBaseUrl, dataTable);
        });

        dataTable.update();
    } catch {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 3;
        cell.textContent = 'Could not load emails.';
        row.appendChild(cell);
        tbody.appendChild(row);
        dataTable.update();
    }
});
