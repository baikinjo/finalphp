<!DOCTYPE HTML>
<html>
<head>
    <title>Monty Hall simulation</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro">
    <style>
        #win{
            color: green;
        }
        #loss{
            color: red;
        }
        #ratio{
            font-size: 24px;
        }
        body {
            font-family: 'Source Sans Pro', 'Arial';
            font-size: 24px;
            background-color: #F9F9F9;
        }
        canvas { /* Just to get rid of selected text when click */
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            outline: none;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0); /* mobile webkit */
        }
    </style>
</head>

<body>
<h1 align="center">TEST LUCK!</h1>

<table align="center">
    <tbody>
    <tr>

        <th>
            <p>Wins: <span id="win"></span></p>
        </th>
        <th>
            <p>Score: <span id="loss"></span></p>
        </th>
        <th>
            <p>Timer: <span id="ratio"></span></p>
        </th>

    </tr>

    <tr>
        <th>
            <canvas id="myCanvas" width="600" height="400"></canvas>
        </th>

    </tr>
    </tbody>
</table>

<p align="center"><span id="status"></span></p>

<script>
    // Variables to keep track of score
    var score = 0;
    var numWin = 0;
    var numLoss = 0;
    var ratioValue = 0;
    // Html element to write messages to player
    var stats = document.getElementById('status');
    stats.innerHTML = 'Choose a door.';
    // Html documents to write the scores
    var win = document.getElementById('win');
    win.innerHTML = numWin;
    var loss = document.getElementById('loss');
    loss.innerHTML = numLoss;

    //Score ratio
    var ratio = document.getElementById('ratio');
    //ratio.innerHTML = (ratioValue*100).toFixed(1);

    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
    var imageOpenDoor = new Image();
    var imageCloseDoor = new Image();
    var imageCheck = new Image();
    var imageGoat = new Image();
    var imageCar = new Image();
    // I have to figure out copyright of images. I'll put the sources on the front of each oen
    imageOpenDoor.src = 'img/open_door.png' // http://th08.deviantart.net/fs71/PRE/i/2012/109/8/d/open_door_png_by_glammgramma-d4wy185.png
    imageCloseDoor.src ='img/closed_door.png' // http://th01.deviantart.net/fs71/PRE/i/2012/109/6/f/closed_door_png_by_glammgramma-d4wy1cv.png
    imageCheck.src = 'img/check.png' // http://www.come4news.com/images/users/5454/check.png
    imageGoat.src = 'img/goat.png' //
    imageCar.src = 'img/car.png' // http://www.wpclipart.com/transportation/car/classic_cars/purple_muscle_car.png
    // Random choose doors for car and goats
    var carDoor = Math.floor(Math.random() * 3); // Door with car
    var goatDoors = []; // Doors with goats
    i = -1
    while(++i < 3) {
        if (i != carDoor) {goatDoors.push(i)};
    }
    imageCloseDoor.onload = function() {
        context.drawImage(imageCloseDoor, 0,0,200, 350);
        context.drawImage(imageCloseDoor, 200,0,200, 350);
        context.drawImage(imageCloseDoor, 400,0,200, 350);
    };


    var counter = 10;
    var id;

    id = setInterval(function() {

        if(counter < 0) {
            //newElement.parentNode.replaceChild(downloadButton, newElement);
            counter = 0;
        } else {
            ratio.innerHTML = counter.toString() + " seconds.";
        }
        counter--;


    }, 1000);

    // Initialize loop variables (the loop is a click event listener)
    var doors = [false,false,false]; // Open doors
    var turn = 0; // Game state (details below)
    var check = 0; // First door choosen
    var openDoor = 0; // Door choosen after stay or switch
    canvas.addEventListener('click', function(event) {
        var rect = canvas.getBoundingClientRect();
        var x = event.pageX - rect.left;
        var y = event.pageY - rect.top;
        /* Game states (turn):
         -1: Game is finished
         0: Player chose a door
         1: Player chose to stay or switch
         */

        if(turn == -1){ // Reset game
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

            stats.innerHTML = 'One more time? Choose a door.';
            counter = 10;
            ++turn;
        } else {
            if (turn == 0){ // Check clicked door
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
                if (turn > 0){ // Open final door
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
                        score += 100*(counter+1);
                        turn = -1;
                    }
                    else {
                        ++numLoss;
                        stats.innerHTML = 'Loser...';
                        turn = -10;

                    }
                    //ratioValue = 1.0*numWin/(numWin+numLoss);
                    // Update results
                    win.innerHTML = numWin;
                    loss.innerHTML = score;
                    window.alert(counter+1);
                    counter = 0;

                    // ratio.innerHTML = (ratioValue*100).toFixed(1);

                };

            }

        }

    }, false);
</script>
{{HTML::linkAction('GameController@result', 'Result')}}
</body>
</html>