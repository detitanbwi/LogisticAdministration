@extends('errors.layout')

@section('title', '503 - Service Unavailable')

@section('code')
    5<span class="text-danger">0</span>3
@endsection

@section('message', 'Service Unavailable')

@section('description', 'Sorry, we are currently under maintenance. We will be back shortly.')
