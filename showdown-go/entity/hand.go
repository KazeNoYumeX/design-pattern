package entity

type Hand struct {
	cards []*Card
}

func (h *Hand) Cards() []*Card {
	return h.cards
}

func (h *Hand) SetCard(card *Card) {
	h.cards = append(h.cards, card)
}

func (h *Hand) SetCards(cards []*Card) {
	h.cards = cards
}

func NewHand() *Hand {
	return &Hand{
		cards: make([]*Card, 0),
	}
}
