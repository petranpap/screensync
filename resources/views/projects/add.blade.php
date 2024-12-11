<x-app-layout>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Form to create a new project -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create a New Project</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('create.project') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Project Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Project</button>
                                    <button style="float: right" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>

</x-app-layout>



