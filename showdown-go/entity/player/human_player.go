package player

import (
	"fmt"
	"math/rand"
	"showdown-go/entity"
)

type HumanPlayer struct {
	AbstractPlayer
}

func NewHumanPlayer(showdown *entity.Showdown) *HumanPlayer {
	return &HumanPlayer{
		AbstractPlayer{
			Hand:     entity.NewHand(),
			Showdown: *showdown,
		},
	}
}

func (h *HumanPlayer) ChooseAction() {
	// Randomly choose action
	if rand.Intn(2) == 1 {
		// exchange card and can't exchange myself
		num := rand.Intn(len(h.Showdown.GetPlayers()))
		player := h.Showdown.GetPlayers()[num]

		for player.GetName() == h.GetName() {
			num := rand.Intn(len(h.Showdown.GetPlayers()))
			player = h.Showdown.GetPlayers()[num]
		}

		exchangeHand := entity.NewExchangeHands(h, player)
		h.Showdown.AddExchangeHands(exchangeHand)
		h.SetExchangePermission(false)
	}

	targetPlayer := h.CheckChangeHands()
	targetCard := rand.Intn(len(targetPlayer.GetHand()))
	card := targetPlayer.GetHand()[targetCard]
	h.ShowCard(card)

	// Remove card from hand
	targetPlayer.GetHand()[targetCard] = nil
	targetPlayer.SetHand(targetPlayer.GetHand())
}

func (h *HumanPlayer) NameHimself() {
	// in go
	var name string
	fmt.Println("請輸入名稱: ")
	if _, err := fmt.Scanln(&name); err != nil {
		fmt.Println(err)
	}

	h.SetName(name)
}
