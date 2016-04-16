
@extends('layouts.basic')
@section('maincontent')
    <h1>Welcome</h1>

    <div>
        <strong>Instruction: </strong>
        <p>
            Left or Right, LoR, is simple luck test game, where user can choose left or right button to tests one's luck.
            Sometimes, the random middle button also pops up. You will give 10 seconds to make a choice; faster you choose,
            higher points will be awarded. Test how many streaks you can reach to test out your luck of the day!
        </p>
    </div>
    <hr>
    <div>
        {{HTML::linkRoute('foo')}}
    </div>
