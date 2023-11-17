package entity

import (
	players "showdown-go/entity/player"
)

type Showdown struct {
	players       []*players.AbstractPlayer
	round         int
	exchangeHands []*ExchangeHands
	deck          *Deck
}

func NewShowdown(deck *Deck) *Showdown {
	return &Showdown{
		deck:          deck,
		exchangeHands: []*ExchangeHands{},
	}
}

func (s *Showdown) StartGame(numRealPlayers int, numAIPlayers int) {
	// Total players
	totalPlayers := numRealPlayers + numAIPlayers

	playerNum := 1
	for i := 0; i < numRealPlayers; i++ {
		player := players.NewHumanPlayer(s)
		player.NameHimself()
		s.AddPlayer(player)
		playerNum++
	}

	if numAIPlayers != 0 {
		for i := 0; i < numAIPlayers; i++ {
			player := players.NewAIPlayer(s)
			player.NameHimself()
			s.AddPlayer(player)
		}
	}

	for i := 0; i < totalPlayers; i++ {
		num := i + 1
		println("玩家", num, "名稱為：", s.players[i].GetName())
	}

	println("遊戲開始, 玩家總人數為: ", totalPlayers)

	println("開始洗牌")
	s.deck.Shuffle()
	println("開始抽牌")

	// Draw 13 cards for each player
	for i := 0; i < 13; i++ {
		for _, player := range s.players {
			player.DrawCard(s.deck)
		}
	}

	s.StartRound()
}

func (s *Showdown) AddPlayer(player *player.Player) {
	s.players = append(s.players, player)
}

func (s *Showdown) StartRound() {

	println("第", s.round, "回合開始")

	// Each player plays to choose an action
	for _, player := range s.players {
		player.ChooseAction()
	}

	s.CompareCards()
	s.EndRound()
}

func (s *Showdown) CompareCards() {
	var maximum *Card
	var maxIndex int

	for index, player := range s.players {
		card := player.GetShowedCard()

		if maximum == nil {
			maximum = card
		}

		// Compare card rank and suit
		if card.GetRank().Value > maximum.GetRank().Value {
			maximum = card
			maxIndex = index
		} else if card.GetRank().Value == maximum.GetRank().Value {
			if card.GetSuit().Value > maximum.GetSuit().Value {
				maximum = card
				maxIndex = index
			}
		}
	}

	if maximum == nil {
		println("本回合無人出牌")
	} else {
		suit := maximum.GetSuit().ToCardString()
		rank := maximum.GetRank().ToCardString()

		// Winner may be more than one
		winners := s.CompareScoreWithPlayers(s.players)

		var winnerNames []string
		var winnerPoints []int
		for _, winner := range winners {
			winnerNames = append(winnerNames, winner.GetName())
			winnerPoints = append(winnerPoints, winner.GetPoint())
		}

		println("本回合贏家為：", winnerNames, ", 目前得分為：", winnerPoints)
		println("最大的牌為：", suit, rank, "\n")
	}
}

func (s *Showdown) EndRound() {
	// Countdown exchange hands
	exchangeHands := s.GetExchangeHands()
	if len(exchangeHands) != 0 {
		for _, exchangeHand := range exchangeHands {
			exchangeHand.Countdown()
			if exchangeHand.GetDuration() == 0 {
				s.RemoveExchangeHands(exchangeHand)
			}
		}
	}

	println("第{$s.round}回合結束")
	s.round++
	if s.round > 13 {
		s.EndGame()
	} else {
		s.StartRound()
	}
}

func (s *Showdown) EndGame() {
	winners := s.CompareScoreWithPlayers(s.players)

	println("遊戲結束, 贏家為：")
	for _, winner := range winners {
		println("{$winner->GetName()}, 得分為：{$winner->GetPoint()} \n")
	}
}

func (s *Showdown) CompareScoreWithPlayers(players []*player.Player) []*player.Player {
	var playerPoints []int
	for _, player := range players {
		playerPoints = append(playerPoints, player.GetPoint())
	}

	// Winner may be more than one
	var winners []*player.Player
	for _, player := range players {
		if player.GetPoint() == max(playerPoints) {
			winners = append(winners, player)
		}
	}

	return winners
}

func (s *Showdown) GetPlayers() []*player.Player {
	return s.players
}

func (s *Showdown) GetExchangeHands() []ExchangeHands {
	return s.exchangeHands
}

func (s *Showdown) AddExchangeHands(exchangeHands *ExchangeHands) {
	s.exchangeHands = append(s.exchangeHands, exchangeHands)
}

func (s *Showdown) RemoveExchangeHands(exchangeHands *ExchangeHands) {
	var filtered []*ExchangeHands
	for _, hand := range s.exchangeHands {
		if hand != exchangeHands {
			filtered = append(filtered, hand)
		}
	}
	s.exchangeHands = filtered
}
