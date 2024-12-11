@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Choose a Template</h1>
        <ul>
            @foreach ($templates as $template)
                <li>{{ $template->name }}</li>
                <form action="/screens/{{ $screen->id }}/templates" method="POST">
                    @csrf
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                    <input type="file" name="image_file">
                    <button type="submit">Apply</button>
                </form>
            @endforeach
        </ul>
    </div>
@endsection
