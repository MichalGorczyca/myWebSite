class Statistics {

    constructor() {

        this.gameResult = [];

    }

    addGameToStatistics(win, bid) {

        let gameResult = {

            win,
            bid

        }

        this.gameResult.push(gameResult);

    } 

    showGameStatistics() {

        let games = this.gameResult.length;
        // let wonGames = 0;
        // let lossGames = 0;
        // this.gameResult.forEach(game => game.win === true ? wonGames++ : lossGames++)

        let wins = this.gameResult.filter(result => result.win).length;
        let losses = this.gameResult.filter(result => !result.win).length;

        return [games, wins, losses];

    }

}

const stats = new Statistics();