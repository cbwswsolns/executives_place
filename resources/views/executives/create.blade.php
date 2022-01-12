@extends('layouts.master')

@section('content')

  <div class="container-fluid"> 

    <div class="row">

      <div class="col-6">

        <h1>Executive - Create</h1>

      </div>

      <div class="col-6 text-right">

        <a href="{{ route('users.index') }}" class="btn btn-info">

          < Executives - Listing

        </a>

      </div>

    </div>

  </div>

  <hr>

  <form
    action="{{ route('users.store') }}"
    method="POST"
    novalidate>

    @csrf

    <div class="form-group py-2">

      <label for="title">

        Name

      </label>

      <input
        id="name"
        type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name') }}">

      @error('name')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('name') }}

          </strong>

        </span>

      @enderror

    </div>

    <div class="form-group py-2">

      <label for="title">

        Company Name (optional)

      </label>

      <input
        id="company_name"
        type="text"
        name="company_name"
        class="form-control @error('company_name') is-invalid @enderror"
        value="{{ old('company_name') }}">

      @error('company_name')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('company_name') }}

          </strong>

        </span>

      @enderror

    </div>

    <div class="form-group py-2">

      <label for="title">

        Job Title

      </label>

      <input
        id="job_title"
        type="text"
        name="job_title"
        class="form-control @error('job_title') is-invalid @enderror"
        value="{{ old('job_title') }}">

      @error('job_title')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('job_title') }}

          </strong>

        </span>

      @enderror

    </div>

    <div class="form-group py-2">

      <label for="phone">

        Phone number (currently only validates UK numbers)

      </label>

      <input
        id="phone"
        type="text"
        name="phone"
        class="form-control @error('phone') is-invalid @enderror"
        value="{{ old('phone') }}">

      @error('phone')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('phone') }}

          </strong>

        </span>

      @enderror

    </div>

    <div class="form-group py-2">

      <label for="email">

        E-mail

      </label>

      <input
        id="email"
        type="email"
        name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email') }}">

      @error('email')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('email') }}

          </strong>

        </span>

      @enderror

    </div>

    <div class="form-group py-2">

      <label for="hourly_rate">

        Hourly rate

      </label>

      <input
        id="hourly_rate"
        type="number"
        name="hourly_rate"
        class="form-control @error('hourly_rate') is-invalid @enderror"
        value="{{ old('hourly_rate') }}">

      @error('hourly_rate')

        <span class="invalid-feedback">

            <strong>

              {{ $errors->first('hourly_rate') }}

            </strong>

        </span>

      @enderror

    </div>

    <div class="form-group">
              
      <label for="currency">

        Select Currency

      </label>

      <select 
        id="currency"
        name="currency"
        class="form-control @error('currency') is-invalid @enderror">
          
        <option value="">

          Select a currency...

        </option>

        @foreach($currencies as $key => $currency)
        
          <option value="{{ $currency }}" {{ ($currency == old('currency') ? 'selected' : '') }}>

              {{ $currency }}

          </option>

        @endforeach

      </select>
              
      @error('currency')

        <span class="invalid-feedback">

          <strong>

            {{ $errors->first('currency') }}

          </strong>

        </span>

      @enderror           

    </div>

    <div class="form-group">

      <button
        type="submit"
        class="btn btn-primary">

        Create

      </button>
        
    </div>

  </form>

@endsection
