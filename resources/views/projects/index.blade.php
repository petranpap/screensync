<x-app-layout>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->

                <div class="row">
                    <!-- create a new project -->
                        <div class="col-md-12 mt-3">
                            <a href="/add-project" class="btn btn-success">Create New Project</a>
                        </div>

                    <div class="col-md-12 mt-3">
                    @foreach ($projects as $project)
                            <div class="card card-primary mb-4">
                                <div class="card-header" onclick="toggleCard(this)">
                                    <h3 class="card-title">{{ $project->name }}</h3>

                                </div>
                                <div class="card-body" style="display: none;">
                                    <p>{{ $project->description }}</p>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Screen Name</th>
                                            <th>MAC Address</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="project-{{ $project->id }}" class="screens-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                                        @if(isset($screensByProject[$project->id]))
                                            @foreach ($screensByProject[$project->id] as $screen)
                                                <tr id="screen-{{ $screen->screen_id }}" draggable="true" ondragstart="drag(event)">
                                                    <td>{{ $screen->screen_id }}</td>
                                                    <td>{{ $screen->screen_name }}</td>
                                                    <td>{{ $screen->mac_address }}</td>
                                                    <td>{{ $screen->active ? 'Yes' : 'No' }}</td>
                                                    <td>
                                                        <button class="btn btn-danger" onclick="removeScreenFromProject({{ $screen->screen_id }})">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">No screens assigned to this project.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
{{--                                    <form action="{{ route('add.screen') }}" method="POST">--}}
{{--                                        @csrf--}}
{{--                                        <input type="hidden" name="project_id" value="{{ $project->id }}">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="screen_name_{{ $project->id }}">Screen Name</label>--}}
{{--                                            <input type="text" class="form-control" id="screen_name_{{ $project->id }}" name="screen_name" required>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="mac_address_{{ $project->id }}">MAC Address</label>--}}
{{--                                            <input type="text" class="form-control" id="mac_address_{{ $project->id }}" name="mac_address" required>--}}
{{--                                        </div>--}}
{{--                                        <button type="submit" class="btn btn-primary">Add Screen</button>--}}
{{--                                    </form>--}}
                                </div>
                            </div>

                    @endforeach
                    </div>
                    <div class="col-md-12">
                        @if($unassignedScreens->count()>0)
                        <div class="card mb-4">
                            <div class="card-header card-danger" onclick="toggleCard(this)">
                                <h3 class="card-title">Unassigned Screens</h3>
                            </div>
                            <div class="card-body" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Screen Name</th>
                                        <th>MAC Address</th>
                                        <th>Active</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-unassigned" class="screens-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                                    @foreach ($unassignedScreens as $screen)
                                        <tr id="screen-{{ $screen->screen_id }}" draggable="true" ondragstart="drag(event)">
                                            <td>{{ $screen->screen_id }}</td>
                                            <td>{{ $screen->screen_name }}</td>
                                            <td>{{ $screen->mac_address }}</td>
                                            <td>{{ $screen->active ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            <script>
                function toggleCard(header) {
                    const cardBody = header.nextElementSibling;
                    if (cardBody.style.display === "none") {
                        cardBody.style.display = "block";
                    } else {
                        cardBody.style.display = "none";
                    }
                }

                function allowDrop(ev) {
                    ev.preventDefault();
                }

                function drag(ev) {
                    ev.dataTransfer.setData("text", ev.target.id);
                }

                function drop(ev) {
                    ev.preventDefault();
                    var data = ev.dataTransfer.getData("text");
                    var screenElement = document.getElementById(data);
                    ev.target.closest('tbody').appendChild(screenElement);

                    // Update the backend with the new project assignment
                    var screenId = data.split('-')[1];
                    var projectId = ev.target.closest('tbody').id.split('-')[1];
                    if (projectId === "unassigned") {
                        projectId = null;
                    }
                    updateScreenProject(screenId, projectId);
                }

                function updateScreenProject(screenId, projectId) {
                    fetch('/update-screen-project', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            screen_id: screenId,
                            project_id: projectId
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Screen project updated successfully.');
                            } else {
                                console.error('Failed to update screen project.');
                            }
                        }).catch(error => {
                        console.error('Error:', error);
                    });
                }

                function removeScreenFromProject(screenId) {
                    updateScreenProject(screenId, null);
                    document.getElementById('screen-' + screenId).remove();
                    window.location.reload();
                }
            </script>

                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>

</x-app-layout>



