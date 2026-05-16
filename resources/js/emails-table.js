import axios from 'axios';
import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

function formatDate(isoDate) {
    return new Date(isoDate).toLocaleString(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
}

const copyButtonClass =
    'inline-flex items-center rounded-md border border-emerald-500/25 px-2.5 py-1 text-xs font-medium text-emerald-700 transition-colors hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 dark:border-emerald-400/30 dark:text-emerald-400 dark:hover:bg-emerald-950/50';

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

function appendRow(tbody, email, createdAt) {
    const row = document.createElement('tr');

    const emailCell = document.createElement('td');
    emailCell.textContent = email;

    const dateCell = document.createElement('td');
    dateCell.textContent = formatDate(createdAt);

    const actionsCell = document.createElement('td');
    const copyButton = document.createElement('button');
    copyButton.type = 'button';
    copyButton.textContent = 'Copy';
    copyButton.className = copyButtonClass;
    copyButton.setAttribute('aria-label', `Copy ${email}`);
    copyButton.addEventListener('click', () => copyEmail(email, copyButton));
    actionsCell.appendChild(copyButton);

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

    try {
        const { data } = await axios.get(url);

        data.forEach((email) => {
            appendRow(tbody, email.email, email.created_at);
        });
    } catch {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 3;
        cell.textContent = 'Could not load emails.';
        row.appendChild(cell);
        tbody.appendChild(row);
    }

    new DataTable(table, {
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
});
