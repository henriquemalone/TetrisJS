//VARIÁVEIS E CONSTANTES 
var congelar = document.getElementById("congelar");
var retomar = document.getElementById("retomar");

var COLUNA = localStorage.getItem("COLUNA");
var LINHA = localStorage.getItem("LINHA");

const QUADRADO = 20;
const VAZIO = "#1E1E1E";

const contextoCanvasHtml = document.getElementById("tabuleiro").getContext("2d");

var parar = false;

var downscaleFactor = localStorage.getItem("scale");
contextoCanvasHtml.scale(downscaleFactor, downscaleFactor);
document.addEventListener("keydown", controlarTeclado);

const PECA_1 = [
    [
        [1, 1, 1, 1]
    ],
    [
        [1],
        [1],
        [1],
        [1]
    ]
];

const PECA_2 = [
    [
        [1, 1],
        [1, 1]
    ]
];

const PECA_3 = [
    [
        [1, 0],
        [1, 0],
        [1, 1]
    ],
    [
        [1, 1, 1],
        [1, 0, 0]
    ],
    [
        [1, 1],
        [0, 1],
        [0, 1]
    ],
    [
        [0, 0, 1],
        [1, 1, 1]
    ]
];

const PECA_4 = [
    [
        [0, 1],
        [0, 1],
        [1, 1]
    ],
    [
        [1, 0, 0],
        [1, 1, 1],
    ],
    [
        [1, 1],
        [1, 0],
        [1, 0]
    ],
    [
        [1, 1, 1],
        [0, 0, 1]
    ]
];

const PECA_5 = [
    [
        [0, 1, 0],
        [1, 1, 1]
    ],
    [
        [1, 0],
        [1, 1],
        [1, 0]
    ],
    [
        [1, 1, 1],
        [0, 1, 0],
    ],
    [
        [0, 1],
        [1, 1],
        [0, 1]
    ]
];

const PECA_6 = [
    [
        [1, 0, 1],
        [1, 1, 1]
    ],
    [
        [1, 1],
        [1, 0],
        [1, 1]
    ],
    [
        [1, 1, 1],
        [1, 0, 1]
    ],
    [
        [1, 1],
        [0, 1],
        [1, 1]
    ]
];


//ARRAY DE PEÇAS
const PECAS = [
    [PECA_1, "red"],
    [PECA_2, "green"],
    [PECA_3, "yellow"],
    [PECA_4, "purple"],
    [PECA_5, "pink"],
    [PECA_6, "blue"],
];

let pontuacao = 0;
let linhaEliminada = 0;
let tabuleiro = new Array(Array(LINHA));
let pecaEmJogo = criarNovaPeca();

//TAMANHO DO TABULEIRO
function verificarTamanho(tam) {
    if (tam == 1) {
        localStorage.setItem("COLUNA", 10);
        localStorage.setItem("LINHA", 20);
        localStorage.setItem("scale", 1.0);
    }
    if (tam == 2) {
        localStorage.setItem("COLUNA", 22);
        localStorage.setItem("LINHA", 44);
        localStorage.setItem("scale", 0.6);
    }

}

//BOTÕES CONGELAR E RETOMAR
function pararJogo() {
    parar = true;
    //gerenciarCronometro('parar');
    congelar.style.display = "none";
    retomar.style.display = "block";
}

function retornarJogo() {
    parar = false;
    subirPecaNova();
    //gerenciarCronometro('retomar');
    congelar.style.display = "block";
    retomar.style.display = "none";

}

//CRIAÇÃO DO TABULEIRO
function desenharQuadrado(x, y, color) {
    contextoCanvasHtml.fillStyle = color;
    contextoCanvasHtml.fillRect((x * QUADRADO), (y * QUADRADO), QUADRADO, QUADRADO);

    contextoCanvasHtml.strokeStyle = "#282828";
    contextoCanvasHtml.strokeRect((x * QUADRADO), (y * QUADRADO), QUADRADO, QUADRADO);
}

for (l = 0; l < LINHA; l++) {
    tabuleiro[l] = [];
    for (c = 0; c < COLUNA; c++) {
        tabuleiro[l][c] = VAZIO;
    }
}

function desenharTabuleiro() {
    for (l = 0; l < LINHA; l++) {
        for (c = 0; c < COLUNA; c++) {
            desenharQuadrado(c, l, tabuleiro[l][c]);
        }
    }
}

