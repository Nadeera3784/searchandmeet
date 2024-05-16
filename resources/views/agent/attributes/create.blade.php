@extends('layouts.admin')


@section('content')

{!! Form::open(['url' => '/agent/attributes']) !!}

<!-- {!! Form::label('Name'); !!}<br>
{!! Form::text('name'); !!}<br><br> -->
{!! Form::label('Label'); !!}<br>
{!! Form::text('label'); !!}<br><br>
{!! Form::select('type', $types,old('type'),['placeholder' => 'Pick a type...']) !!}<br><br>

{!! Form::submit('save'); !!}

{!! Form::close() !!}


@endsection
