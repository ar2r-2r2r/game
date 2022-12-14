window.onload=function(){
    const announcer = document.querySelector('.announcer');
    const playerDisplay = document.querySelector('.display-player');
    const lvl=document.querySelector('.lvl');

    let board = ['', '', '', '', '', '', '', '', ''];
    let clickedArray=[];
    let currentPlayer = 'X';
    let isGameActive = true;
    let level=1;
    const winningConditions = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];
    const PLAYERX_WON = 'PLAYERX_WON';
    const PLAYERO_WON = 'PLAYERO_WON';
    const TIE = 'TIE';

    const isValidAction = (id) => {
        if(document.getElementById(id).innerText==='X' || document.getElementById(id).innerText==='O'){
            return false;
        }

        return true;
    };

    function handleResultValidation() {
        let roundWon = false;
        for (let i = 0; i <= 7; i++) {
            const winCondition = winningConditions[i];
            const a = board[winCondition[0]];
            const b = board[winCondition[1]];
            const c = board[winCondition[2]];
            if (a === '' || b === '' || c === '') {
                continue;
            }
            if (a === b && b === c) {
                roundWon = true;
                break;
            }
        } 

    if (roundWon) {
            announce(currentPlayer === 'X' ? PLAYERX_WON : PLAYERO_WON);
            if(currentPlayer==='X'){
                level++;
            }
            else{
                if(level>1){
                    level--;
                }
            }
            isGameActive = false;
            showLevel(level);
            setLevel(level);
            return;
        }

    if (!board.includes(''))
        announce(TIE);
    }

    const resetBoard = () => {
        board = ['', '', '', '', '', '', '', '', ''];
        clickedArray=[];
        isGameActive = true;
        announcer.classList.add('hide');

        if (currentPlayer === 'O') {
            changePlayer();
        }

        for(var i=0;i<9;i++){
            document.getElementById(i).innerText='';
            document.getElementById(i).classList.remove('playerX');
            document.getElementById(i).classList.remove('playerO');
        }
    }


    const announce = (type) => {
        switch(type){
            case PLAYERO_WON:
                announcer.innerHTML = '?????????? <span class="playerO">O</span> ??????????????!';
                break;
            case PLAYERX_WON:
                announcer.innerHTML = '?????????? <span class="playerX">X</span> ??????????????!';
                break;
            case TIE:
                announcer.innerText = '??????????!';
        }
        announcer.classList.remove('hide');
    };  

    const showLevel =(level)=>{
        lvl.innerText=level;
    }

    const changePlayer = () => {
        playerDisplay.classList.remove(`player${currentPlayer}`);
        currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
        playerDisplay.innerText = currentPlayer;
        playerDisplay.classList.add(`player${currentPlayer}`);
    }

    const updateBoard =  (id) => {
        board[id] = currentPlayer;
        clickedArray.push(id);
    }

    const userAction= (id)=>{
            document.getElementById(id).innerText=currentPlayer; 
            document.getElementById(id).classList.add(`player${currentPlayer}`);
            updateBoard(id);
            handleResultValidation();
            changePlayer();
    }

    const botAction=(id)=>{
        $.ajax({
            url:'botAnswer.php',
            type:'POST',
            data:{array:clickedArray},
            success:function(data){
                id=data;
                document.getElementById(id).innerText=currentPlayer; 
                document.getElementById(id).classList.add(`player${currentPlayer}`);
                updateBoard(id);
                handleResultValidation();
                changePlayer();
            }
        })
    }

    const getLevel=()=>{
        $.ajax({
            url:'getLevel.php',
            type:'POST',
            success:function(data){
                level=data;
                showLevel(level);
            }
        })
    }

    
    const setLevel=(level)=>{
        $.ajax({
            url:'setLevel.php',
            type:'POST',
            data:{level:level},
            
        })
    }


    const action=(id)=>{
        if(isValidAction(id) && isGameActive) {
            userAction(id);
        }
        if(isGameActive){
            botAction(id);
        }
    }
    getLevel();
    showLevel();
    $('.tile').on('click', function(event){
        let id=$(this).attr("id");
        if(event.target.className=='tile'){
            action(id);
        }
    })
    $('#reset').on('click', resetBoard);

}
