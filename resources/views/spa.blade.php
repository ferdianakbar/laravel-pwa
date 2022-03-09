@extends('layouts.blog')

@section('content')

    <main id="app" data-site-name="{{config('app.name')}}">
        <navigation ref="nav"></navigation>
        <router-view></router-view>
        <footer-view></footer-view>
    </main>

@endsection
