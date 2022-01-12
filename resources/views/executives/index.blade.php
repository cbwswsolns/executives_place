@extends('layouts.master')

@section('content')

  <div class="container-fluid"> 

    <div class="row">

      <div class="col-6">

        <h1>Executives - List</h1>

      </div>

      <div class="col-6 text-right">

        <a href="{{ route('users.create') }}" class="btn btn-info">

          Create Executive

        </a>

      </div>

    </div>

  </div>

  <hr>

  @if(Session::has('success'))

      <div class="alert alert-success">

          {{ Session::get('success') }}

      </div>

  @endif

  @if ($users->isEmpty())

    <div class="alert alert-info" role="alert">

      Please add an executive to the list...

    </div>

  @else

    <table class="table">

      <thead>

        <tr>

          <th scope="col">

            Name

          </th>

          @foreach($currencies as $currency)

            <th scope="col"
                class="text-center">

              Profile ({{ $currency }})

            </th>

          @endforeach

        </tr>

      </thead>

      <tbody>

        @foreach($users as $user)

        <tr>

          <td>

            {{ $user->name }}

          </td>

          @foreach($currencies as $currency)

          <td class="text-center">
            
            <a href="{{ route('users.show', [$user, 'CUR' => $currency]) }}" class="btn btn-info" role="button">View</a>

          </td>

          @endforeach

        </tr>

        @endforeach

      </tbody>

    </table>

  @endif

@endsection