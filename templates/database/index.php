<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Databases</h1>
    
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-2/3 px-4 mb-8">
            <?php if (empty($databases)): ?>
                <p class="text-gray-600">No databases found.</p>
            <?php else: ?>
                <ul class="bg-white shadow-md rounded-lg overflow-hidden">
                    <?php foreach ($databases as $database): ?>
                        <li class="border-b last:border-b-0">
                            <div class="flex justify-between items-center p-4">
                                <a href="/database/<?php echo $this->e($database['name']); ?>/structure" class="text-blue-600 hover:text-blue-800"><?php echo $this->e($database['name']); ?></a>
                                <a href="/database/<?php echo $this->e($database['name']); ?>/structure" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded">
                                    Structure
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <div class="w-full lg:w-1/3 px-4">
            <h2 class="text-2xl font-semibold mb-4">Add New Database</h2>
            <form action="database/create" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="dbName" class="block text-sm font-medium text-gray-700">Database Name</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="dbName" name="dbName" required>
                </div>
                <div class="mb-4">
                    <label for="dbPath" class="block text-sm font-medium text-gray-700">Database Path</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="dbPath" name="dbPath" required>
                </div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Database
                </button>
            </form>
        </div>
    </div>
</div>

