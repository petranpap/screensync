<x-app-layout>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Project</th>
                                <th>Unique address</th>
                                <th>Active Since</th>
                                <th>Template</th>
                                <th>Active</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($screens as $screen)
                                <tr>
                                    <td>{{$screen->id}}</td>
                                    <td>{{$screen->name}}</td>
                                    <td>{{$screen->pname}}</td>
                                    <td>{{$screen->uuid}}</td>
                                    <td>{{$screen->created_at}}</td>
                                    <td>{{$screen->tname}}</td>
                                    <td>{{$screen->active}}</td>
                                    <td>{{$screen->pname}}</td>
                                    <td>{{$screen->pname}}</td>



                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>

</x-app-layout>



