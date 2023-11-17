package enum

type Suit int

const (
	CLUB    Suit = iota
	DIAMOND Suit = iota
	HEART   Suit = iota
	SPADE   Suit = iota
)

func (s Suit) ToCardString() string {
	switch s {
	case CLUB:
		return "♣"
	case DIAMOND:
		return "♦"
	case HEART:
		return "♥"
	case SPADE:
		return "♠"
	default:
		return ""
	}
}

func SuitCases() []Suit {
	return []Suit{
		CLUB,
		DIAMOND,
		HEART,
		SPADE,
	}
}
