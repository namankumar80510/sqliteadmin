<div class="container mx-auto px-4 py-8">

    <a href="/database/<?= $this->e($databaseName) ?>/structure" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
        Back to Structure
    </a>

    <h1 class="text-4xl font-bold text-center mb-8">Edit Table: <?= $this->e($tableName) ?></h1>

    <form id="editTableForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div id="columns">
            <?php foreach ($tableStructure as $index => $column): ?>
                <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow">
                    <div class="flex space-x-4 mb-4">
                        <div class="flex-1">
                            <label for="columnName<?= $index ?>" class="block text-sm font-medium text-gray-700">Column Name</label>
                            <input type="text" name="columns[<?= $index ?>][name]" id="columnName<?= $index ?>" value="<?= $this->e($column['name']) ?>" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="flex-1">
                            <label for="columnType<?= $index ?>" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="columns[<?= $index ?>][type]" id="columnType<?= $index ?>" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="INTEGER" <?= $column['type'] === 'INTEGER' ? 'selected' : '' ?>>INTEGER</option>
                                <option value="TEXT" <?= $column['type'] === 'TEXT' ? 'selected' : '' ?>>TEXT</option>
                                <option value="REAL" <?= $column['type'] === 'REAL' ? 'selected' : '' ?>>REAL</option>
                                <option value="BLOB" <?= $column['type'] === 'BLOB' ? 'selected' : '' ?>>BLOB</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex space-x-4 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="columns[<?= $index ?>][nullable]" id="columnNullable<?= $index ?>" <?= $column['notnull'] == 0 ? 'checked' : '' ?> class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <label for="columnNullable<?= $index ?>" class="ml-2 block text-sm text-gray-900">Nullable</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="columns[<?= $index ?>][primary_key]" id="columnPrimaryKey<?= $index ?>" <?= $column['pk'] == 1 ? 'checked' : '' ?> class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <label for="columnPrimaryKey<?= $index ?>" class="ml-2 block text-sm text-gray-900">Primary Key</label>
                        </div>
                    </div>
                    <div>
                        <label for="columnDefault<?= $index ?>" class="block text-sm font-medium text-gray-700">Default Value</label>
                        <input type="text" name="columns[<?= $index ?>][default]" id="columnDefault<?= $index ?>" value="<?= $this->e($column['dflt_value']) ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="flex items-center justify-between mt-6">
            <button type="button" onclick="addColumn()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Add Column
            </button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
let columnCount = <?= count($tableStructure) ?>;

function addColumn() {
    const columnDiv = document.createElement('div');
    columnDiv.className = 'mb-6 p-4 bg-gray-50 rounded-lg shadow';
    columnDiv.innerHTML = `
        <div class="flex space-x-4 mb-4">
            <div class="flex-1">
                <label for="columnName${columnCount}" class="block text-sm font-medium text-gray-700">Column Name</label>
                <input type="text" name="columns[${columnCount}][name]" id="columnName${columnCount}" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="flex-1">
                <label for="columnType${columnCount}" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="columns[${columnCount}][type]" id="columnType${columnCount}" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="INTEGER">INTEGER</option>
                    <option value="TEXT">TEXT</option>
                    <option value="REAL">REAL</option>
                    <option value="BLOB">BLOB</option>
                </select>
            </div>
        </div>
        <div class="flex space-x-4 mb-4">
            <div class="flex items-center">
                <input type="checkbox" name="columns[${columnCount}][nullable]" id="columnNullable${columnCount}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="columnNullable${columnCount}" class="ml-2 block text-sm text-gray-900">Nullable</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="columns[${columnCount}][primary_key]" id="columnPrimaryKey${columnCount}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="columnPrimaryKey${columnCount}" class="ml-2 block text-sm text-gray-900">Primary Key</label>
            </div>
        </div>
        <div>
            <label for="columnDefault${columnCount}" class="block text-sm font-medium text-gray-700">Default Value</label>
            <input type="text" name="columns[${columnCount}][default]" id="columnDefault${columnCount}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
    `;
    document.getElementById('columns').appendChild(columnDiv);
    columnCount++;
}

document.getElementById('editTableForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch(`/database/<?= $this->e($databaseName) ?>/table/<?= $this->e($tableName) ?>/update`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Table updated successfully');
            window.location.href = `/database/<?= $this->e($databaseName) ?>/structure`;
        } else {
            alert('Failed to update table: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
});
</script>
