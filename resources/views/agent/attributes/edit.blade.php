@extends('layouts.admin')


@section('content')

{!! Form::open(['url' => '/agent/attributes/'.request()->segment(3), 'method'=>'put']) !!}

<!-- {!! Form::label('Name'); !!}<br>
{!! Form::text('name', $attribute->name); !!}<br><br> -->
{!! Form::label('Label'); !!}<br>
{!! Form::text('label',$attribute->label); !!}<br><br>
{!! Form::select('type', $types,$attribute->type,['placeholder' => 'Pick a type...']) !!}<br><br>

{!! Form::submit('Update'); !!}

{!! Form::close() !!}


@endsection
