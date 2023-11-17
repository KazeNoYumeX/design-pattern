package enum

type Rank int

const (
	TWO   Rank = iota + 2
	THREE Rank = iota + 2
	FOUR  Rank = iota + 2
	FIVE  Rank = iota + 2
	SIX   Rank = iota + 2
	SEVEN Rank = iota + 2
	EIGHT Rank = iota + 2
	NINE  Rank = iota + 2
	TEN   Rank = iota + 2
	JACK  Rank = iota + 2
	QUEEN Rank = iota + 2
	KING  Rank = iota + 2
	ACE   Rank = iota + 2
)

func (r Rank) ToCardString() string {
	switch r {
	case ACE:
		return "A"
	case TWO:
		return "2"
	case THREE:
		return "3"
	case FOUR:
		return "4"
	case FIVE:
		return "5"
	case SIX:
		return "6"
	case SEVEN:
		return "7"
	case EIGHT:
		return "8"
	case NINE:
		return "9"
	case TEN:
		return "10"
	case JACK:
		return "J"
	case QUEEN:
		return "Q"
	case KING:
		return "K"
	default:
		return ""
	}
}

func RankCases() []Rank {
	return []Rank{
		TWO,
		THREE,
		FOUR,
		FIVE,
		SIX,
		SEVEN,
		EIGHT,
		NINE,
		TEN,
		JACK,
		QUEEN,
		KING,
		ACE,
	}
}
