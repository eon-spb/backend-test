package models

const DSN string = "host=localhost user=postgres password=postgres dbname=apartments sslmode=disable"

type Apartment struct {
	ID       string  `xml:"id,attr"`
	STotal   float32 `xml:"s_total,attr"`
	SLiving  float32 `xml:"s_living,attr"`
	SKitchen float32 `xml:"s_kitchen,attr"`
	Height   int     `xml:"height,attr"`
	Price    float64 `xml:"price,attr"`
	Floor    int     `xml:"floor,attr"`
}
