@extends('layouts.email')

@section('title', $subject)

@section('content')

    <h1>{{ $subject }}</h1>
    <p>A new payment is made.</p>
    <h2>Details are below:</h2>
    <p>Name: {{ $name }}</p>
    <p>Amount: {{ $value }} {{ $currency }}</p>
    <p>Time: {{ $date }}</p>

@endsection