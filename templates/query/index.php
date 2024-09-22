<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Query Database</h1>
    
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-2/3 px-4 mb-8">
            <form action="/query/run" method="post" class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-8 py-6 space-y-6">
                    <div>
                        <label for="databaseName" class="block text-sm font-medium text-gray-700 mb-1">Select Database</label>
                        <select id="databaseName" name="databaseName" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <?php foreach ($databases as $database): ?>
                                <option value="<?= $this->e($database['name']) ?>"><?= $this->e($database['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="query" class="block text-sm font-medium text-gray-700 mb-1">SQL Query</label>
                        <div id="editor" class="w-full h-64 border border-gray-300 rounded-md"></div>
                        <textarea id="query" name="query" class="hidden"></textarea>
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Run Query
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full lg:w-1/3 px-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Query Tips</h2>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                        <li>Use SELECT to retrieve data</li>
                        <li>Use INSERT to add new records</li>
                        <li>Use UPDATE to modify existing records</li>
                        <li>Use DELETE to remove records</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/tomorrow");
        editor.session.setMode("ace/mode/sql");
        editor.setOptions({
            fontSize: "14px",
            showPrintMargin: false,
            showGutter: true,
            highlightActiveLine: true,
            wrap: true
        });
        
        var textarea = document.getElementById('query');
        editor.getSession().on("change", function () {
            textarea.value = editor.getSession().getValue();
        });
    });
</script>
