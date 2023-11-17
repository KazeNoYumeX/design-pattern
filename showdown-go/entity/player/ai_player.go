package player

import (
	"github.com/go-faker/faker/v4"
	"math/rand"
	"showdown-go/entity"
)

type AIPlayer struct {
	AbstractPlayer
}

func NewAIPlayer(showdown *entity.Showdown) *AIPlayer {
	return &AIPlayer{
		AbstractPlayer: NewAbstractPlayer(*showdown),
	}
}

func (a *AIPlayer) ChooseAction() {
	// Randomly choose action
	if rand.Intn(2) == 1 {
		// exchange card and can't exchange myself
		num := rand.Intn(len(a.Showdown.GetPlayers()))
		player := a.Showdown.GetPlayers()[num]

		for player.GetName() == a.GetName() {
			num := rand.Intn(len(a.Showdown.GetPlayers()))
			player = a.Showdown.GetPlayers()[num]
		}

		exchangeHand := entity.NewExchangeHands(a, player)
		a.Showdown.AddExchangeHands(exchangeHand)
		a.SetExchangePermission(false)
	}

	targetPlayer := a.CheckChangeHands()
	targetCard := rand.Intn(len(targetPlayer.GetHand()))
	card := targetPlayer.GetHand()[targetCard]
	a.ShowCard(card)

	// Remove card from hand
	targetPlayer.GetHand()[targetCard] = nil
	targetPlayer.SetHand(targetPlayer.GetHand())
}

func (a *AIPlayer) NameHimself() {
	a.SetName(faker.LastName())
}
