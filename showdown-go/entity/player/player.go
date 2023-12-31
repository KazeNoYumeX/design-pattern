package player

import (
	"showdown-go/entity"
)

type Player interface {
	GetID() int
	SetID(id int)
	ChooseAction()
	NameHimself()
	GetPoint() int
	GainPoint()
	GetName() string
	SetName(name string)
	GetHand() []*entity.Card
	SetHand(card *entity.Card)
	DrawCard(deck *entity.Deck)
	GetShowedCard() *entity.Card
	ShowCard(card *entity.Card)
	SetExchangePermission(bool bool)
	CheckChangeHands() *Player
}

type AbstractPlayer struct {
	ID                 int
	Name               string
	Hand               *entity.Hand
	Point              int
	ExchangePermission bool
	ShowedCard         *entity.Card
	Showdown           entity.Showdown
}

func (p *AbstractPlayer) ChooseAction() {
	//TODO implement me
	panic("implement me")
}

func (p *AbstractPlayer) NameHimself() {
	//TODO implement me
	panic("implement me")
}

func NewAbstractPlayer(showdown entity.Showdown, id int) AbstractPlayer {
	return AbstractPlayer{
		ID:       id,
		Hand:     entity.NewHand(),
		Showdown: showdown,
	}
}

func (p *AbstractPlayer) GetID() int {
	return p.ID
}

func (p *AbstractPlayer) SetID(id int) {
	p.ID = id
}

func (p *AbstractPlayer) GetPoint() int {
	return p.Point
}

func (p *AbstractPlayer) GainPoint() {
	p.Point++
}

func (p *AbstractPlayer) GetName() string {
	return p.Name
}

func (p *AbstractPlayer) SetName(name string) {
	p.Name = name
}

func (p *AbstractPlayer) GetHand() []*entity.Card {
	return p.Hand.Cards()
}

func (p *AbstractPlayer) SetHand(card *entity.Card) {
	p.Hand.SetCard(card)
}

func (p *AbstractPlayer) DrawCard(deck *entity.Deck) {
	card := deck.Draw()
	p.SetHand(card)
}

func (p *AbstractPlayer) GetShowedCard() *entity.Card {
	return p.ShowedCard
}

func (p *AbstractPlayer) ShowCard(card *entity.Card) {
	p.ShowedCard = card
}

func (p *AbstractPlayer) SetExchangePermission(bool bool) {
	p.ExchangePermission = bool
}

func (p *AbstractPlayer) CheckChangeHands() *Player {
	var targetPlayer Player

	targetPlayer = p
	exchangeHands := p.Showdown.GetExchangeHands()

	if len(exchangeHands) != 0 {
		for _, exchangeHand := range exchangeHands {
			if exchangeHand.GetTrader().GetID() == targetPlayer.GetID() {
				targetPlayer = exchangeHand.GetCounterparty()
			} else if exchangeHand.GetCounterparty() == targetPlayer {
				targetPlayer = exchangeHand.GetTrader()
			}
		}
	}

	return targetPlayer

}
