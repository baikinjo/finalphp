@extends('layouts.basic')
@section('maincontent')
    {{HTML::linkAction('GameController@play', 'Play Game')}}
    {{HTML::linkAction('GameController@index', 'Back to mainpage')}}