desenharTabuleiro();

function criarNovaPeca() {
    const zero = 0;
    const um = 1;

    let l = Math.floor(Math.random() * PECAS.length)

    return new Peca(PECAS[parseInt(l)][zero], PECAS[parseInt(l)][um]);
}

function Peca(pecaTetris, color) {
    this.pecaTetris = pecaTetris;
    this.color = color;
    this.pecaN = 0;
    this.pecaTetrisAtual = this.pecaTetris[0];
    this.x = 3;
    this.y = LINHA - (pecaTetris[0].length - 1);
}

//PREENCHER QUADRADOS E DESENHAR
Peca.prototype.preencher = function (color) {
    for (l = 0; l < this.pecaTetrisAtual.length; l++) {
        for (c = 0; c < this.pecaTetrisAtual[0].length; c++) {
            if (this.pecaTetrisAtual[l][c] && this.y + l < LINHA)
                desenharQuadrado(this.x + c, this.y + l, color);
        }
    }
}

Peca.prototype.desenhar = function () {
    for (l = 0; l < this.pecaTetrisAtual.length; l++) {
        for (c = 0; c < this.pecaTetrisAtual[0].length; c++) {
            if (this.pecaTetrisAtual[l][c] && this.y + l < LINHA)
                desenharQuadrado(this.x + c, this.y + l, this.color);
        }
    }
}

Peca.prototype.apagar = function () {
    this.preencher(VAZIO);
}

//CONTROLE DE DIREÇÕES
Peca.prototype.moverParaCima = function () {
    if (!this.colisao(0, -1, this.pecaTetrisAtual)) {
        this.apagar();
        this.y--;
        this.desenhar();
    } else {
        this.pararPecaTetris();
        pecaEmJogo = criarNovaPeca();
    }
}

Peca.prototype.moverParaDireita = function () {
    if (!this.colisao(1, 0, this.pecaTetrisAtual)) {
        this.apagar();
        this.x++;
        this.desenhar();
    }
}

Peca.prototype.moverParaEsquerda = function () {
    if (!this.colisao(-1, 0, this.pecaTetrisAtual)) {
        this.apagar();
        this.x--;
        this.desenhar();
    }
}

//ROTACIONA AS PEÇAS
Peca.prototype.rotacionar = function () {
    let proximo = this.pecaTetris[(this.pecaN + 1) % this.pecaTetris.length];
    let desloca = 0;

    if (this.colisao(0, 0, proximo))
        desloca = this.x > COLUNA / 2 ? -1 : 1;

    if (!this.colisao(desloca, 0, proximo)) {
        this.apagar();
        this.x += desloca;
        this.pecaN = (this.pecaN + 1) % this.pecaTetris.length;
        this.pecaTetrisAtual = this.pecaTetris[this.pecaN];
        this.desenhar();
    }
}

//CONTROLA AS SETAS DO TECLADO
function controlarTeclado(event) {
    if (event.keyCode == 37) {
        pecaEmJogo.moverParaEsquerda();
        subidaInicial = Date.now();
    } else if (event.keyCode == 38 && !gameOver) {
        pecaEmJogo.moverParaCima();
    } else if (event.keyCode == 39) {
        pecaEmJogo.moverParaDireita();
        subidaInicial = Date.now();
    } else if (event.keyCode == 40) {
        pecaEmJogo.rotacionar();
        subidaInicial = Date.now();
    }
}

