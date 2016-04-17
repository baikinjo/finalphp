@extends('layouts.basic')
@section('maincontent')
    {{HTML::linkAction('GameController@play', 'Play Game')}}
    {{HTML::linkAction('GameController@index', 'Back to mainpage')}}


    <h1>High Scores</h1>
    @foreach($games as $u)
        <li>{{ $u->username . " ", $u->score . " " , $u->streak . " "}}</li>
    @endforeach