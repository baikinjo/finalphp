<!DOCTYPE HTML>
<html>
<head>
    <title>PHP FINAL COMP 3975</title>

    <style>
        #win{
            color: green;
        }
        #score{
            color: blue;
        }
        body {
            font-family: 'Source Sans Pro', 'Arial';
            font-size: 24px;
        }

    </style>
</head>

<body>
<h1 align="center">TEST LUCK!</h1>

<table align="center">
    <tbody>
    <tr>
        <th>
            <p>Wins: <span id="win"></span>
            Score: <span id="score"></span>
            Timer: <span id="time"></span></p>
        </th>
    </tr>
    <tr>
        <th>
            <canvas id="myCanvas" width="600" height="300"></canvas>
        </th>
    </tr>
    </tbody>
</table>

<p align="center"><span id="status"></span></p>

<script>

    var score = 0;
    var numWin = 0;
    var numLoss = 0;
    var ratioValue = 0;
    var currentTime;
    var checkTime = 0;
    var stats = document.getElementById('status');
    stats.innerHTML = 'Choose a door.';
    var win = document.getElementById('win');
    win.innerHTML = numWin;
    var scoring = document.getElementById('score');
    scoring.innerHTML = numLoss;
    var timer = document.getElementById('time');
    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
    var imageOpenDoor = new Image();
    var imageCloseDoor = new Image();
    var imageCheck = new Image();
    var imageGoat = new Image();
    var imageCar = new Image();

    imageOpenDoor.src = 'img/open_door.png'
    imageCloseDoor.src ='img/closed_door.png'
    imageCheck.src = 'img/check.png'
    imageGoat.src = 'img/goat.png'
    imageCar.src = 'img/car.png'


    var carDoor = Math.floor(Math.random() * 3);
    var goatDoors = [];
    i = -1
    while(++i < 3) {
        if (i != carDoor) {goatDoors.push(i)};
    }
    imageCloseDoor.onload = function() {
        context.drawImage(imageCloseDoor, 0,0,200, 350);
        context.drawImage(imageCloseDoor, 200,0,200, 350);
        context.drawImage(imageCloseDoor, 400,0,200, 350);
    };


    var counter = 5;
    var id;

    id = setInterval(function() {

        if(counter < 0) {
            turn=-10;
            stats.innerHTML = 'Time Ran Out!';
            
        } else {
            timer.innerHTML = (counter).toString() + " seconds.";
        }
        if(checkTime != 1)
            counter--;
    }, 1000);

    var doors = [false,false,false];
    var turn = 0;
    var check = 0;
    var openDoor = 0;
    canvas.addEventListener('click', function(event) {
        var rect = canvas.getBoundingClientRect();
        var x = event.pageX - rect.left;
        var y = event.pageY - rect.top;

        if(turn == -1){
            doors = [false,false,false];
            check = 0;
            openDoor = 0;
            carDoor = Math.floor(Math.random() * 3);
            goatDoors = [];
            i = -1
            while(++i < 3) {
                if (i != carDoor) {goatDoors.push(i)};
            }
            context.clearRect(0,0,canvas.width,canvas.height)
            context.drawImage(imageCar, carDoor*200+50,200,120, 80);
            goatDoors.forEach(function(d){
                context.drawImage(imageGoat, d*200 + 75,180,101, 100);
            });
            context.drawImage(imageCloseDoor, 0,0,200, 350);
            context.drawImage(imageCloseDoor, 200,0,200, 350);
            context.drawImage(imageCloseDoor, 400,0,200, 350);

            stats.innerHTML = 'Continue! Choose a door again!';
            counter = 5;
            checkTime = 0;
            ++turn;
        } else {
            if (turn == 0){
                check = 0;
                if (x < 200 && x > 0) {check = 0;}
                if (x < 400 && x > 200) {check = 1;}
                if (x < 600 && x > 400) {check = 2;}
                openDoor = Math.floor(Math.random() * 3);
                while(openDoor == check || openDoor == carDoor){
                    openDoor = Math.floor(Math.random() * 3);
                }
                doors[openDoor] = true;
                context.clearRect(0,0,canvas.width,canvas.height);
                context.drawImage(imageCar, carDoor*200+50,200,120, 80);
                goatDoors.forEach(function(d){
                    context.drawImage(imageGoat, d*200 + 75,180,101, 100);
                });
                i = -1;
                while(++i < 3){
                    if(!doors[i]){
                        context.drawImage(imageCloseDoor, i*200,0,200, 350);
                    }
                    else{
                        context.drawImage(imageOpenDoor, i*200-2,0,212, 370);
                    }
                }
                context.drawImage(imageCheck, check*200+50,50,50,50);
                stats.innerHTML = 'Stay or switch?'
                ++turn;
            }
            else{
                if (turn > 0){
                    open = 0;
                    if (x < 200 && x > 0) {open = 0;}
                    if (x < 400 && x > 200) {open = 1;}
                    if (x < 600 && x > 400) {open = 2;}
                    if(open == openDoor){
                        return;
                    }
                    doors[open] = true;
                    context.clearRect(0,0,canvas.width,canvas.height)
                    context.drawImage(imageCar, carDoor*200+50,200,120, 80);
                    goatDoors.forEach(function(d){
                        context.drawImage(imageGoat, d*200 + 75,180,101, 100);
                    });
                    i = -1;
                    while(++i < 3){
                        if(!doors[i]){
                            context.drawImage(imageCloseDoor, i*200,0,200, 350);
                        }
                        else{
                            context.drawImage(imageOpenDoor, i*200-2,0,212, 370);
                        }
                    }
                    context.drawImage(imageCheck, check*200+50,50,50,50);
                    if(open == carDoor){
                        ++numWin;
                        stats.innerHTML = 'Congratulations!';
                        score += 100*(counter);
                        turn = -1;
                        checkTime = 1;
                        currentTime = counter;
                    }
                    else {
                        ++numLoss;
                        stats.innerHTML = 'You lost!';
                        turn = -10;
                        checkTime = 1;
                        currentTime = counter;
                    }
                    win.innerHTML = numWin;
                    scoring.innerHTML = score;
                    timer.innerHTML = currentTime.toString() + " seconds.";

                };

            }

        }

    }, false);


</script>

    {{Form::open(['route'=>'game.store'])}}
    <div>
        {{Form::label('username', "Name: ")}}
        {{Form::text('username')}}
    </div>
    <div>
        {{Session::put(['score'=>"score"])}}
    </div>
    <div>
        {{Session::put(['streak'=>"win"])}}
    </div>
    <div>
        {{Form::submit('Save')}}
    </div>
    {{Form::close()}}


{{HTML::linkAction('GameController@play', 'Play Again')}}
{{HTML::linkAction('GameController@result', 'Result')}}
</body>
</html>