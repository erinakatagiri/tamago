@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <?php $user = Auth::user(); ?>
        @include('index')
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome</h1>
                {!! link_to_route('signup.get', 'Sign up', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection

