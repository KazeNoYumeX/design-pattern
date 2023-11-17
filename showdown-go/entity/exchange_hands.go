package entity

import players "showdown-go/entity/player"

type ExchangeHands struct {
	Duration     int
	Trader       players.Player
	Counterparty players.Player
}

func NewExchangeHands(trader players.Player, counterparty players.Player) *ExchangeHands {
	return &ExchangeHands{
		Trader:       trader,
		Counterparty: counterparty,
		Duration:     3,
	}
}

func (e *ExchangeHands) Countdown() {
	e.Duration--
}

func (e *ExchangeHands) GetTrader() players.Player {
	return e.Trader
}

func (e *ExchangeHands) GetCounterparty() players.Player {
	return e.Counterparty
}

func (e *ExchangeHands) GetDuration() int {
	return e.Duration
}
