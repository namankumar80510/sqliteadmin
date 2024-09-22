<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Database Structure: <?= $this->e($databaseName) ?></h1>

    <div class="mb-8">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="showNewTableModal()">
            Add New Table
        </button>
    </div>

    <?php foreach ($tables as $table): ?>
        <div class="mb-8 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex justify-between items-center cursor-pointer" onclick="toggleTable('<?= $this->e($table->name) ?>')">
                <h2 class="text-2xl font-semibold"><?= $this->e($table->name) ?></h2>
                <div>
                    <a href="/database/<?= $this->e($databaseName) ?>/table/<?= $this->e($table->name) ?>/data" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded mr-2">
                        View Data
                    </a>
                    <a href="/database/<?= $this->e($databaseName) ?>/table/<?= $this->e($table->name) ?>/edit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded mr-2">
                        Edit
                    </a>
                    <a href="/database/<?= $this->e($databaseName) ?>/table/<?= $this->e($table->name) ?>/delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                        Delete
                    </a>
                    <svg class="h-6 w-6 inline-block ml-2 transform transition-transform duration-200" id="arrow-<?= $this->e($table->name) ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            <div class="overflow-x-auto hidden" id="table-<?= $this->e($table->name) ?>">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Column Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nullable</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Primary Key</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($tableStructures[$table->name] as $column): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap"><?= $this->e($column->name) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $this->e($column->type) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $column->notnull ? 'No' : 'Yes' ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $this->e($column->dflt_value) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $column->pk ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- New Table Modal -->
<div id="newTableModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Create New Table
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="hideNewTableModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2">
                    <form id="newTableForm" class="space-y-6">
                        <div>
                            <label for="tableName" class="block text-sm font-medium text-gray-700">Table Name</label>
                            <input type="text" name="tableName" id="tableName" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div id="columns" class="space-y-4">
                            <!-- Column inputs will be dynamically added here -->
                        </div>
                        <div>
                            <button type="button" onclick="addColumn()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Column
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="createNewTable()">
                    Create
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="hideNewTableModal()">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let columnCount = 0;
    const databaseName = <?= json_encode($databaseName) ?>;

    function showNewTableModal() {
        document.getElementById('newTableModal').classList.remove('hidden');
    }

    function hideNewTableModal() {
        if (confirm('Are you sure?')) {
            document.getElementById('newTableModal').classList.add('hidden');
            document.getElementById('newTableForm').reset();
            document.getElementById('columns').innerHTML = '';
            columnCount = 0;
        }
    }

    function addColumn() {
        columnCount++;
        const columnDiv = document.createElement('div');
        columnDiv.className = 'bg-gray-50 p-4 rounded-lg shadow';
        columnDiv.innerHTML = `
        <div class="flex space-x-4 mb-4">
            <div class="flex-1">
                <label for="columnName${columnCount}" class="block text-sm font-medium text-gray-700">Column Name</label>
                <input type="text" name="columnName${columnCount}" id="columnName${columnCount}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="flex-1">
                <label for="columnType${columnCount}" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="columnType${columnCount}" id="columnType${columnCount}" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="INTEGER">INTEGER</option>
                    <option value="TEXT">TEXT</option>
                    <option value="REAL">REAL</option>
                    <option value="BLOB">BLOB</option>
                </select>
            </div>
        </div>
        <div class="flex space-x-4 mb-4">
            <div class="flex items-center">
                <input type="checkbox" name="columnNullable${columnCount}" id="columnNullable${columnCount}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="columnNullable${columnCount}" class="ml-2 block text-sm text-gray-900">Nullable</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="columnPrimaryKey${columnCount}" id="columnPrimaryKey${columnCount}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="columnPrimaryKey${columnCount}" class="ml-2 block text-sm text-gray-900">Primary Key</label>
            </div>
        </div>
        <div>
            <label for="columnDefault${columnCount}" class="block text-sm font-medium text-gray-700">Default Value</label>
            <input type="text" name="columnDefault${columnCount}" id="columnDefault${columnCount}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
    `;
        document.getElementById('columns').appendChild(columnDiv);
    }

    function createNewTable() {
        const form = document.getElementById('newTableForm');
        const formData = new FormData(form);

        // Construct the table creation data
        let tableData = {
            tableName: formData.get('tableName'),
            columns: []
        };

        for (let i = 1; i <= columnCount; i++) {
            const column = {
                name: formData.get(`columnName${i}`),
                type: formData.get(`columnType${i}`),
                nullable: formData.get(`columnNullable${i}`) === 'on',
                primaryKey: formData.get(`columnPrimaryKey${i}`) === 'on',
                defaultValue: formData.get(`columnDefault${i}`) || null
            };
            tableData.columns.push(column);
        }

        // Send the POST request to create the table
        fetch(`/database/${databaseName}/structure/create`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(tableData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Success:', data);
                    hideNewTableModal();
                    // After successful creation, refresh the page to show the new table
                    location.reload();
                } else {
                    console.error('Error:', data);
                    // Handle errors here, e.g., show an error message to the user
                    alert('Failed to create table: ' + (data.error || 'Unknown error'));
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                // Handle network errors or other exceptions
                alert('An error occurred. Please try again later.');
            });
    }

    // Prevent closing the modal when clicking outside
    document.getElementById('newTableModal').addEventListener('click', function(event) {
        if (event.target === this) {
            event.stopPropagation();
        }
    });

    function toggleTable(tableName) {
        const tableContent = document.getElementById(`table-${tableName}`);
        const arrow = document.getElementById(`arrow-${tableName}`);

        if (tableContent.classList.contains('hidden')) {
            tableContent.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            tableContent.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }
</script>