@extends('layouts.app')

@section('content')
    <h1>Registration</h1>


    <form action="/register" method="post">
      {{csrf_field()}}

      

      Name: <input type="text" name="name" required><br>

      Surname: <input type="text" name="surname" required><br>

      Email: <input type="text" name="email" required><br>

      Password: <input type="text" name="pwd_hash" required><br>

      Birthdate :<input type="text" name="birth_date" required><br>

      City: <input type="text" name="citta" required><br>

      Gender: <input type="radio" name="gender" value="1" checked> Male
              <input type="radio" name="gender" value="0"> Female
              <input type="radio" name="gender" value="2"> Other<br>

      Picture: <input type="text" name="pic_path" required><br>

      <input type="submit" value="Register">
    </form>

@endsection
