package domain

type Apartments struct {
	ID       string  `xml:"id,attr"`
	STotal   float64 `xml:"s_total,attr"`
	SLiving  float64 `xml:"s_living,attr"`
	SKitchen float64 `xml:"s_kitchen,attr"`
	Height   string  `xml:"height,attr"`
	Price    float64 `xml:"price,attr"`
	Floor    int     `xml:"floor,attr,omitempty"`
}

type Data struct {
	Apartments []Apartments `xml:"apartments>apartment"`
}