//PARA UMA PEÇA AO COLIDIR COM OUTRO OU QUANDO CHEGA AO FINAL DO TABULEIRO
Peca.prototype.pararPecaTetris = function () {
    for (l = 0; l < this.pecaTetrisAtual.length; l++) {
        for (c = 0; c < this.pecaTetrisAtual[0].length; c++) {

            if (!this.pecaTetrisAtual[l][c]) {
                continue;
            }
            if (this.y + l >= LINHA) {
                encerrarJogo();
                return;
            }
            tabuleiro[this.y + l][this.x + c] = this.color;
        }
    }
    var quantidadeLinha = 0;

    for (let l = 0; l < LINHA; l++) {
        let linhaCheia = true;
        for (let c = 0; c < COLUNA; c++) {
            linhaCheia = linhaCheia && (tabuleiro[l][c] != VAZIO);
        }
        if (linhaCheia) {

            if (l != LINHA - 1) {
                for (let l2 = l; l2 < LINHA - 1; l2++) {
                    tabuleiro[l2] = tabuleiro[l2 + 1];
                }
                l--;
            } else {
                for (let c = 0; c < COLUNA; c++) {
                    tabuleiro[LINHA - 1][c] = VAZIO;
                }
            }
            quantidadeLinha++;
            linhaEliminada++;
        }
    }
    pontuacao += (quantidadeLinha * 10) * quantidadeLinha;
    document.getElementById("linhasEliminadas").textContent = linhaEliminada;

    desenharTabuleiro();
    document.getElementById("pontuacao").textContent = pontuacao;
}

//VERIFICA COLISÃO
Peca.prototype.colisao = function (x, y, peca) {
    for (l = 0; l < peca.length; l++) {
        for (c = 0; c < peca[0].length; c++) {
            if (!peca[l][c])
                continue;

            let novoX = this.x + c + x;
            let novoY = this.y + l + y;

            if (novoX < 0 || novoX >= COLUNA || novoY < 0 || novoY >= LINHA)
                return true;

            if (tabuleiro[novoY][novoX] != VAZIO)
                return true;

            if (novoY <= 0)
                continue;
        }
    }
    return false;
}

//GERENCIAMENTO DA SUBIDA DE CADA PEÇA
let subidaInicial = Date.now();
let gameOver = false;
let tempoSubida = 1000;
let dificuldadeDoJogo = 1;

function subirPecaNova() {
    let dataAtual = Date.now();
    let deltaTempo = dataAtual - subidaInicial;
    if (deltaTempo > tempoSubida) {
        pecaEmJogo.moverParaCima();
        subidaInicial = Date.now();
        if ((pontuacao % 500) == 0) {
            dificuldadeDoJogo = pontuacao / 500;
            aumentarTempoDoJogo();
        } else {
            aumentarTempoDoJogo();
        }
    }
    if (!gameOver && parar == false) {
        requestAnimationFrame(subirPecaNova);
    } else {

    }
}

subirPecaNova();

function salvaScore() {
    alert("entrou aqui")
}

//GERENCIAMENTO DO TEMPO DO JOGO E DO CRONOMETRO
function aumentarTempoDoJogo() {
    document.getElementById("nivelDificuldade").textContent = dificuldadeDoJogo;
    tempoSubida = (1000 - dificuldadeDoJogo * 3 < 100) ? 100 : 1000 - dificuldadeDoJogo * 3;
};

let tempo, intervalo, guardaTempo;

function gerenciarCronometro(acao) {
    if (acao == "iniciar") {
        tempo = -1;
        incrementarTempo();
        intervalo = setInterval(incrementarTempo, 1000);
    } else if (acao == 'parar') {
        pararCronometro();
    } else if (acao == 'retomar') {
        incrementarTempo();
        intervalo = setInterval(incrementarTempo, 1000);
    }

    function incrementarTempo() {
        tempo++;
        document.getElementById("cronometro").textContent =
            ("0" + Math.trunc(tempo / 60)).slice(-2) +
            ":" + ("0" + (tempo % 60)).slice(-2);
        guardaTempo = tempo;

    }

    function pararCronometro() {
        clearInterval(intervalo);
    }
}

function encerrarJogo() {
    gameOver = true;
    gerenciarCronometro("parar");
    var request = new XMLHttpRequest();
    request.open("GET", "../php/saveScore.php?score=" + pontuacao + "&nivel=" + dificuldadeDoJogo, true);

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(request.response);
            if (request.response == 'true') {
                alert("Game Over");
                location.reload();
            } else {
                alert("Ocorreu um erro ao gravar o ranking no banco");
            }
        }
    };

    request.send(null);
}

function mudarCor() {
    setInterval(function () {
        document.getElementById('tituloo').style.color = 'yellow';
    }, 1000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'red';
    }, 2000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'blue';
    }, 3000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'orange';
    }, 4000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'green';
    }, 5000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'pink';
    }, 6000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'white';
    }, 7000);

    setInterval(function () {
        document.getElementById('tituloo').style.color = 'purple';
    }, 8000);

}
