@extends('layouts.app')

@section('title')
  work_xml
@endsection

@section('content')
<h1>Website for translating xml files</h1>

<form action="{{ route('file_analyzes') }}" method="post">
  @csrf
  <div class="form-group">
    <button type="submit" name="button" class="GO">GO</button>
  </div>
</form>

<form action="{{ route('file_output') }}" method="get">
  @csrf
  <div class="form-group">
    <button type="submit" name="button2" class="OUT">OUT</button>
  </div>
</form>
@endsection
