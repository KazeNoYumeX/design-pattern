package main

import (
	"fmt"
	"showdown-go/entity"
	"showdown-go/enum"
)

func main() {
	// show hello world
	fmt.Println("Hello, World!")

	card := entity.NewCard(enum.JACK, enum.CLUB)
	fmt.Println(card.GetRank().ToCardString())

	deck := entity.NewDeck()
	fmt.Println(deck)
}
