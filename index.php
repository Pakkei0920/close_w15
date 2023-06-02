<!DOCTYPE html>
<html>
<head>
    <title>接水果遊戲</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        #game-container {
            position: relative;
            height: 600px;
            width: 100% ;
            border: 1px solid black;
            overflow: hidden;
        }
        .fruit {
            position: absolute;
            width: 40px;
            height: 40px;
            background-size: cover;
            border-radius: 50%;
            top: 0;
            transition: top 0.5s linear;
        }
        .apple {
            background-image: url('apple.png');
        }
        .banana {
            background-image: url('banana.png');
        }
        #line {
            position: absolute;
            width: 100px;
            height: 2px;
            background-color: black;
            bottom: 0;
            transition: left 0.2s linear;
        }
        #score {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>接水果遊戲</h1>
    <div id="game-container">
        <div id="line"></div>
    </div>
    <div id="score">Score: 0</div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var gameContainer = document.getElementById('game-container');
            var line = document.getElementById('line');
            var scoreElement = document.getElementById('score');
            
            var lineLeft = gameContainer.offsetWidth - line.offsetWidth;
            line.style.left = lineLeft + 'px';
            
            var score = 0;
            var fruitSpeed = 15;
            
            function createFruit() {
                var fruit = document.createElement('div');
                var randomFruit = Math.random() < 0.5 ? 'apple' : 'banana';
                fruit.className = 'fruit ' + randomFruit;
                fruit.style.left = Math.floor(Math.random() * (gameContainer.offsetWidth - 40)) + 'px';
                gameContainer.appendChild(fruit);

                var interval = setInterval(function() {
                    var topPos = fruit.offsetTop + fruitSpeed;
                    fruit.style.top = topPos + 'px';

                    if (topPos >= gameContainer.offsetHeight) {
                        clearInterval(interval);
                        fruit.remove();
                    }

                    if (topPos >= line.offsetTop - fruit.offsetHeight &&
                        fruit.offsetLeft >= line.offsetLeft &&
                        fruit.offsetLeft + fruit.offsetWidth <= line.offsetLeft + line.offsetWidth) {
                        clearInterval(interval);
                        fruit.remove();
                        score++;
                        scoreElement.innerText = 'Score: ' + score;

                        if (score === 31) {
                            endGame();
                        }
                    }
                }, 50);
            }

            function endGame() {
                alert('Game Over! Your score: 30 ');
                resetGame();
            }

            function resetGame() {
                var fruits = document.getElementsByClassName('fruit');
                while (fruits.length > 0) {
                    fruits[0].remove();
                }
                score = 0;
                fruitSpeed = 15;
                scoreElement.innerText = 'Score: 0';
                startGame();
            }

            function startGame() {
                var gameInterval = setInterval(function() {
                    createFruit();
                }, 1000);

                var speedInterval = setInterval(function() {
                    fruitSpeed += 6;
                }, 5000);
            }

            function updateLinePosition(value) {
                var maxRange = 4095;
                var containerWidth = gameContainer.offsetWidth;
                var lineOffsetWidth = line.offsetWidth;
                var newPosition = Math.floor((value / maxRange) * (containerWidth - lineOffsetWidth));

                if (newPosition < 0) {
                    lineLeft = 0;
                } else if (newPosition > containerWidth - lineOffsetWidth) {
                    lineLeft = containerWidth - lineOffsetWidth;
                } else {
                    lineLeft = newPosition;
                }
                
                line.style.left = lineLeft + 'px';
            }

            startGame();

            // Read data from data.txt
            function readData() {
                fetch('date.txt')
                    .then(response => response.text())
                    .then(data => {
                        var value = parseInt(data.trim());
                        updateLinePosition(value);
                    })
                    .catch(error => {
                        console.log('Error reading data:', error);
                    });
            }

            // Read data every 500 milliseconds
            setInterval(readData, 60);
        });
    </script>
</body>
</html>
