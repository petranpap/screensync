<x-app-layout>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->

                <div class="row">
                    <!-- create a new project -->
                    <div class="col-md-12 mt-3">
                        <div id="video"></div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let uuid = localStorage.getItem('screenUUID');

            if (!uuid) {
                // Generate a new UUID if not found
                uuid = generateUUID();
                localStorage.setItem('screenUUID', uuid);


                // Register the new UUID with the server
                registerUUIDWithServer(uuid);
            }
            console.log(uuid)
            // Use the UUID to fetch the content
            fetchContent(uuid);
        });

        // Function to generate a UUID
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Function to register the UUID with the server
        function registerUUIDWithServer(uuid) {
            fetch('/register-uuid', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ uuid: uuid })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('UUID registered:', data);
                })
                .catch(error => console.error('Error registering UUID:', error));
        }

        // Function to fetch content based on UUID
        function fetchContent(uuid) {
            fetch('/fetchdata', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ uuid: uuid })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Test:', data['uuid']);
                    $('#video').text(data['uuid'])

                })
                .catch(error => console.error('Error registering UUID:', error));

        }

    </script>

</x-app-layout>
