package entity

import (
	"showdown-go/enum"
)

// Card represents a playing card
type Card struct {
	rank enum.Rank
	suit enum.Suit
}

// GetRank returns the rank of the card
func (c *Card) GetRank() enum.Rank {
	return c.rank
}

// GetSuit returns the suit of the card
func (c *Card) GetSuit() enum.Suit {
	return c.suit
}

// NewCard creates a new card
func NewCard(rank enum.Rank, suit enum.Suit) *Card {
	return &Card{
		rank: rank,
		suit: suit,
	}
}
