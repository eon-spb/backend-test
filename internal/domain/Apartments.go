package domain

type Apartments struct {
	ID       string `xml:"id,attr"`
	STotal   string `xml:"s_total,attr"`
	SLiving  string `xml:"s_living,attr"`
	SKitchen string `xml:"s_kitchen,attr"`
	Height   uint64 `xml:"height,attr"`
	Price    string `xml:"price,attr"`
	Floor    uint64 `xml:"floor,attr,omitempty"`
}

type Data struct {
	Apartments []Apartments `xml:"apartments>apartment"`
}
