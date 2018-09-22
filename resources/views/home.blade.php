@extends('layouts.app')

@section('content')
<comments :user="{{ auth()->user() }}"></comments>
@endsection
