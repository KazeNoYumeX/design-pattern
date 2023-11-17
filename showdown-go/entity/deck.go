package entity

import (
	"math/rand"
	"showdown-go/enum"
)

type Deck struct {
	cards []*Card
}

func (d *Deck) Shuffle() {
	for i := len(d.cards) - 1; i > 0; i-- {
		j := rand.Intn(i + 1)
		d.cards[i], d.cards[j] = d.cards[j], d.cards[i]
	}
}

func (d *Deck) Draw() *Card {
	card := d.cards[len(d.cards)-1]
	d.cards = d.cards[:len(d.cards)-1]
	return card
}

func NewDeck() *Deck {
	cards := make([]*Card, 0)

	for _, suit := range enum.SuitCases() {
		for _, rank := range enum.RankCases() {
			cards = append(cards, NewCard(rank, suit))
		}
	}

	return &Deck{
		cards: cards,
	}
}
